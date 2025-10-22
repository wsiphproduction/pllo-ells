<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ComSecCommitteeTab extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'sen_comsec_tab_committee';

    protected $fillable = [ 'member_id', 'title', 'position', 'personel', 'contact', 'email', 'email2'];
}
