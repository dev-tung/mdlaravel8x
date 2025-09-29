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

    public function create(array $data): Product
    {
        $productData = collect($data)->only((new Product)->getFillable())->toArray();
        return Product::create($productData);
    }

    public function addVariants(Product $product, array $variants): void
    {
        foreach ($variants as $variant) {
            $variantData = collect($variant)->only((new ProductVariant)->getFillable())->toArray();
            $product->variants()->create($variantData);
        }
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
