<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

use App\Models\Member;
use App\Models\PolicyReform;

class PolicyReformAction extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'policy_reform_actions';

    protected $fillable = [ 'member_id', 'policy_reform_id', 'action_type'];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function policyReform()
    {
        return $this->belongsTo(PolicyReform::class, 'policy_reform_id');
    }
}
