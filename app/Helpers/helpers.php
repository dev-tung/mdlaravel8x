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

        return asset('img/shared/No_Image_Available.jpg');
    }
}


if (!function_exists('abbreviation')) {
    /**
     * Sinh từ viết tắt có độ dài cố định
     *
     * @param string $string   Chuỗi gốc
     * @param int    $length   Độ dài mong muốn (mặc định 3)
     * @return string
     */
    function abbreviation(string $string, int $length = 3): string
    {
        // Lấy chữ cái đầu mỗi từ
        $abbr = collect(explode(' ', $string))
            ->filter() // loại bỏ khoảng trắng thừa
            ->map(fn ($word) => strtoupper(mb_substr($word, 0, 1)))
            ->implode('');

        // Nếu ngắn hơn -> padding bằng X
        if (strlen($abbr) < $length) {
            $abbr = str_pad($abbr, $length, 'X');
        }

        // Nếu dài hơn -> cắt lại
        return substr($abbr, 0, $length);
    }
}
