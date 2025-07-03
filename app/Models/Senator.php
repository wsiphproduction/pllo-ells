<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\ActivityLog;
use App\Models\Gender;

class Senator extends Model
{
    use SoftDeletes;

    public $table = 'senators';

    protected $fillable = [ 'name' ];
}