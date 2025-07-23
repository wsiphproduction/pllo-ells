<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\ActivityLog;

class Cluster extends Model
{
    use SoftDeletes;

    public $table = 'cluster';

    protected $fillable = [ 'user_type_id', 'name', 'approver'];


    public function events(){
        return $this->hasMany(\App\Models\Custom\Event::class, 'event_cluster_id')->withTrashed();
    }

    public function reference_materials(){
        return $this->hasMany(\App\Models\Custom\ReferenceMaterial::class)->withTrashed();
    }

}