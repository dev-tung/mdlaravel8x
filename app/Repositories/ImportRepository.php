<?php

namespace App\Repositories;

use App\Models\Import;

class ImportRepository
{
    public function query()
    {
        return Import::query()->with('supplier');
    }

    public function find(int $id): Import
    {
        return Import::with(['supplier', 'items.product'])->findOrFail($id);
    }

    public function create(array $data): Import
    {
        return Import::create($data);
    }

    public function update(int $id, array $data): bool
    {
        return Import::where('id', $id)->update($data);
    }

    public function delete(int $id): ?bool
    {
        return Import::destroy($id);
    }
}
