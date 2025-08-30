<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository
{

    public function paginateWithFilters(array $filters = [], $perPage = 15): LengthAwarePaginator
    {
        $query = Product::query();

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

        if (isset($filters['quantity']) && $filters['quantity']) {
            $query->where('quantity', '>', 0);
        }

        return $query->orderBy('created_at', 'desc')
                     ->paginate($perPage)
                     ->appends($filters);
    }

    public function all()
    {
        return Product::orderBy('created_at', 'desc')->get();
    }

    public function forOrder()
    {
        return Product::with('imports')
        ->whereHas('imports', function($query) {
            $query->where('price_input', '>', 0);
        })
        ->get();

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

    public function increaseQuantity(int $id, int $amount): void
    {
        Product::where('id', $id)->increment('quantity', $amount);
    }    

    public function decreaseQuantity(int $id, int $amount): void
    {
        Product::where('id', $id)->decrement('quantity', $amount);
    }
}
