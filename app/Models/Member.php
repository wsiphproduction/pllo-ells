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
                            'user_id',
                            'firstname',
                            'lastname',
                            'middle_initial',
                            'suffix',
                            'email',
                            'alt_email',
                            'password',
                            'contact_number',
                            'type_number',
                            'other_number',
                            'gender',
                            'birthdate',
                            'system',
                            'user_type',
                            'agency',
                            'sub_agency',
                            'designation',
                            'cluster',
                            'senator_id',
                            'hor_id',
                            'congsec_type',
                            'committee_type',
                            'chairperson',
                            'logo',
                            'photo',
                            'is_verified'
                        ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function designation() {
        return $this->belongsTo(Designation::class, 'id');
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

    public function getFullDesignationNameAttribute()
    {
        return Designation::find($this->designation)?->name ?? 'No Designation';
    }

    public function getFullAgencyNameAttribute()
    {
        return Agency::find($this->agency)?->agency_name ?? 'No Agency';
    }

    public function getFullClusterNameAttribute()
    {
        if (!$this->cluster) {
            return 'No Cluster';
        }

        // Split the string into an array of IDs
        $ids = explode('::', $this->cluster);

        // Fetch all clusters matching those IDs
        $clusters = Cluster::whereIn('id', $ids)->pluck('name')->toArray();

        // Return the names as a comma-separated string
        return $clusters ? implode(', ', $clusters) : 'No Cluster';
    }


    public static function getMemberInfo($user_id) {
        $member = Member::where('user_id', $user_id)->first();
        return $member;
    }

    public function userType() {
        return $this->belongsTo(userType::class, 'user_type');
    }

    public function senator() {
        return $this->belongsTo(Senator::class, 'senator_id');
    }

}