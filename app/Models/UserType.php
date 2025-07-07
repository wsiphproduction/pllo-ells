<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\ActivityLog;

class UserType extends Model
{
    use SoftDeletes;

    public $table = 'user_types';

    protected $fillable = [ 'name', 'description'];

}