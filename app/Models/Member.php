<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\ActivityLog;

class Member extends Model
{
    use SoftDeletes;

    public $table = 'members';

    protected $fillable = [
                            'firstname',
                            'lastname',
                            'middle_initial',
                            'suffix',
                            'email',
                            'password',
                            'contact_number',
                            'other_number',
                            'gender',
                            'birthdate',
                            'system',
                            'agency',
                            'cluster',
                            'logo',
                            'photo'
                        ];

}