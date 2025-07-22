<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Member;
use App\Models\Gender;

class MemberStaff extends Model
{
    protected $table = 'members_staff';

    protected $fillable = [
                        'member_id',
                        'designation',
                        'firstname',
                        'lastname',
                        'middle_initial',
                        'suffix',
                        'nickname',
                        'gender',
                        'birthday',
                        'email',
                        'agree_email',
                        'contact_number',
                        'agree_contact_number',
                        'type_number',
                        'photo',
                        'other_number'
                    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function personGender()
    {
        return $this->belongsTo(Gender::class, 'gender');
    }

}
