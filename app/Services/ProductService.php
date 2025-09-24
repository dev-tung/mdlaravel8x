<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService
{
    protected ProductRepository $productRepository;
    protected ImageService $imageService;

    public function __construct(
        ProductRepository $productRepository,
        ImageService $imageService
    ) {
        $this->productRepository = $productRepository;
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

    public function create(array $data): Product
    {
        if (isset($data['thumbnail'])) {
            $data['thumbnail'] = $this->imageService->upload($data['thumbnail'], 'products');
        }

        return $this->productRepository->create($data);
    }

    public function update(int $id, array $data): Product
    {
        $product = $this->productRepository->find($id);

        if (isset($data['thumbnail'])) {
            $this->imageService->delete($product->thumbnail ?? null);
            $data['thumbnail'] = $this->imageService->upload($data['thumbnail'], 'products');
        }

        return $this->productRepository->update($id, $data);
    }

    public function delete(int $id): ?bool
    {
        $product = $this->productRepository->find($id);
        $this->imageService->delete($product->thumbnail ?? null);

        return $this->productRepository->delete($id);
    }

}
