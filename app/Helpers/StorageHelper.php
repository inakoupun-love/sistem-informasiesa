<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class StorageHelper
{
    /**
     * Get public file URL
     *
     * @param string $path File path in storage/app/public
     * @return string
     */
    public static function url($path)
    {
        if (empty($path)) {
            return null;
        }

        return Storage::disk('public')->url($path);
    }

    /**
     * Store file to public storage
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $directory
     * @return string File path
     */
    public static function store($file, $directory = '')
    {
        if (!$file) {
            return null;
        }

        $path = $file->store($directory, 'public');
        
        return $path;
    }

    /**
     * Delete file from public storage
     *
     * @param string $path
     * @return bool
     */
    public static function delete($path)
    {
        if (!$path) {
            return false;
        }

        return Storage::disk('public')->delete($path);
    }

    /**
     * Check if file exists
     *
     * @param string $path
     * @return bool
     */
    public static function exists($path)
    {
        if (!$path) {
            return false;
        }

        return Storage::disk('public')->exists($path);
    }

    /**
     * Get file full path
     *
     * @param string $path
     * @return string
     */
    public static function path($path)
    {
        if (!$path) {
            return null;
        }

        return Storage::disk('public')->path($path);
    }
}
