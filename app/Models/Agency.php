<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\ActivityLog;

class Agency extends Model
{
    use SoftDeletes;

    public $table = 'agency';

    protected $fillable = [ 'name', 'description'];

}