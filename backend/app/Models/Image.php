<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Image extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'uploader_user_id',

        // File system
        'file_path',
        'storage',
        'filename',
        'original_filename',
        'mime_type',
        'file_size',

        // AWS
        's3_key',
        'preview_key',

        // Content
        'title',
        'description',

        // Metadata
        'metadata',
        'aws_tags',
        'user_tags',

        // EXIF
        'camera_make',
        'camera_model',
        'lens',
        'focal_length',
        'aperture',
        'shutter_speed',
        'iso',

        // Location
        'gps_latitude',
        'gps_longitude',
        'location_name',
        'user_location',

        // Capture
        'captured_at',

        // Display
        'watermark_enabled'
    ];

    protected $casts = [
        'metadata' => 'array',
        'aws_tags' => 'array',
        'user_tags' => 'array',

        'captured_at' => 'datetime',
        'watermark_enabled' => 'boolean',

        'gps_latitude' => 'float',
        'gps_longitude' => 'float',
        'file_size' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploader_user_id');
    }
}