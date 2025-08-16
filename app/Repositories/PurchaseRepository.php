<?php

namespace App\Repositories;

use App\Models\Purchase;

class PurchaseRepository
{
    public function getAll($filters = [])
    {
        $query = Purchase::with(['supplier', 'user']);

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->paginate(10);
    }

    public function find($id)
    {
        return Purchase::with(['supplier', 'user', 'products'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return Purchase::create($data);
    }

    public function update($id, array $data)
    {
        $purchase = $this->find($id);
        $purchase->update($data);
        return $purchase;
    }

    public function delete($id)
    {
        $purchase = $this->find($id);
        return $purchase->delete();
    }
}
