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

    public function update(int $id, array $data): bool
    {
        return Product::findOrFail($id)->update($data);
    }

    public function delete(int $id)
    {
        return Product::destroy($id);
    }
}
