<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;



if (!function_exists('abbreviation')) {
    /**
     * Sinh viết tắt dạng ASCII, length cố định (mặc định 3)
     */
    function abbreviation(string $string, int $length = 3): string
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


if (!function_exists('format_currency')) {
    function format_currency($number, $suffix = 'đ')
    {
        return number_format($number, 0, ',', '.') . ' ' . $suffix;
    }
}

if (!function_exists('taxonomies')) {
    function taxonomies(string $type) {
        return app(\App\Repositories\TaxonomyRepository::class)->getByType($type);
    }
}


if (!function_exists('display_product_img')) {
    function display_product_img($item): string
    {
        $imageService = app(\App\Services\ImageService::class);

        // Truy xuất ảnh từ collection đã eager load nếu có
        $thumbnail = $item->images->firstWhere('is_default', 1) ?? $item->images->first();

        if ($thumbnail) {
            return $imageService->getUrl($thumbnail->file_path);
        }

        return asset('img/shared/No_Image_Available.jpg');
    }
}

