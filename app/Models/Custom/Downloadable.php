<?php

namespace App\Models\Custom;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Downloadable extends Model
{
    use HasFactory, SoftDeletes;
    
    public $table = 'downloadables';
    protected $fillable = [ 'type', 'ra_jr_no', 'source_priority_level', 'approved_on', 'congress', 'long_title', 'attachments', 'bill_no', 'proposed_measure', 'status', 'created_by'];
    
}
