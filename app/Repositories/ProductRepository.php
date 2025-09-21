<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ProductRepository
{

    public function paginateWithFilters(array $filters = [], $perPage = 15): LengthAwarePaginator
    {
        $query = Product::query();

        // Filter
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

        // Thêm cột quantity (tồn kho hiện tại)
        $query->select('*', DB::raw('
            GREATEST(
                (SELECT COALESCE(SUM(quantity),0) FROM imports WHERE product_id = products.id)
                - (SELECT COALESCE(SUM(quantity),0) FROM items WHERE product_id = products.id),
                0
            ) AS quantity
        '));

        return $query->orderBy('created_at', 'desc')
                    ->paginate($perPage)
                    ->appends($filters);
    }


    public function all()
    {
        return Product::orderBy('created_at', 'desc')->get();
    }

    public function find(int $id): Product
    {
        return Product::findOrFail($id);
    }

    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(int $id, array $data): Product
    {
        $product = $this->find($id);
        $product->update($data);
        return $product;
    }

    public function delete(int $id): ?bool
    {
        return Product::destroy($id);
    }

    public function findBySlug(string $slug): Product
    {
        return Product::where('slug', $slug)->first();
    }

}
