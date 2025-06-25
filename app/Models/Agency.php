<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\ActivityLog;
use App\Models\Gender;

class Agency extends Model
{
    use SoftDeletes;

    public $table = 'agency';

    protected $fillable = [ 
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
                            'head_cellphone'
                        ];

    public function events(){
        return $this->hasMany(\App\Models\Custom\Event::class)->withTrashed();
    }

    public function getGenderName($value) {

        $name = Gender::find($value);

        return $name->name;
    }
}