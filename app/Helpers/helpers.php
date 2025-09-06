<?php
use Illuminate\Support\Facades\Storage;

if (!function_exists('displayThumnail')) {
    /**
     * Lấy URL của thumbnail sản phẩm
     *
     * @param string|null $path  Đường dẫn thumbnail trong storage
     * @param string $default    Ảnh mặc định nếu không có
     * @return string
     */
    function displayThumnail($path = null)
    {
        if (Storage::disk('public')->exists($path)) {
            return asset('storage/' . $path);
        }

        return asset('img/No_Image_Available.jpg');
    }
}