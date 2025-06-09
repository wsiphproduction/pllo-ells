<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\ActivityLog;

class MessagingNumber extends Model
{
    use SoftDeletes;

    public $table = 'messaging_number';

    protected $fillable = [ 'name'];

}