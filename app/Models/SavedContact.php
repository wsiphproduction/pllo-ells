<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Member;

use App\Models\ActivityLog;

class SavedContact extends Model
{
    use SoftDeletes;

    public $table = 'saved_contacts';

    protected $fillable = [ 'user_id', 'contact_id'];
 
    public function member() {
        return $this->belongsTo(Member::class, 'contact_id');
    }
}