<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

use App\Models\Cluster;

class ClusterUpdateHolder extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'cluster_update_holder';

    protected $fillable = [ 'member_id', 'cluster', 'status'];

    public function member(){
        return $this->belongsTo(Member::class, 'member_id');
    }

    public static function getClusterName($value) {
        $name = Cluster::find($value);
        return $name;
    }

}
