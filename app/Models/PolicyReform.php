<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\ActivityLog;

class PolicyReform extends Model
{
    use SoftDeletes;

    public $table = 'policy_reforms';

    protected $fillable = [ 'member_id', 'title', 'category', 'description', 'photo','like','dislike','target_votes'];

}