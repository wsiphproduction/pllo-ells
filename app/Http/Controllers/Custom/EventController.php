<?php

namespace App\Http\Controllers\Custom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\{EventRequest, EventFeedbackRequest, EventDownloadableRequest};
use Facades\App\Helpers\FileHelper;
use App\Helpers\Setting;

use App\Mail\{EventInvitationMail, EventParticipationMail, FeedbackMail};

use App\Models\{Page, Cluster, Agency, Member, FileDownload};
use App\Models\Custom\{Event, EventInvite, EventParticipant, EventFeedback, EventDownloadable};
use Auth;
use Carbon\Carbon;

class EventController extends Controller
{

    private $page_limit = 10;

    public function index(){

        if(!Auth::user()){
            session(['url.intended' => url()->current()]);
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
            session(['url.intended' => url()->current()]);
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

                // $representative = Member::find($id);
                // \Mail::to($representative->email)->send(new EventInvitationMail(Setting::info(), $representative, $event));
            }
        }

        //INVITATION EMAIL
        // $members = Member::all();

        // foreach($members as $member){
        //     if(Event::isUserInvited($member->id, $event->id)){
        //         \Mail::to($member->email)->send(new EventInvitationMail(Setting::info(), $member, $event));
        //     }
        // }

        session()->flash('new_event_id', $event->id);

