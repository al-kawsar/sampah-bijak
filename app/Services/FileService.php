<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Models\File as FileModel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FileService
{
    public function uploadFile($file)
    {
        // Generate a random file name
        $fileName = Str::random(60);
        $extension = $file->getClientOriginalExtension();
        $path = date('Y') . '/' . date('m') . '/' . date('d');
        $size = round($file->getSize() / 1024);

        // Define the path where the file will be stored
        $pathName = 'file/' . $path . '/' . $fileName . '.' . $extension;

        // Store the file in the public disk
        Storage::disk('public')->put($pathName, File::get($file));

        // Create the file record in the database
        $data = FileModel::create([
            'url' => config('app.file_upload_endpoint'), // Generate the public URL
            'path_name' => Storage::url($pathName),
            'file_name' => $pathName,
            'extension' => $extension,
            'size' => $size
        ]);

        return $data;
    }

    public function getFileById($id)
    {
        $file = FileModel::findOrFail($id);

        return $file;
    }

    public function deleteFileById($id)
    {
        $file = FileModel::findOrFail($id);

        Storage::delete(str_replace('storage', 'public', $file->path_name));

        $file->delete();

        return $file;
    }
    public function deleteFileByPath($pathName)
    {
    // Pastikan path diawali dengan 'public/'
        $storagePath = str_replace('storage', 'public', $pathName);

    // Hapus file dari storage
        if (Storage::disk('public')->exists($storagePath)) {
            Storage::disk('public')->delete($storagePath);
        }
    }

}
