<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

use App\Models\MemberStaff;

class SavedContactStaff extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'saved_contacts_staff';

    protected $fillable = [ 'user_id', 'staff_id'];
 
    public function user() {
        return $this->belongsTo(Member::class, 'user_id');
    }

    public function staff() {
        return $this->belongsTo(MemberStaff::class, 'staff_id');
    }
}
