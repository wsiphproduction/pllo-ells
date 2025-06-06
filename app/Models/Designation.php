<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\ActivityLog;

class Designation extends Model
{
    use SoftDeletes;

    public $table = 'designation';

    protected $fillable = [ 'name'];

}