<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Image;
use Illuminate\Support\Facades\DB;

class ImportAwsImages extends Command
{
    /**
     * Command signature
     */
    protected $signature = 'images:import-aws
        {path : Full path to AWS image folder}
        {manifest : Path to cleaned or detailed manifest JSON}
        {--dry-run : Run without writing to database}';

    /**
     * Command description
     */
    protected $description = 'Import AWS images into database';

    /**
     * Execute command
     */
    public function handle()
    {
        $path = rtrim($this->argument('path'), '/');
        $manifestPath = $this->argument('manifest');
        $dryRun = $this->option('dry-run');

        if ($dryRun) {
            $this->warn("DRY RUN MODE ENABLED — no database writes will occur");
        }

        // Validate manifest
        if (!file_exists($manifestPath)) {
            $this->error("Manifest not found: {$manifestPath}");
            return Command::FAILURE;
        }

        $json = file_get_contents($manifestPath);
        $images = json_decode($json, true);

        if (!is_array($images)) {
            $this->error("Invalid JSON in manifest");
            return Command::FAILURE;
        }

        $this->info("Starting AWS import...");
        $count = 0;

        foreach ($images as $item) {

            // Support both manifest formats safely
            $awsKey = $item['key'] ?? $item['Key'] ?? null;

            if (!$awsKey) {
                $this->warn("Skipping invalid entry (no key found)");
                continue;
            }

            $filename = basename($awsKey);
            $fullPath = $path . '/' . $filename;

            // Ensure file exists locally
            if (!file_exists($fullPath)) {
                $this->warn("Missing file: {$awsKey}");
                continue;
            }

            // Normalize path for DB storage
            $relativePath = str_replace(
                '/home/bcidev2/public_html/BCIImages/',
                '',
                $fullPath
            );

            // Prevent duplicates (strongest identifier)
            if (Image::where('s3_key', $awsKey)->exists()) {
                $this->line("Skipping duplicate: {$filename}");
                continue;
            }

            // File metadata
            $mime = mime_content_type($fullPath);
            $size = filesize($fullPath);

            $data = [
                'uploader_user_id' => 1,

                'file_path' => $relativePath,
                'storage' => 'cpanel',

                'filename' => $filename,
                'original_filename' => $filename,

                'mime_type' => $mime,
                'file_size' => $size,

                's3_key' => $awsKey,
                'preview_key' => null,

                // IMPORTANT: store arrays (Laravel casts handle JSON)
                'metadata' => $item,
                'aws_tags' => $item['metadata'] ?? [],
                'user_tags' => [],

                'title' => null,
                'description' => null,
            ];

            if ($dryRun) {
                $this->line("[DRY RUN] Would insert: {$awsKey}");
                continue;
            }

            DB::transaction(function () use (&$count, $data) {
                Image::create($data);
                $count++;
            });
        }

        $this->info("Import complete: {$count} images added");

        return Command::SUCCESS;
    }
}