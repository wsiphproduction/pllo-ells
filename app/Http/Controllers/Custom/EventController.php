<?php

namespace App\Http\Controllers\Custom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\EventRequest;
use App\Http\Requests\EventFeedbackRequest;
use Facades\App\Helpers\FileHelper;
use App\Helpers\Setting;

use App\Mail\{EventInvitationMail, FeedbackMail};

use App\Models\{Page, Cluster, Agency, Member, FileDownload};
use App\Models\Custom\{Event, EventInvite, EventParticipant, EventFeedback};
use Auth;
use Carbon\Carbon;

class EventController extends Controller
{

    private $page_limit = 10;

    public function index(){

        if(!Auth::user()){
            return redirect()->route('home')->with('error', 'Access Denied');
        }

        $page = new Page();
        $page->name = 'Upcoming Events';

        // $events = Event::whereDate('date', '>=', Carbon::today())->orderBy('created_at', 'desc')->paginate($this->page_limit);

        $events = Event::whereDate('date', '>=', Carbon::today())
            ->where(function ($query) {
                $query->whereDate('date', '>', Carbon::today())
                    ->orWhere(function ($q) {
                        $q->whereDate('date', Carbon::today())
                            ->whereTime('end_time', '>=', Carbon::now()->toTimeString());
                    });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->page_limit);


        return view('theme.pages.events.index', compact('page', 'events'));
    }

    public function previous(){

        if(!Auth::user()){
            return redirect()->route('home')->with('error', 'Access Denied');
        }

        $page = new Page();
        $page->name = 'Previous Events';

        // $events = Event::whereDate('date', '<=', Carbon::today())->orderBy('created_at', 'desc')->paginate($this->page_limit);

        $events = Event::whereDate('date', '<=', Carbon::today())
            ->where(function ($query) {
                $query->whereDate('date', '<', Carbon::today())
                    ->orWhere(function ($q) {
                        $q->whereDate('date', Carbon::today())
                            ->whereTime('end_time', '<=', Carbon::now()->toTimeString());
                    });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->page_limit);

        return view('theme.pages.events.previous', compact('page', 'events'));
    }

    public function create(){

        if(!Auth::user()){
            return redirect()->route('home')->with('error', 'Access Denied');
        }

        $page = new Page();
        $page->name = 'Add Event';

        $clusters = Cluster::all();
        $agencies = Agency::all();
        $members = Member::all();

        return view('theme.pages.events.create', compact('page', 'clusters', 'agencies', 'members'));
    }

    public function store(EventRequest $request){
        $data = $request->validated();
        
        //EVENT
        $data['created_by'] = Auth::user()->id;
        $event = Event::create($data);

        // INVITATION FILE
        $invitation_file = $request->hasFile('invitation_file') ? FileHelper::move_to_folder($request->file('invitation_file'), 'events/'. $event->id .'/invitation')['url'] : null;
        $data['invitation_file'] = $invitation_file;
        
       if ($request->hasFile('attachments')) {
            $attachments = [];

            foreach ($request->file('attachments') as $attachment) {
                $file = FileHelper::move_to_folder($attachment, 'events/'. $event->id .'/attachments');
                if ($file && isset($file['url'])) {
                    $attachments[] = $file['url'];
                }
            }

            $data['attachments'] = json_encode($attachments);
        }

       if ($request->other_links) {
            $other_links = [];
            foreach ($request->other_links as $link) {
                $other_links[] = $link;
            }
            $data['other_links'] = json_encode($other_links);
        }

        $data['event_img'] = $request->hasFile('event_img') ? FileHelper::move_to_folder($request->file('event_img'), 'events/'. $event->id .'/cover')['url'] : null;
        
        $event->update($data);


        //INVITES
        
        if($request->cluster_id) {
            foreach ($request->cluster_id as $id) {
                EventInvite::create([
                    'event_id' => $event->id,
                    'type' => 'cluster',
                    'invited' =>  $id,
                    'invited_by' => $event->created_by,
                    'invitation_file' => $invitation_file
                ]);
            }
        }

        if($request->agency_id) {
            foreach ($request->agency_id as $index => $id) {
                EventInvite::create([
                    'event_id' => $event->id,
                    'type' => 'agency',
                    'invitation_file' => isset($request->individual_invitation_file[$id]) ? FileHelper::move_to_folder($request->file('individual_invitation_file')[$id], 'events/'. $event->id .'/invitation/custom/'. $id )['url'] : $invitation_file,
                    'invited' =>  $id,
                    'invited_by' => $event->created_by,
                    'participant_limit' => $request->participant_limit[$index]
                ]);
            }
        }

        if($request->member_id) {
            foreach ($request->member_id as $id) {
                EventInvite::create([
                    'event_id' => $event->id,
                    'type' => 'member',
                    'invited' =>  $id,
                    'invited_by' => $event->created_by,
                    'invitation_file' => $invitation_file
                ]);
            }
        }

        return redirect()->route('events.index')->with('success', 'You successfully added an event');
    }

    public function view($id){

        if(!Auth::user()){
            return redirect()->route('home')->with('error', 'Access Denied');
        }

        $event = Event::find($id);
        $events = Event::where('id', '<>', $id)->whereDate('date', '<=', Carbon::today())->orderBy('created_at', 'desc')->take(4)->get();

        $page = new Page();
        $page->name = $event->title;

        $members = Member::all();
        $user = Member::getMemberInfo(Auth::check() ? Auth::user()->id : 0);

        $downloads = FileDownload::where('event_id', $id)->first();

        return view('theme.pages.events.view', compact('page', 'event', 'events', 'members', 'user', 'downloads'));
    }

    public function invitees($id){

        if(!Auth::user()){
            return redirect()->route('home')->with('error', 'Access Denied');
        }

        $event = Event::find($id);
        $members = Member::all();

        $page = new Page();
        $page->name = 'List of Invitees';

        return view('theme.pages.events.invitees', compact('page', 'event', 'members'));
    }

    public function edit(Event $event){

        if(!Auth::user()){
            return redirect()->route('home')->with('error', 'Access Denied');
        }
        
        $page = new Page();
        $page->name = 'Edit Event';

        $clusters = Cluster::all();
        $agencies = Agency::all();
        $members = Member::all();

        $invitees = EventInvite::where('event_id', $event->id)->get();

        return view('theme.pages.events.edit', compact('page', 'clusters', 'agencies', 'members', 'event', 'invitees'));
    }

    public function update(EventRequest $request, Event $event){

        $data = $request->validated();

        // INVITATION FILE
        if ($request->hasFile('invitation_file')) {
            $invitation_file = $request->hasFile('invitation_file') ? FileHelper::move_to_folder($request->file('invitation_file'), 'events/'. $event->id .'/invitation')['url'] : null;
            $data['invitation_file'] = $invitation_file;
        }

        //EVENT
       if ($request->hasFile('attachments')) {
            $attachments = [];

            foreach ($request->file('attachments') as $attachment) {
                $file = FileHelper::move_to_folder($attachment, 'events/'. $event->id .'/attachments');
                if ($file && isset($file['url'])) {
                    $attachments[] = $file['url'];
                }
            }

            $data['attachments'] = json_encode($attachments);
        }

       if ($request->other_links) {
            $other_links = [];
            foreach ($request->other_links as $link) {
                $other_links[] = $link;
            }
            $data['other_links'] = json_encode($other_links);
        }

        if ($request->hasFile('event_img')) {
            $data['event_img'] = $request->hasFile('event_img') ? FileHelper::move_to_folder($request->file('event_img'), 'events/'. $event->id .'/cover')['url'] : null;
        }
        
        $event->update($data);


        //INVITES

        EventInvite::where('event_id', $event->id)->delete();

        $exisiting_invites = EventInvite::where('event_id', $event->id)->withTrashed()->get();

        // dd($exisiting_invites->where('type', 'cluster'));

       if($request->cluster_id) {
            $exisiting_cluster = $exisiting_invites->where('type', 'cluster')->pluck('invited')->toArray();

            foreach ($request->cluster_id as $id) {                
                if (in_array($id, $exisiting_cluster)) {
                    $invite = EventInvite::withTrashed()
                        ->where('event_id', $event->id)
                        ->where('type', 'cluster')
                        ->where('invited', $id)
                        ->first();

                    if ($invite) {
                        if ($invite->trashed()) {
                            $invite->restore();
                        }

                        $invite->update([
                            'invited_by' => $event->created_by,
                            'invitation_file' => $invitation_file,
                        ]);
                    }
                }
                else{
                    EventInvite::create([
                        'event_id' => $event->id,
                        'type' => 'cluster',
                        'invited' =>  $id,
                        'invited_by' => $event->created_by,
                        'invitation_file' => $invitation_file
                    ]);
                }
            }
        }

        if($request->agency_id) {
            $exisiting_agency = $exisiting_invites->where('type', 'agency')->pluck('invited')->toArray();

            foreach ($request->agency_id as $index => $id) {                
                if (in_array($id, $exisiting_agency)) {
                    $invite = EventInvite::withTrashed()
                        ->where('event_id', $event->id)
                        ->where('type', 'agency')
                        ->where('invited', $id)
                        ->first();

                    if ($invite) {
                        if ($invite->trashed()) {
                            $invite->restore();
                        }

                        $invite->update([
                            'invited_by' => $event->created_by,
                            'invitation_file' => $invitation_file,
                        ]);
                    }
                }
                else{
                    EventInvite::create([
                        'event_id' => $event->id,
                        'type' => 'agency',
                        'invitation_file' => isset($request->individual_invitation_file[$id]) ? FileHelper::move_to_folder($request->file('individual_invitation_file')[$id], 'events/'. $event->id .'/invitation/custom/'. $id )['url'] : $invitation_file,
                        'invited' =>  $id,
                        'invited_by' => $event->created_by,
                        'participant_limit' => $request->participant_limit[$index]
                    ]);
                }
            }
        }

        if($request->member_id) {
                
            $exisiting_member = $exisiting_invites->where('type', 'member')->pluck('invited')->toArray();

            foreach ($request->member_id as $id) {                
                if (in_array($id, $exisiting_member)) {
                    $invite = EventInvite::withTrashed()
                        ->where('event_id', $event->id)
                        ->where('type', 'member')
                        ->where('invited', $id)
                        ->first();

                    if ($invite) {
                        if ($invite->trashed()) {
                            $invite->restore();
                        }

                        $invite->update([
                            'invitation_file' => $invitation_file,
                            'invited_by' => $event->created_by,
                        ]);
                    }
                }
                else{
                    EventInvite::create([
                        'event_id' => $event->id,
                        'type' => 'member',
                        'invited' =>  $id,
                        'invited_by' => $event->created_by,
                        'invitation_file' => $invitation_file
                    ]);
                }
            }
        }

        // if($request->agency_id) {
        //     foreach ($request->agency_id as $index => $id) {
        //         EventInvite::create([
        //             'event_id' => $event->id,
        //             'type' => 'agency',
        //             'invitation_file' => isset($request->individual_invitation_file[$id]) ? FileHelper::move_to_folder($request->file('individual_invitation_file')[$id], 'events/'. $event->id .'/invitation/custom/'. $id )['url'] : $invitation_file,
        //             'invited' =>  $id,
        //             'invited_by' => $event->created_by,
        //             'participant_limit' => $request->participant_limit[$index]
        //         ]);
        //     }
        // }

        return redirect()->route('events.index')->with('success', 'You successfully updated an event');
    }

    public function cancel_event($id){
        Event::where('id', $id)->delete();

        return redirect()->route('events.index')->with('success', 'You successfully deleted an event');
    }

    public function register_event(Request $request, $event_id){

        $event = Event::find($event_id);

        foreach($request->member_id as $member_id){
            // EventParticipant::create([
            //     'event_id' => $event_id,
            //     'member_id' => $member_id
            // ]);

            $member = Member::find($member_id);
            \Mail::to($member->email)->send(new EventInvitationMail(Setting::info(), $member, $event));
        }

        if ($request->email) {
            foreach ($request->email as $index => $email) {
                $representative = (object)[
                    'firstname' => $request->fullname[$index] ?? null,
                    'designation' => $request->designation[$index] ?? null,
                    'email' => $email,
                    'contact_number' => $request->contact[$index] ?? null,
                ];

                \Mail::to($email)->send(new EventInvitationMail(Setting::info(), $representative, $event));
            }
        }

        return redirect()->back()->with('success', 'You successfully registered on this event');
    }

    // public function register_event($event_id){

    //     EventParticipant::create([
    //         'event_id' => $event_id,
    //         'member_id' => Member::getMemberInfo(Auth::user()->id)->id
    //     ]);

    //     return redirect()->back()->with('success', 'You successfully registered on this event');
    // }

    public function decline_event($event_id){

        EventParticipant::create([
            'event_id' => $event_id,
            'member_id' => Member::getMemberInfo(Auth::user()->id)->id,
            'status' => 0
        ]);

        return redirect()->back()->with('success', 'You successfully declined to participate on this event');
    }

    public function submit_feedback(EventFeedbackRequest $request, $event_id){

        $data = $request->validated();
        $event = EventFeedback::create($data);

        $member = Member::find($request->member_id);
        $event = Event::find($event_id);
        $downloadables = FileDownload::where('event_id', $event_id)->first();

        \Mail::to($member->email)->send(new FeedbackMail(Setting::info(), $member, $event, $downloadables));

        return redirect()->back()->with('success', 'You successfully submit a feedback, you can now see the downloadable files from the activity.');
    }

}
