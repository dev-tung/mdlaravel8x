<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function query()
    {
        return Product::query();
    }

    public function all()
    {
        return Product::all();
    }

    public function find(int $id)
    {
        return Product::findOrFail($id);
    }

    public function create(array $data)
    {
        return Product::create($data);
    }

    public function update(int $id, array $data)
    {
        $product = $this->find($id);
        $product->update($data);
        return $product;
    }

    public function delete(int $id)
    {
        return Product::destroy($id);
    }
}
