<?php

namespace App\Models\Custom;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventParticipant extends Model
{
    use HasFactory;

    public $table = 'event_participants';
    protected $fillable = ['event_id', 'member_id', 'status'];


    public static function hasRepliedInvitation($user_id){
        return EventParticipant::where('member_id', \App\Models\Member::getMemberInfo($user_id)->id)->first();
    }
}
