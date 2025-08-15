<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductRepository
{
    public function all()
    {
        return Product::all();
    }

    public function find($id)
    {
        return Product::findOrFail($id);
    }

    public function create(array $data)
    {
        return Product::create($data);
    }

    public function update(Product $product, array $data)
    {
        $product->update($data);
        return $product;
    }

    public function delete(Product $product)
    {
        return $product->delete();
    }

    public function getAllWithFilter(array $filters = [], $perPage = 10)
    {
        $query = DB::table('products')
            ->leftJoin('product_categories', 'products.category_id', '=', 'product_categories.id')
            ->select(
                'products.id',
                'products.name',
                'products.category_id',
                'product_categories.name as category_name',
                'products.price',
                'products.sale_price',
                'products.stock',
                'products.status',
                'products.created_at'
            );

        if (!empty($filters['name'])) {
            $query->where('products.name', 'like', '%' . $filters['name'] . '%');
        }

        if (!empty($filters['category_id'])) {
            $query->where('products.category_id', $filters['category_id']);
        }

        if (!empty($filters['status'])) {
            $query->where('products.status', $filters['status']);
        }

        $query->orderBy('products.created_at', 'desc');

        return $query->paginate($perPage);
    }
}
