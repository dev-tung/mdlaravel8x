<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use App\Repositories\TaxonomyRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService
{
    protected ProductRepository $productRepository;
    protected TaxonomyRepository $taxonomyRepository;
    protected ImageService $imageService;

    public function __construct(
        ProductRepository $productRepository,
        TaxonomyRepository $taxonomyRepository,
        ImageService $imageService
    ) {
        $this->productRepository = $productRepository;
        $this->taxonomyRepository = $taxonomyRepository;
        $this->imageService = $imageService;
    }

    /**
     * Lấy danh sách sản phẩm với filter + paginate
     */
    public function paginateWithFilters(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->productRepository->query();

        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%'.$filters['name'].'%');
        }

        if (!empty($filters['supplier_id'])) {
            $query->where('supplier_id', $filters['supplier_id']);
        }

        if (!empty($filters['taxonomy_id'])) {
            $query->where('taxonomy_id', $filters['taxonomy_id']);
        }

        if (!empty($filters['price_min'])) {
            $query->where('price_output', '>=', $filters['price_min']);
        }

        if (!empty($filters['price_max'])) {
            $query->where('price_output', '<=', $filters['price_max']);
        }

        if (!empty($filters['in_stock'])) {
            $query->where('stock', '>', 0);
        }

        return $query->orderBy('created_at', 'desc')
                     ->paginate($perPage)
                     ->appends($filters);
    }

    public function create(array $data)
    {
        // Xử lý ảnh trước
        if (isset($data['thumbnail_image'])) {
            $data['thumbnail_image'] = $this->imageService->upload(
                $data['thumbnail_image'],
                'products'
            );
        }

        // Tạo SKU
        $data['sku'] = $this->generateSku($data['taxonomy_id'] ?? null, $data['name']);

        // Tạo sản phẩm
        $product = $this->productRepository->create($data);

        return $product;
    }

    public function generateSku($taxonomyId, $productName)
    {
        $taxonomyAbbr = $taxonomyId
            ? HPabbreviation($this->taxonomyRepository->find($taxonomyId)->name)
            : 'XXX';

        $random = $this->randomDigits();

        return "MDS-{$taxonomyAbbr}-{$random}";
    }

    function randomDigits($length = 9) {
        $digits = '';
        for ($i = 0; $i < $length; $i++) {
            $digits .= rand(0, 9);
        }
        return $digits;
    }


    public function update(int $id, array $data)
    {
        $product = $this->productRepository->find($id);

        // Nếu có đổi taxonomy thì regenerate SKU
        if (isset($data['taxonomy_id']) && $data['taxonomy_id'] != $product->taxonomy_id) {
            $data['sku'] = $this->generateSku($data['taxonomy_id'], $data['name'] ?? $product->name);
        }

        // Nếu đổi thumbnail
        if (isset($data['thumbnail_image'])) {
            $this->imageService->delete($product->thumbnail_image ?? null);
            $data['thumbnail_image'] = $this->imageService->upload($data['thumbnail_image'], 'products');
        }

        return $this->productRepository->update($id, $data);
    }

    public function delete(int $id): ?bool
    {
        $product = $this->productRepository->find($id);
        $this->imageService->delete($product->thumbnail_image ?? null);

        return $this->productRepository->delete($id);
    }

}
