<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

use App\Models\Official;

class SavedContactOfficial extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'saved_contacts_official';

    protected $fillable = ['user_id', 'official_id'];
 
    public function user() {
        return $this->belongsTo(Member::class, 'user_id');
    }

    public function official()
    {
        return $this->belongsTo(official::class, 'official_id');
    }
}
