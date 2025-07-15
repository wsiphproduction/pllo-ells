<?php

namespace App\Models\Custom;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventFeedback extends Model
{
    use HasFactory;

    public $table = 'event_feedbacks';
    protected $fillable = ['event_id', 'member_id', 'q1', 'q2', 'q3', 'q4', 'q5', 'comments'];
}
