<?php

namespace App\Models\Custom;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventDownloadable extends Model
{
    use HasFactory;

    public $table = 'event_downloadables';
    protected $fillable = ['type', 'event_id', 'member_id', 'attachments', 'created_by'];
}
