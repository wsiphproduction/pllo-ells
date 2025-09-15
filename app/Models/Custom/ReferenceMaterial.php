<?php

namespace App\Models\Custom;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReferenceMaterial extends Model
{
    use HasFactory, SoftDeletes;
    
    public $table = 'reference_materials';
    protected $fillable = [ 'subject', 'significance_level', 'cluster_id', 'agency_id', 'attachments', 'remarks', 'status', 'approved_on', 'created_by'];

    
    public function cluster()
    {
        return $this->belongsTo(\App\Models\Cluster::class);
    }

    public function agency()
    {
        return $this->belongsTo(\App\Models\Agency::class);
    }
}