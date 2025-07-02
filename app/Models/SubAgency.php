<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\ActivityLog;

class SubAgency extends Model
{
    use SoftDeletes;

    public $table = 'sub_agency';

    protected $fillable = [ 
                            'name',
                            'agency_id',
                        ];

    public function agency() {
        return $this->belongsTo(userType::class, 'agency_id');
    }
}