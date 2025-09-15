<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\FileDownloadCategory;

class FileDownload extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'file_download';
    protected $fillable = [
        'version_no',
        'title',
        'ra_jr',
        'file_url',
        'status',
        'unique_hash',
        'congress',
        'approved_on',
        'source_priority_level',
        'event_id'
    ];

    
}
