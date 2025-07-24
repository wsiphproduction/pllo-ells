<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\ActivityLog;
use App\Models\PolicyReformCategory;

class PolicyReform extends Model
{
    use SoftDeletes;

    public $table = 'policy_reforms';

    protected $fillable = [ 'member_id', 'title', 'category', 'description', 'photo','like','dislike', 'until','target_votes'];

    public function policyReformCategory() {
        return $this->belongsTo(PolicyReformCategory::class, 'category');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

}