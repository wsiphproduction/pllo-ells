<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\ActivityLog;

class Gender extends Model
{
    use SoftDeletes;

    public $table = 'gender';

    protected $fillable = [ 'name'];

}