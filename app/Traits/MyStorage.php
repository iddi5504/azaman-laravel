<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;


trait MyStorage
{

    protected $storageInstance;

    /**
     * Initialize storage instance before you do anything
     * @param string $disk This the disk to use. Defaults to public
     */
    protected function initStorage(string $disk = 'public')
    {
        $this->storageInstance = Storage::disk($disk);
    }

    /**
     * Upload file to storage bucket
     * @param UploadedFile $file The file to upload
     * @param string $dir The directory to save to 
     * @return string Returns the relative path of the uploaded file
     */
    protected function upload(UploadedFile $file, $dir)
    {

        $path = $this->storageInstance->putFileAs($dir, $file, $file->getFilename());
        return $path;
    }

    protected function deleteFile($path)
    {
        // dd($path);
        $this->storageInstance->delete($path);
    }
}
