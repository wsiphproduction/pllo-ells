<?php

namespace App\Models\Custom;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class EventParticipant extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'event_participants';
    protected $fillable = ['event_invitation_id', 'event_id', 'member_id'];
}
