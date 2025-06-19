<?php

namespace App\Http\Controllers\Custom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\EventRequest;
use Facades\App\Helpers\FileHelper;

use App\Models\{Page, Cluster, Agency, Member};
use App\Models\Custom\{Event, EventInvite, EventParticipant};


class EventController extends Controller
{

    public function index(){

        $page = new Page();
        $page->name = 'Events';

        $events = Event::all();

        return view('theme.pages.events.index', compact('page', 'events'));
    }

    public function create(){

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
        $data['created_by'] = 1; //auth()->id();
        $event = Event::create($data);

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
        
        $data['event_img'] = $request->hasFile('event_img') ? FileHelper::move_to_folder($request->file('event_img'), 'events/'. $event->id .'/cover')['url'] : null;
        
        $event->update($data);


        //INVITES
        $invitation_file = $request->hasFile('invitation_file') ? FileHelper::move_to_folder($request->file('invitation_file'), 'events/'. $event->id .'/invitation')['url'] : null;
        
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

        return redirect()->back()->with('success', 'You successfully added an event');
    }

    public function view($id){

        $event = Event::find($id);

        $page = new Page();
        $page->name = $event->title;

        return view('theme.pages.events.view', compact('page', 'event'));
    }

    public function edit(Event $event){
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

        // dd($data);
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

        if ($request->hasFile('event_img')) {
            $data['event_img'] = $request->hasFile('event_img') ? FileHelper::move_to_folder($request->file('event_img'), 'events/'. $event->id .'/cover')['url'] : null;
        }
        
        $event->update($data);


        //INVITES
        if ($request->hasFile('invitation_file')) {
            $invitation_file = $request->hasFile('invitation_file') ? FileHelper::move_to_folder($request->file('invitation_file'), 'events/'. $event->id .'/invitation')['url'] : null;
        }

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

        return redirect()->back()->with('success', 'You successfully updated an event');
    }

    public function cancel_event($id){
        Event::where('id', $id)->delete();

        return redirect()->route('events.index')->with('success', 'You successfully deleted an event');
    }
}
