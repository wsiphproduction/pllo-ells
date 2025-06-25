<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\ActivityLog;
use App\Models\Cluster;
use App\Models\User;

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
                            'alt_email',
                            'password',
                            'contact_number',
                            'other_number',
                            'gender',
                            'birthdate',
                            'system',
                            'agency',
                            'cluster',
                            'logo',
                            'photo',
                            'is_verified'
                        ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getClusterDetailsAttribute() {
        return $this->belongsTo(Cluster::class,'cluster_id', 'id');
    }

    public function getClusterName($value) {
        $name = Cluster::find($value);
        return $name;
    }

    public function getFullNameAttribute()
    {
        return $this->firstname . ' ' . $this->middle_initial . '. ' . $this->lastname;
    }


    public static function getMemberInfo($user_id) {
        $member = Member::where('user_id', $user_id)->first();
        return $member;
    }

}