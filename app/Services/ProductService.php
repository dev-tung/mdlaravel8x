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
            $query->whereHas('variant.supplier', function ($q) use ($filters) {
                $q->where('id', $filters['supplier_id']);
            });
        }

        if (!empty($filters['taxonomy_id'])) {
            $query->where('taxonomy_id', $filters['taxonomy_id']);
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

        $data['sku'] = $this->generateSku($data['taxonomy_id'] ?? null, $data['name']);

        return $this->productRepository->createWithVariant($data);
    }

    private function generateSku(?int $taxonomyId, string $productName): string
    {
        $abbr = $taxonomyId
                ? abbreviation($this->taxonomyRepository->find($taxonomyId)->name)
                : 'XXX';

        return sprintf("MDS-%s-%s", $abbr, $this->randomDigits());
    }

    private function randomDigits(int $length = 9): string
    {
        return str_pad((string) random_int(0, 10 ** $length - 1), $length, '0', STR_PAD_LEFT);
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
