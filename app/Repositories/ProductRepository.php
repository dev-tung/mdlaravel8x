<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository
{
    /**
     * Lấy danh sách products theo filter và phân trang, eager load taxonomy
     */
    public function paginateWithFilters(array $filters = [], $perPage = 15): LengthAwarePaginator
    {
        $query = Product::with('taxonomy'); // load quan hệ taxonomy

        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%'.$filters['name'].'%');
        }

        if (!empty($filters['taxonomy_id'])) {
            $query->where('taxonomy_id', $filters['taxonomy_id']);
        }

        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('status', $filters['status']);
        }

        return $query->orderBy('created_at', 'desc')
                     ->paginate($perPage)
                     ->appends($filters);
    }

    /**
     * Lấy tất cả products, eager load taxonomy
     */
    public function all()
    {
        return Product::with('taxonomy')
                      ->orderBy('created_at', 'desc')
                      ->get();
    }

    /**
     * Tìm product theo ID
     */
    public function find(int $id): Product
    {
        return Product::with('taxonomy')->findOrFail($id);
    }

    /**
     * Tạo mới product
     */
    public function create(array $data): Product
    {
        return Product::create($data);
    }

    /**
     * Cập nhật product theo ID
     */
    public function update(int $id, array $data): Product
    {
        $product = $this->find($id);
        $product->update($data);
        return $product;
    }

    /**
     * Xóa product theo ID
     */
    public function delete(int $id): ?bool
    {
        return Product::destroy($id);
    }
}
