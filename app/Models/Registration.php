<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\ActivityLog;

class Registration extends Model
{
    use SoftDeletes;

    public $table = 'registrations';

    protected $fillable = [ 
                            'firstname', 
                            'lastname', 
                            'middle_initial', 
                            'suffix', 
                            'email', 
                            'password', 
                            'contact_number', 
                            'gender', 
                            'birthdate', 
                            'system', 
                            'agency', 
                            'cluster', 
                            'photo'
                        ];

}