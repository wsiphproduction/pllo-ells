<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\ActivityLog;

class Designation extends Model
{
    use SoftDeletes;

    public $table = 'designation';

    protected $fillable = [ 'name', 'user_type_id' ];

    public function members()
    {
        return $this->hasMany(Member::class, 'designation');
    }

    public function userType() {
        return $this->belongsTo(userType::class, 'user_type_id');
    }

}