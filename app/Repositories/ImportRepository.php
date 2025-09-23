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

    public function update(Import $import, array $data): bool
    {
        return $import->update($data);
    }

    public function delete(int $id): ?bool
    {
        return Import::destroy($id);
    }
}
