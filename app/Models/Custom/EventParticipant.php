<?php

namespace App\Models\Custom;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Custom\Event;

class EventParticipant extends Model
{
    use HasFactory;

    public $table = 'event_participants';
    protected $fillable = ['event_id', 'member_id', 'status'];


    public static function hasRepliedInvitation($event_id, $user_id){
        return EventParticipant::where('event_id', $event_id)->where('member_id', $user_id)->first();
    }

    public function event() {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
