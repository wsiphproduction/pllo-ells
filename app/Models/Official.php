<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Official extends Model
{
    use HasFactory;

    protected $table = 'officials';
    protected $fillable = [
        'position',
        'firstname',
        'middle_initial',
        'lastname',
        'nickname',
        'email',
        'email_agree',
        'landline',
        'landline_agree',
        'office_cellphone',
        'office_cellphone_agree',
        'gender',
        'month',
        'day',
        'facebook',
        'twitter',
        'instagram',
        'youtube',
        'image_url',

        // House of Representatives
        'resident_address',
        'resident_email',
        'resident_landline',
        'resident_cellphone',
        'province_address',
        'province_email',
        'province_landline',
        'province_cellphone',
        'highest_education',
        'school',
        'prev_work_gov',
        'prev_work_private',
        'religion',
        'civic',

        // Senate
        'suffix',
        'group',
        'party',
        'main_room_number',
        'main_direct_line',
        'main_fax_number',
        'main_trunk_local_number',
        'extension_room_number',
        'extension_direct_line',
        'extension_fax_number',
        'extension_trunk_local_number',

        // Spouse
        'spouse_firstname',
        'spouse_middle_initial',
        'spouse_lastname',
        'spouse_suffix',
        'spouse_gender',
        'spouse_birthday',
        'spouse_profession',
        'spouse_civic',
        'spouse_wedding_anniv',
        'spouse_office_address',
        'spouse_email_address',
        'spouse_landline_number',
        'spouse_cellphone_number',

        // Children
        'child_name',
        'child_email',
        'child_landline',
        'child_cellphone',
        'child_profession',

    ];

    public function getFullNameAttribute()
    {
        return $this->firstname . ' ' . $this->middle_initial . '. ' . $this->lastname;
    }

    public function is_contact_exist($contact) {

        $is_exist = SavedContact::where('user_id', Auth()->user()->id)
                                ->where('contact_id', $contact)
                                ->first();
        if ($is_exist) {
            return true;
        } return false;
    }
}
