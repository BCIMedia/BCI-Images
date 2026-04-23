<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();

            // Ownership
            $table->foreignId('uploader_user_id')->constrained('users')->cascadeOnDelete();

            // File system
            $table->string('file_path');
            $table->string('storage')->default('cpanel');
            $table->string('filename');
            $table->string('original_filename')->nullable();
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();

            // AWS
            $table->string('s3_key')->nullable();
            $table->string('preview_key')->nullable();

            // Content
            $table->string('title')->nullable();
            $table->text('description')->nullable();

            // Metadata
            $table->json('metadata')->nullable();
            $table->json('aws_tags')->nullable();
            $table->json('user_tags')->nullable();

            // EXIF
            $table->string('camera_make')->nullable();
            $table->string('camera_model')->nullable();
            $table->string('lens')->nullable();
            $table->string('focal_length')->nullable();
            $table->string('aperture')->nullable();
            $table->string('shutter_speed')->nullable();
            $table->string('iso')->nullable();

            // Location
            $table->decimal('gps_latitude', 10, 7)->nullable();
            $table->decimal('gps_longitude', 10, 7)->nullable();
            $table->string('location_name')->nullable();
            $table->string('user_location')->nullable();

            // Capture
            $table->timestamp('captured_at')->nullable();

            // Display
            $table->boolean('watermark_enabled')->default(false);

            // System
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};