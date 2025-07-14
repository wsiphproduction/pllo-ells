<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\ActivityLog;
use App\Models\Gender;

class Hor extends Model
{
    use SoftDeletes;

    public $table = 'hors';

    protected $fillable = [
                            'hor_firstname',
                            'hor_middle_initial',
                            'hor_lastname',
                            'hor_nickname',
                            'hor_email',
                            'hor_email_agree',
                            'hor_landline',
                            'hor_landline_agree',
                            'hor_office_cellphone',
                            'hor_office_cellphone_agree',
                            'hor_gender',
                            'hor_month',
                            'hor_day',
                            'hor_facebook',
                            'hor_twitter',
                            'hor_instagram',
                            'hor_youtube',
                            'hor_resident_adress',
                            'hor_resident_email',
                            'hor_resident_landline',
                            'hor_resident_cellphone',
                            'hor_province_adress',
                            'hor_province_email',
                            'hor_province_landline',
                            'hor_province_cellphone',
                            'hor_highest_education',
                            'hor_school',
                            'hor_prev_work_gov',
                            'hor_prev_work_private',
                            'hor_religion',
                            'hor_civic',
                            'hor_spouse_firstname',
                            'hor_spouse_middle_initial',
                            'hor_spouse_lastname',
                            'hor_spouse_wedding_aniv',
                            'hor_spouse_birthday',
                            'hor_spouse_civic',
                            'hor_spouse_profession',
                            'hor_child_name',
                            'hor_child_email',
                            'hor_child_landline',
                            'hor_child_cellphone',
                            'hor_child_professio'
                        ];

    public function gender() {
        return $this->belongsTo(Gender::class, 'hor_gender');
    }
}