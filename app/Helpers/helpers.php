<?php
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

if (!function_exists('HPdisplayThumnail')) {
    /**
     * Lấy URL của thumbnail sản phẩm
     *
     * @param string|null $path  Đường dẫn thumbnail trong storage
     * @param string $default    Ảnh mặc định nếu không có
     * @return string
     */
    function HPdisplayThumnail($path = null)
    {
        if (Storage::disk('public')->exists($path)) {
            return asset('storage/' . $path);
        }

        return asset('img/shared/No_Image_Available.jpg');
    }
}


if (!function_exists('HPabbreviation')) {
    /**
     * Sinh từ viết tắt có độ dài cố định
     *
     * @param string $string   Chuỗi gốc
     * @param int    $length   Độ dài mong muốn (mặc định 3)
     * @return string
     */


    if (!function_exists('HPabbreviation')) {
        /**
         * Sinh viết tắt dạng ASCII, length cố định (mặc định 3)
         */
        function HPabbreviation(string $string, int $length = 3): string
        {
            // Chuyển về ASCII (loại bỏ dấu)
            $ascii = Str::ascii($string);

            // Lấy ký tự đầu mỗi từ (chỉ [A-Za-z0-9])
            preg_match_all('/\b[A-Za-z0-9]/', $ascii, $matches);
            $abbr = strtoupper(implode('', $matches[0]));

            // Loại bỏ ký tự khác, pad/cắt về đúng độ dài
            $abbr = preg_replace('/[^A-Z0-9]/', '', $abbr);
            if (strlen($abbr) < $length) {
                $abbr = str_pad($abbr, $length, 'X');
            }

            return substr($abbr, 0, $length);
        }
    }

}

if (!function_exists('HPformatCurrency')) {
    function HPformatCurrency($number, $suffix = 'đ')
    {
        return number_format($number, 0, ',', '.') . ' ' . $suffix;
    }
}
