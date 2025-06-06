<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\ActivityLog;

class Cluster extends Model
{
    use SoftDeletes;

    public $table = 'cluster';

    protected $fillable = [ 'name', 'description'];

}