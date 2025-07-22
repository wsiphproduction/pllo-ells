<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\ActivityLog;
use App\Models\Gender;
use App\Models\SubAgency;

class Agency extends Model
{
    use SoftDeletes;

    public $table = 'agency';

    protected $fillable = [ 
                            'user_type_id',
                            'agency_name',
                            'agency_address',
                            'agency_email',
                            'agency_landline',
                            'agency_cellphone',
                            'head_name',
                            'head_nickname',
                            'head_gender',
                            'head_address',
                            'head_alt_address',
                            'head_email',
                            'head_office_email',
                            'head_cellphone',
                            'approved_by'
                        ];

    public function events(){
        return $this->hasMany(\App\Models\Custom\Event::class)->withTrashed();
    }

    public function getGenderName($value) {

        $name = Gender::find($value);

        return $name->name;
    }

    public static function getAgencyName($id){
        return Agency::find($id);
    }

    public function userType() {
        return $this->belongsTo(userType::class, 'user_type_id');
    }

    public static function subAgency(){
        return $this->belongsTo(SubAgency::class, 'agency_id');
    }

    public function reference_materials(){
        return $this->hasMany(\App\Models\Custom\ReferenceMaterial::class)->withTrashed();
    }
}