        return redirect()->route('events.view', $event->id)->with('success', 'You successfully added an event');
        // return redirect()->route('events.invitation', $event->id)->with('success', 'You successfully added an event');
        // return redirect()->route('events.index')->with('success', 'You successfully added an event');
    }

    public function invitation(Event $event){

        if(!Auth::user()){
            return redirect()->route('home')->with('error', 'Access Denied');
        }

        $page = new Page();
        $page->name = 'Send Invitation Mail';

        $default = [
            'contents' => '<div class="container"><div class="text-center"><h3 id="ivz5">Legislative Liaison System</h3><h2 id="i5lh">Presidential Legislative Liaison Office</h2></div><div class="text-center">
                                {photo}
                            </div><p>Hi, {name}!</p><p>
                                I have the honor to inform you that the Presidential
                                Legislative Liaison Office (PLLO) will conduct an activity to participate in the event entitled, 
                                <span class="text-primary"><strong>{title_event}</strong></span>.
                            </p><ul><li><strong>Cluster:</strong> {cluster}</li><li><strong>Date:</strong> {date}</li><li><strong>Time:</strong> {time}</li><li><strong>Location:</strong> {venue}</li></ul><p>You can download the invitation letter here:</p>

                            {invitation_letter}

                            <p>You can download the other materials for the event:</p>

                            {other_materials}

                            <p>Link for other materials:</p>

                            {link_other_materials}

                            <div class="text-center">
                                {qrcode_invitation}
                            </div><div class="text-center"><a href="{link_invitation}" class="btn">VIEW EVENT</a></div><div class="footer">
                                Presidential Legislative Liaison Office <br/>
                                National Government Center, Quezon City, Philippines <br/>
                                +63 (02) 1234 5678 | info@pllo.gov.ph
                            </div></div>',
            'json' => '{"gjs-html":"<div class=\"container\"><div class=\"text-center\"><h3 id=\"ivz5\">Legislative Liaison System</h3><h2 id=\"i5lh\">Presidential Legislative Liaison Office</h2></div><div class=\"text-center\">\n\t\t\t\t{photo}\n\t\t\t</div><p>Hi, {name}!</p><p>\n\t\t\t\tI have the honor to inform you that the Presidential\n\t\t\t\tLegislative Liaison Office (PLLO) will conduct an activity to participate in the event entitled, \n\t\t\t\t<span class=\"text-primary\"><strong>{title_event}</strong></span>.\n\t\t\t</p><ul><li><strong>Cluster:</strong> {cluster}</li><li><strong>Date:</strong> {date}</li><li><strong>Time:</strong> {time}</li><li><strong>Location:</strong> {venue}</li></ul><p>You can download the invitation letter here:</p>\n\n\t\t\t{invitation_letter}\n\n\t\t\t<p>You can download the other materials for the event:</p>\n\n            {other_materials}\n\n\t\t\t<p>Link for other materials:</p>\n\n            {link_other_materials}\n\n\t\t\t<div class=\"text-center\">\n\t\t\t\t{qrcode_invitation}\n\t\t\t</div><div class=\"text-center\"><a href=\"{link_invitation}\" class=\"btn\">VIEW EVENT</a></div><div class=\"footer\">\n\t\t\t\tPresidential Legislative Liaison Office <br/>\n\t\t\t\tNational Government Center, Quezon City, Philippines <br/>\n\t\t\t\t+63 (02) 1234 5678 | info@pllo.gov.ph\n\t\t\t</div></div>","gjs-components":"[{\"type\":\"container\",\"classes\":[\"container\"],\"components\":[{\"classes\":[\"text-center\"],\"components\":[{\"tagName\":\"h3\",\"type\":\"header\",\"attributes\":{\"id\":\"ivz5\"},\"components\":[{\"type\":\"textnode\",\"content\":\"Legislative Liaison System\"}]},{\"tagName\":\"h2\",\"type\":\"header\",\"attributes\":{\"id\":\"i5lh\"},\"components\":[{\"type\":\"textnode\",\"content\":\"Presidential Legislative Liaison Office\"}]}]},{\"type\":\"text\",\"classes\":[\"text-center\"],\"components\":[{\"type\":\"textnode\",\"content\":\"\\n\\t\\t\\t\\t{photo}\\n\\t\\t\\t\"}]},{\"type\":\"paragraph\",\"components\":[{\"type\":\"textnode\",\"content\":\"Hi, {name}!\"}]},{\"type\":\"paragraph\",\"components\":[{\"type\":\"textnode\",\"content\":\"\\n\\t\\t\\t\\tI have the honor to inform you that the Presidential\\n\\t\\t\\t\\tLegislative Liaison Office (PLLO) will conduct an activity to participate in the event entitled, \\n\\t\\t\\t\\t\"},{\"tagName\":\"span\",\"classes\":[\"text-primary\"],\"components\":[{\"tagName\":\"strong\",\"type\":\"text\",\"components\":[{\"type\":\"textnode\",\"content\":\"{title_event}\"}]}]},{\"type\":\"textnode\",\"content\":\".\\n\\t\\t\\t\"}]},{\"tagName\":\"ul\",\"components\":[{\"tagName\":\"li\",\"type\":\"text\",\"components\":[{\"tagName\":\"strong\",\"type\":\"text\",\"components\":[{\"type\":\"textnode\",\"content\":\"Cluster:\"}]},{\"type\":\"textnode\",\"content\":\" {cluster}\"}]},{\"tagName\":\"li\",\"type\":\"text\",\"components\":[{\"tagName\":\"strong\",\"type\":\"text\",\"components\":[{\"type\":\"textnode\",\"content\":\"Date:\"}]},{\"type\":\"textnode\",\"content\":\" {date}\"}]},{\"tagName\":\"li\",\"type\":\"text\",\"components\":[{\"tagName\":\"strong\",\"type\":\"text\",\"components\":[{\"type\":\"textnode\",\"content\":\"Time:\"}]},{\"type\":\"textnode\",\"content\":\" {time}\"}]},{\"tagName\":\"li\",\"type\":\"text\",\"components\":[{\"tagName\":\"strong\",\"type\":\"text\",\"components\":[{\"type\":\"textnode\",\"content\":\"Location:\"}]},{\"type\":\"textnode\",\"content\":\" {venue}\"}]}]},{\"type\":\"paragraph\",\"components\":[{\"type\":\"textnode\",\"content\":\"You can download the invitation letter here:\"}]},{\"type\":\"textnode\",\"content\":\"\\n\\n\\t\\t\\t{invitation_letter}\\n\\n\\t\\t\\t\"},{\"type\":\"paragraph\",\"components\":[{\"type\":\"textnode\",\"content\":\"You can download the other materials for the event:\"}]},{\"type\":\"textnode\",\"content\":\"\\n\\n            {other_materials}\\n\\n\\t\\t\\t\"},{\"type\":\"paragraph\",\"components\":[{\"type\":\"textnode\",\"content\":\"Link for other materials:\"}]},{\"type\":\"textnode\",\"content\":\"\\n\\n            {link_other_materials}\\n\\n\\t\\t\\t\"},{\"type\":\"text\",\"classes\":[\"text-center\"],\"components\":[{\"type\":\"textnode\",\"content\":\"\\n\\t\\t\\t\\t{qrcode_invitation}\\n\\t\\t\\t\"}]},{\"classes\":[\"text-center\"],\"components\":[{\"type\":\"button\",\"classes\":[\"btn\"],\"attributes\":{\"href\":\"{link_invitation}\"},\"components\":[{\"type\":\"textnode\",\"content\":\"VIEW EVENT\"}]}]},{\"type\":\"text\",\"classes\":[\"footer\"],\"components\":[{\"type\":\"textnode\",\"content\":\"\\n\\t\\t\\t\\tPresidential Legislative Liaison Office \"},{\"tagName\":\"br\",\"void\":true},{\"type\":\"textnode\",\"content\":\"\\n\\t\\t\\t\\tNational Government Center, Quezon City, Philippines \"},{\"tagName\":\"br\",\"void\":true},{\"type\":\"textnode\",\"content\":\"\\n\\t\\t\\t\\t+63 (02) 1234 5678 | info@pllo.gov.ph\\n\\t\\t\\t\"}]}]}]","gjs-assets":"[]","gjs-css":"* { box-sizing: border-box; } body {margin: 0;}body{font-family:\"Segoe UI\", Tahoma, Geneva, Verdana, sans-serif;background:#f9f9f9;margin:0;padding:0;}.container{max-width:700px;margin:30px auto;background:#ffffff;padding:30px 40px;}.text-center{text-align:center;}h2, h3{margin:10px 0;font-weight:normal;}ul{padding-left:20px;}a{color:#0d6efd;text-decoration:none;}.text-primary{color:#0d6efd;}.logo-group img{height:80px;margin:0 10px;}.btn{background-color:#3c5d90;color:#fff;padding:10px 20px;text-decoration:none;display:inline-block;margin-top:30px;border-radius:4px;}.footer{text-align:center;font-size:12px;color:#999;margin-top:30px;padding:20px;border-top:1px solid #eee;}#ivz5{font-size:28px;}#i5lh{font-size:22px;border-top:1px solid #aaa;padding-top:10px;}","gjs-styles":"[{\"selectors\":[],\"selectorsAdd\":\"body\",\"style\":{\"font-family\":\"\\\"Segoe UI\\\", Tahoma, Geneva, Verdana, sans-serif\",\"background\":\"#f9f9f9\",\"margin\":\"0\",\"padding\":\"0\"}},{\"selectors\":[\"container\"],\"style\":{\"max-width\":\"700px\",\"margin\":\"30px auto\",\"background\":\"#ffffff\",\"padding\":\"30px 40px\"}},{\"selectors\":[\"text-center\"],\"style\":{\"text-align\":\"center\"}},{\"selectors\":[],\"selectorsAdd\":\"h2, h3\",\"style\":{\"margin\":\"10px 0\",\"font-weight\":\"normal\"}},{\"selectors\":[],\"selectorsAdd\":\"ul\",\"style\":{\"padding-left\":\"20px\"}},{\"selectors\":[],\"selectorsAdd\":\"a\",\"style\":{\"color\":\"#0d6efd\",\"text-decoration\":\"none\"}},{\"selectors\":[\"text-primary\"],\"style\":{\"color\":\"#0d6efd\"}},{\"selectors\":[],\"selectorsAdd\":\".logo-group img\",\"style\":{\"height\":\"80px\",\"margin\":\"0 10px\"}},{\"selectors\":[\"btn\"],\"style\":{\"background-color\":\"#3c5d90\",\"color\":\"#fff\",\"padding\":\"10px 20px\",\"text-decoration\":\"none\",\"display\":\"inline-block\",\"margin-top\":\"30px\",\"border-radius\":\"4px\"}},{\"selectors\":[\"footer\"],\"style\":{\"text-align\":\"center\",\"font-size\":\"12px\",\"color\":\"#999\",\"margin-top\":\"30px\",\"padding\":\"20px\",\"border-top\":\"1px solid #eee\"}},{\"selectors\":[\"banner\"],\"style\":{\"width\":\"100%\",\"max-width\":\"500px\",\"margin\":\"20px auto\",\"display\":\"block\"}},{\"selectors\":[\"#ivz5\"],\"style\":{\"font-size\":\"28px\"}},{\"selectors\":[\"#i5lh\"],\"style\":{\"font-size\":\"22px\",\"border-top\":\"1px solid #aaa\",\"padding-top\":\"10px\"}}]"}',
            'styles' => '* { box-sizing: border-box; } body {margin: 0;}body{font-family:"Segoe UI", Tahoma, Geneva, Verdana, sans-serif;background:#f9f9f9;margin:0;padding:0;}.container{max-width:700px;margin:30px auto;background:#ffffff;padding:30px 40px;}.text-center{text-align:center;}h2, h3{margin:10px 0;font-weight:normal;}ul{padding-left:20px;}a{color:#0d6efd;text-decoration:none;}.text-primary{color:#0d6efd;}.logo-group img{height:80px;margin:0 10px;}.btn{background-color:#3c5d90;color:#fff;padding:10px 20px;text-decoration:none;display:inline-block;margin-top:30px;border-radius:4px;}.footer{text-align:center;font-size:12px;color:#999;margin-top:30px;padding:20px;border-top:1px solid #eee;}#ivz5{font-size:28px;}#i5lh{font-size:22px;border-top:1px solid #aaa;padding-top:10px;}'
        ];

        return view('theme.pages.events.invitation', compact('page', 'event', 'default'));
    }

    public function invitation_update(Event $event, Request $request){

        $event->update([
            'contents' => $request->contents,
            'json' => $request->json,
            'styles' => $request->styles
        ]);

        if($request->action == "Save & Send"){

            //INVITATION EMAIL
            $members = Member::all();

            foreach($members as $member){
                if(Event::isUserInvited($member->id, $event->id)){
                    \Mail::to($member->email)->send(new EventInvitationMail(Setting::info(), $member, $event));
                }
            }

            $event->update([
                'invitation_sent' => 1
            ]);

            return redirect()->route('events.view', $event->id)->with('success', 'You successfully sent invitation email');
        }

        session()->forget('new_event_id');

        return redirect()->route('events.view', $event->id)->with('success', 'You successfully saved invitation email');
    }

    public function view($id){

        if(!Auth::user()){
            session(['url.intended' => url()->current()]);
            return redirect()->route('home')->with('error', 'Access Denied');
        }

        $event = Event::find($id);
        $events = Event::where('id', '<>', $id)->whereDate('date', '<=', Carbon::today())->orderBy('created_at', 'desc')->take(4)->get();
        $event_agencies = EventInvite::where('event_id', $id)->where('type', 'agency')->get();
        
        $page = new Page();
        $page->name = $event->title;

        $members = Member::all();
        $user = Member::getMemberInfo(Auth::check() ? Auth::user()->id : 0);

        $downloads = EventDownloadable::where('type', 'Materials')->where('event_id', $id)->first();
        $certificates = EventDownloadable::where('type', 'Certificates')->where('event_id', $id)->first();
        // $downloads = FileDownload::where('event_id', $id)->first();

        $participants = EventParticipant::where('event_id', $id)->where('status', 1)->get();

        return view('theme.pages.events.view', compact('page', 'event', 'events', 'members', 'user', 'downloads', 'certificates', 'event_agencies', 'participants'));
    }

    public function invitees($id){
        if(!Auth::user()){
            return redirect()->route('home')->with('error', 'Access Denied');
        }

        $event = Event::find($id);
        $agencies = Agency::all();
        // $members = Member::all();

        $members = Member::query();

        if (request('search')) {
            $members->where(function ($query) {
                $search = request('search');
                $query->where('firstname', 'like', "%{$search}%")
                    ->orWhere('lastname', 'like', "%{$search}%")
                    ->orWhere('contact_number', 'like', "%{$search}%")
                    ->orWhere('other_number', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if (request('agency')) {
            $members->where(function ($query) {
                $search = request('agency');
                $query->where('agency', 'like', "%{$search}%");
            });
        }

        // if (request('status')) {
        //     $members->where(function ($query) {
        //         $search = request('status');
        //         $query->where('status', 'like', "%{$search}%");
        //     });
        // }

        $members = $members->orderByDesc('id')->get();

        $page = new Page();
        $page->name = 'List of Invitees';

        return view('theme.pages.events.invitees', compact('page', 'event', 'agencies', 'members'));
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
                            'invitation_file' => isset($request->individual_invitation_file[$id]) ? FileHelper::move_to_folder($request->file('individual_invitation_file')[$id], 'events/'. $event->id .'/invitation/custom/'. $id )['url'] : $invitation_file,
                            'participant_limit' => $request->participant_limit[$index]
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

        return redirect()->route('events.view', $event->id)->with('success', 'You successfully updated an event');
        // return redirect()->route('events.index')->with('success', 'You successfully updated an event');
    }

    public function cancel_event($id){
        Event::where('id', $id)->delete();

        return redirect()->route('events.index')->with('success', 'You successfully deleted an event');
    }

    public function register_event(Request $request, $event_id){

        $event = Event::find($event_id);

        foreach($request->member_id as $member_id){
            EventParticipant::create([
                'event_id' => $event_id,
                'member_id' => $member_id
            ]);

            $member = Member::find($member_id);
            \Mail::to($member->email)->send(new EventParticipationMail(Setting::info(), $member, $event));
        }

        if ($request->email) {
            foreach ($request->email as $index => $email) {
                $representative = (object)[
                    'firstname' => $request->fullname[$index] ?? null,
                    'designation' => $request->designation[$index] ?? null,
                    'email' => $email,
                    'contact_number' => $request->contact[$index] ?? null,
                ];

                \Mail::to($email)->send(new EventParticipationMail(Setting::info(), $representative, $event));
            }
        }

        return redirect()->back()->with('success', 'You successfully registered on this event');
    }

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

        $downloadables = EventDownloadable::where('type', 'Materials')->where('event_id', $event_id)->first();
        $certificates = EventDownloadable::where('type', 'Certificates')->where('event_id', $event_id)->first();
        // $downloadables = FileDownload::where('event_id', $event_id)->first();

        \Mail::to($member->email)->send(new FeedbackMail(Setting::info(), $member, $event, $downloadables, $certificates));

        return redirect()->back()->with('success', 'You successfully submit a feedback, you can now see the downloadable files from the activity.');
    }

    public function feedbacks(Event $event){

        if(!Auth::user()){
            return redirect()->route('home')->with('error', 'Access Denied');
        }

        $feedbacks = EventFeedback::where('event_Id', $event->id)->get();

        $page = new Page();
        $page->name = 'Event Feedback';

        return view('theme.pages.events.feedbacks', compact('page', 'event', 'feedbacks'));
    }

    public function upload_downloadables(EventDownloadableRequest $request, $event_id){

        $data = $request->validated();

        $data['event_id'] = $event_id;
        $data['created_by'] = Auth::user()->id;

        $downloadable = EventDownloadable::where('type', $request->type)->where('event_id', $event_id)->first();

        if(!$downloadable){
            $downloadable = EventDownloadable::create($data);
        }


        if ($request->member_id) {
            $member_ids = [];

            foreach ($request->member_id as $member){
                $member_ids[] = $member;
            }

            $data['member_id'] = json_encode($member_ids);

            $downloadable->update([
                'member_id' => $data['member_id']
            ]);
        }

        if ($request->hasFile('attachments')) {
            $file_url = [];

            foreach ($request->file('attachments') as $attachment) {
                $file = FileHelper::move_to_folder($attachment, 'events/'. $event_id .'/downloadables/' .$request->type);
                if ($file && isset($file['url'])) {
                    $file_url[] = $file['url'];
                }
            }

            $data['attachments'] = json_encode($file_url);

            $downloadable->update([
                'attachments' => $data['attachments']
            ]);
        }
        
        $downloadable->update($data);
        
        return redirect()->back()->with('success', 'You successfully uploaded files');
    }

    public function update_certificate(EventDownloadableRequest $request, $event_id)
    {
        $event = EventDownloadable::where('event_id', $event_id)->where('type', 'Certificates')->firstOrFail();

        $certificates = json_decode($event->attachments);  // existing attachments
        $member_ids = json_decode($event->member_id);       // existing member ids
        $data = $request->validated();

        $updated = false;

        foreach ($member_ids as $index => $member_id) {
            if ($member_id == $request->member_id) {
                if ($request->hasFile('attachment')) {
                    $file = $request->file('attachment')[0]; // Single file
                    $file_url = FileHelper::move_to_folder($file, 'events/' . $event_id . '/downloadables/' . $request->type);

                    if ($file_url && isset($file_url['url'])) {
                        $certificates[$index] = $file_url['url'];
                    }
                } else {
                    // No file uploaded, so remove the certificate for this index
                    unset($certificates[$index]);
                    unset($member_ids[$index]);
                }

                $updated = true;
                break;
            }
        }

        // Reindex arrays to keep proper structure
        $certificates = array_values($certificates);
        $member_ids = array_values($member_ids);

        if ($updated) {
            $event->update([
                'attachments' => json_encode($certificates),
                'member_id' => json_encode($member_ids),
            ]);

            return redirect()->back()->with('success', 'Certificate updated successfully.');
        }

        return redirect()->back()->with('error', 'Member not found or no file uploaded.');
    }

    public function update_downloadable(EventDownloadableRequest $request, $event_id)
    {
        $event = EventDownloadable::where('event_id', $event_id)->where('type', 'Materials')->firstOrFail();
        $downloadables = json_decode($event->attachments);  // existing attachments

        $data = $request->validated();

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment')[0]; // Single file
            $file_url = FileHelper::move_to_folder($file, 'events/' . $event_id . '/downloadables/' . $request->type);

            if ($file_url && isset($file_url['url'])) {
                $downloadables[$request->file_index] = $file_url['url'];
            }
        } else {
            // No file uploaded, so remove the certificate for this index
            unset($downloadables[$request->file_index]);
        }

        // Reindex arrays to keep proper structure
        $downloadables = array_values($downloadables);

            $event->update([
                'attachments' => json_encode($downloadables),
            ]);


        return redirect()->back()->with('success', 'Dowloadables updated successfully.');
    }

}
