<?php

namespace App\Models\Custom;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'events';
    protected $fillable = [ 'title', 'description', 'event_cluster_id', 'date', 'time', 'location', 'attachments', 'event_img', 'created_by'];


    public function cluster()
    {
        return $this->belongsTo(\App\Models\Cluster::class, 'event_cluster_id');
    }

}
