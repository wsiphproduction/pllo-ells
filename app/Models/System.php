<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\ActivityLog;

class System extends Model
{
    use SoftDeletes;

    public $table = 'systems';

    protected $fillable = [ 'name', 'description'];

}