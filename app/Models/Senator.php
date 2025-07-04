<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\ActivityLog;
use App\Models\Gender;

class Senator extends Model
{
    use SoftDeletes;

    public $table = 'senators';

    protected $fillable = [ 
                            'sen_firstname',
                            'sen_lastname',
                            'sen_middle_initial',
                            'sen_suffix',
                            'sen_nickname',
                            'sen_email',
                            'sen_email_agree',
                            'sen_landline',
                            'sen_landline_agree',
                            'sen_office_cellphone',
                            'sen_office_cellphone_agree',
                            'sen_group',
                            'sen_party',
                            'sen_gender',
                            'sen_birthday',
                            'sen_facebook',
                            'sen_twitter',
                            'sen_instagram',
                            'sen_youtube',
                            'sen_main_room_number',
                            'sen_main_direct_line',
                            'sen_main_fax_number',
                            'sen_main_trunk_local_number',
                            'sen_extension_room_number',
                            'sen_extension_direct_line',
                            'sen_extension_fax_number',
                            'sen_extension_trunk_local_number',
                            'sen_spouse_firstname',
                            'sen_spouse_lastname',
                            'sen_spouse_suffix',
                            'sen_spouse_gender',
                            'sen_spouse_birthday',
                            'sen_spouse_profession',
                            'sen_spouse_office_address',
                            'sen_spouse_email_address',
                            'sen_spouse_landline_number',
                            'sen_spouse_cellphone_number'
                          ];

    public function senGender() {
        return $this->belongsTo(Gender::class, 'sen_gender');
    }

}