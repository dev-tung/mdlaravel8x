<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

