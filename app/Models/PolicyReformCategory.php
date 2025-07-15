<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PolicyReformCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'policy_reform_categories';

    protected $fillable = [ 'user_id', 'name'];
}
