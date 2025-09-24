<?php

namespace App\Repositories;

use App\Models\Export;

class ExportRepository
{
    public function query()
    {
        return Export::query()->with('supplier');
    }

    public function find(int $id): Export
    {
        return Export::with(['supplier', 'items.product'])->findOrFail($id);
    }

    public function create(array $data): Export
    {
        return Export::create($data);
    }

    public function update(int $id, array $data): bool
    {
        return Export::where('id', $id)->update($data);
    }

    public function delete(int $id): ?bool
    {
        return Export::destroy($id);
    }
}
