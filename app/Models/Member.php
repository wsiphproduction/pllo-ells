<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\ActivityLog;
use App\Models\Cluster;
use App\Models\Gender;
use App\Models\UserType;
use App\Models\Designation;
use App\Models\MemberStaff;
use App\Models\User;
use App\Models\Hor;

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
                            'nickname',
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
                            'committee_standing',
                            'committee_special',
                            'chairperson',
                            'logo',
                            'photo',
                            'is_verified'
                        ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function designationDetails() {
        return $this->belongsTo(Designation::class, 'designation');
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

    public static function getMemberName($id) {
        $member = Member::find($id);
        return $member->firstname . ' ' . $member->middle_initial . '. ' . $member->lastname;
    }

    public function userType() {
        return $this->belongsTo(UserType::class, 'user_type');
    }

    public function senator() {
        return $this->belongsTo(Senator::class, 'senator_id');
    }

    public function hor() {
        return $this->belongsTo(Hor::class, 'hor_id');
    }

    public function memberGender() {
        return $this->belongsTo(Gender::class, 'gender');
    }

    public function agency() {
        return $this->belongsTo(Agency::class, 'agency');
    }

    public function subAgency() {
        return $this->belongsTo(SubAgency::class, 'sub_agency');
    }

    public function is_contact_exist($contact) {

        $is_exist = SavedContact::where('user_id', Auth()->user()->id)
                                ->where('contact_id', $contact)
                                ->first();
        if ($is_exist) {
            return true;
        } return false;
    }

    public function memberStaff() {
        return $this->hasMany(MemberStaff::class, 'member_id' , 'id');
    }
}