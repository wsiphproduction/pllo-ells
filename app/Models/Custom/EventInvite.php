<?php

namespace App\Models\Custom;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Eventinvite extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'event_invites';
    protected $fillable = ['event_id', 'type', 'invitation_file', 'invited', 'invited_by', 'participant_limit'];

    
    public function event()
    {
        return $this->belongsTo(\App\Models\Custom\Event::class, 'id');
    }

    public function invitedEntity()
    {
        return match ($this->type) {
            'cluster' => $this->belongsTo(\App\Models\Cluster::class, 'invited'),
            'agency'  => $this->belongsTo(\App\Models\Agency::class, 'invited'),
            'member'  => $this->belongsTo(\App\Models\Member::class, 'invited'),
            default   => null,
        };
    }
}