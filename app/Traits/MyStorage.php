<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait MyStorage
{

    protected $storageInstance;

    protected function initStorage(string $disk = 'public')
    {
        $this->storageInstance = Storage::disk($disk);
    }

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
