<?php

namespace App\Repositories;

use App\Models\Customer;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomerRepository
{
    public function paginateWithFilters(array $filters = [], $perPage = 15): LengthAwarePaginator
    {
        $query = Customer::query();

        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%'.$filters['name'].'%');
        }

        if (!empty($filters['email'])) {
            $query->where('email', 'like', '%'.$filters['email'].'%');
        }

        return $query->where('status', 'active')->orderBy('created_at', 'desc')->paginate($perPage)->appends($filters);
    }

    public function all()
    {
        return Customer::with('taxonomy')->orderBy('created_at', 'desc')->get();
    }

    public function find(int $id): Customer
    {
        return Customer::findOrFail($id);
    }

    public function create(array $data): Customer
    {
        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }
        return Customer::create($data);
    }

    public function update(int $id, array $data): Customer
    {
        $customer = $this->find($id);
        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }
        $customer->update($data);
        return $customer;
    }

    public function delete(int $id): ?bool
    {
        $customer = $this->find($id);
        return $customer->update(['status' => 'inactive']);
    }
}
