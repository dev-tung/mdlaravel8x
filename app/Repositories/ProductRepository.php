<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\ProductVariant;

class ProductRepository
{
    public function query()
    {
        return Product::query();
    }

    public function all()
    {
        return Product::with('variants')->get();
    }

    public function find(int $id)
    {
        return Product::findOrFail($id);
    }

    public function createWithVariant(array $data): Product
    {
        // tách dữ liệu product
        $productData = collect($data)->only((new Product)->getFillable())->toArray();

        // tạo product
        $product = Product::create($productData);

        // tách dữ liệu variant
        $variantData = collect($data)->only((new ProductVariant)->getFillable())->toArray();

        // tạo variant gắn với product
        $product->variant()->create($variantData);

        return $product->load('variant');
    }

    public function update(int $id, array $data): bool
    {
        return Product::findOrFail($id)->update($data);
    }

    public function delete(int $id)
    {
        return Product::destroy($id);
    }
}
