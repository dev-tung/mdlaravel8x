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

    public function generate(?string $productName, ?string $size = null, ?string $color = null): string
    {
        // abbreviation từ tên sản phẩm, nếu null thì mặc định PRD
        $abbr = $productName
            ? strtoupper(collect(preg_split('/\s+/', trim($productName)))
                ->map(fn($w) => mb_substr(preg_replace('/[^A-Za-z0-9]/u', '', $w), 0, 1))
                ->implode(''))
            : 'PRD';

        // Size, nếu null thì gán SDEF
        $sku = $abbr . '-S' . strtoupper($size ?: 'DEF');

        // Color, nếu null thì gán CDEF
        $sku .= '-C' . strtoupper($color ?: 'DEF');

        // Thêm chuỗi random 3 ký tự
        $sku .= '-' . strtoupper(Str::random(6));

        return $sku;
    }

    public function create(array $data)
    {
        // Xử lý upload ảnh
        if (!empty($data['thumbnail_image'])) {
            $data['thumbnail_image'] = $this->imageService->upload(
                $data['thumbnail_image'],
                'products'
            );
        }

        // Gọi repository lưu product
        $product = $this->productRepository->create($data);

        // Nếu có variants thì thêm
        if (!empty($data['variants']) && is_array($data['variants'])) {
            $this->productRepository->addVariants($product, $data['variants']);
        }

        return $product->load('variants');
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
