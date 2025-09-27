<?php

if (!function_exists('display_thumbnail')) {
    /**
     * Lấy URL của thumbnail sản phẩm (PHP thuần)
     *
     * @param string|null $path     Đường dẫn thumbnail (tương đối so với thư mục public)
     * @param string $default       Ảnh mặc định nếu không có
     * @param string $baseUrl       Base URL của website (vd: http://localhost/project/)
     * @return string
     */
    function display_thumbnail(?string $path = null, string $default = 'img/shared/No_Image_Available.jpg', string $baseUrl = '/'): string
    {
        // Chuẩn hóa base URL (đảm bảo có dấu / ở cuối)
        if (substr($baseUrl, -1) !== '/') {
            $baseUrl .= '/';
        }

        // Nếu có path và file tồn tại
        if ($path && file_exists(__DIR__ . '/public/' . $path)) {
            return $baseUrl . 'public/' . ltrim($path, '/');
        }

        // Trả về ảnh mặc định
        return $baseUrl . ltrim($default, '/');
    }
}


if (!function_exists('abbreviation')) {
    /**
     * Sinh viết tắt dạng ASCII, length cố định (mặc định 3)
     */
    function abbreviation(string $string, int $length = 3): string
    {
        // Chuyển về ASCII (loại bỏ dấu, dùng iconv)
        $ascii = iconv('UTF-8', 'ASCII//TRANSLIT', $string);

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


if (!function_exists('format_currency')) {
    function format_currency($number, $suffix = 'đ')
    {
        return number_format($number, 0, ',', '.') . ' ' . $suffix;
    }
}
