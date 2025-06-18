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

        return  view('theme.pages.events.index', compact('page', 'events'));
    }

    public function create(){

        $page = new Page();
        $page->name = 'Add Event';

        $clusters = Cluster::all();
        $agencies = Agency::all();
        $members = Member::all();

        return  view('theme.pages.events.create', compact('page', 'clusters', 'agencies', 'members'));
    }

    public function store(EventRequest $request){
        $newData = $request->validated();

        //EVENT
        $newData['created_by'] = 1; //auth()->id();
        $event = Event::create($newData);

       if ($request->hasFile('attachments')) {
            $attachments = [];

            foreach ($request->file('attachments') as $attachment) {
                $file = FileHelper::move_to_folder($attachment, 'events/'. $event->id .'/attachments');
                if ($file && isset($file['url'])) {
                    $attachments[] = $file['url'];
                }
            }

            $newData['attachments'] = json_encode($attachments);
        }
        
        $newData['event_img'] = $request->hasFile('event_img') ? FileHelper::move_to_folder($request->file('event_img'), 'events/'. $event->id .'/cover')['url'] : null;
        
        $event->update($newData);


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

        return  view('theme.pages.events.view', compact('page', 'event'));
    }
}
