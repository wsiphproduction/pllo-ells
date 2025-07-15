<?php

namespace App\Models\Custom;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'events';
    protected $fillable = [ 'title', 'description', 'event_cluster_id', 'date', 'start_time', 'end_time', 'location', 'attachments', 'other_links', 'event_img', 'created_by'];


    public function cluster()
    {
        return $this->belongsTo(\App\Models\Cluster::class, 'event_cluster_id');
    }

    public function agency()
    {
        return $this->belongsTo(\App\Models\Agency::class, 'id');
    }

    public function invites(){
        return $this->hasMany(\App\Models\Custom\EventInvite::class)->withTrashed();
    }

    public function getIsDoneAttribute(){
        $eventEnd = Carbon::parse("{$this->date} {$this->end_time}");
        return $eventEnd->isPast();
    }

    public function hasDoneFeedback($user_id){
        return EventFeedback::where('event_id', $this->id)->where('member_id', $user_id)->exists();
    }

    public static function isUserInvited($user_id = 0, $event_id)
    {
        if (!$user_id || !$event_id) {
            return false;
        }

        //TO BE REPLACED WITH THE QUERY BELOW
        // $user_member = \App\Models\User::find($user_id);
        // $member = \App\Models\Member::find($user_member->user_id);
        //

        $member = \App\Models\Member::where('id', $user_id)->first();
        if (!$member) {
            return false;
        }

        $event_invites = EventInvite::where('event_id', $event_id)->get();

        foreach ($event_invites as $invite) {
            switch ($invite->type) {

                case 'cluster':
                    $clusters = explode('::', $member->cluster);
                    if (in_array($invite->invited, $clusters)) {
                        return true;
                    }
                    break;

                case 'agency':
                    if ($member->agency == $invite->invited) {
                        return true;
                    }
                    break;

                case 'member':
                    if ($member->id == $invite->invited) {
                        return true;
                    }
                    break;
            }
        }

        return false; // no match found
    }

    public static function isUserParticipated($user_id = 0, $event_id)
    {
        if (!$user_id || !$event_id) {
            return false;
        }

        $member = \App\Models\Member::where('id', $user_id)->first();
        if (!$member) {
            return false;
        }

        $event_participant = EventParticipant::where('event_id', $event_id)->where('member_id', $member->id)->where('status', 1)->first();

        if($event_participant){
            return true; 
        }
        else{
            return false; 
        }

    }

}
