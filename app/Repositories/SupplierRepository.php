<?php

namespace App\Repositories;

use App\Models\Supplier;
use Illuminate\Pagination\LengthAwarePaginator;

class SupplierRepository
{
    public function paginateWithFilters(array $filters = [], $perPage = 15): LengthAwarePaginator
    {
        $query = Supplier::query();

        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%'.$filters['name'].'%');
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage)->appends($filters);
    }

    public function all()
    {
        return Supplier::orderBy('created_at', 'desc')->get();
    }

    public function find(int $id): Supplier
    {
        return Supplier::findOrFail($id);
    }

    public function create(array $data): Supplier
    {
        return Supplier::create($data);
    }

    public function update(int $id, array $data): Supplier
    {
        $supplier = $this->find($id);
        $supplier->update($data);
        return $supplier;
    }

    public function delete(int $id): ?bool
    {
        return Supplier::destroy($id);
    }
}
