<?php

namespace App\Repositories;

use App\Models\Media;
use Illuminate\Support\Facades\Storage;

class MediaRepository
{
    public function getAll()
    {
        return Media::latest()->paginate(20);
    }

    public function find($id)
    {
        return Media::findOrFail($id);
    }

    public function upload($file, $data = [])
    {
        $path = $file->store('uploads', 'public');

        return Media::create([
            'name'      => $data['name'] ?? $file->getClientOriginalName(),
            'file_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size'      => $file->getSize(),
            'disk'      => 'public',
            'path'      => $path,
            'url'       => Storage::url($path),
        ]);
    }

    public function delete($id)
    {
        $media = $this->find($id);
        Storage::disk($media->disk)->delete($media->path);
        return $media->delete();
    }
}
