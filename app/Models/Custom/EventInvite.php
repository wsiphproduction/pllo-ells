<?php

namespace App\Models\Custom;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Eventinvite extends Model
{
    use HasFactory;

    public $table = 'event_invites';
    protected $fillable = ['event_id', 'type', 'invitation_file', 'invited', 'invited_by', 'participant_limit'];
}