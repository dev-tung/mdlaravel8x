<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageService
{
    protected string $disk;

    public function __construct(string $disk = 'public')
    {
        $this->disk = $disk; // mặc định dùng storage/app/public
    }

    /**
     * Upload hình ảnh
     *
     * @param UploadedFile $file
     * @param string $path
     * @return string đường dẫn ảnh đã lưu
     */
    public function upload(UploadedFile $file, string $path = 'uploads'): string
    {
        // Đặt tên file duy nhất
        $filename = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();

        // Lưu file vào storage
        $filePath = $file->storeAs($path, $filename, $this->disk);

        return $filePath;
    }

    /**
     * Xoá ảnh
     *
     * @param string|null $filePath
     * @return bool
     */
    public function delete(?string $filePath): bool
    {
        if ($filePath && Storage::disk($this->disk)->exists($filePath)) {
            return Storage::disk($this->disk)->delete($filePath);
        }
        return false;
    }

    /**
     * Lấy URL ảnh public
     */
    public function getUrl(string $filePath): string
    {
        return Storage::disk($this->disk)->url($filePath);
    }
}
