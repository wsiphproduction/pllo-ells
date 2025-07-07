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

    protected $fillable = [ 'name' ];

    public function gender() {
        return $this->belongsTo(Gender::class, 'hor_gender');
    }
}