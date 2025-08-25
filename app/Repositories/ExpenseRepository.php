<?php

namespace App\Repositories;

use App\Models\Expense;
use Illuminate\Pagination\LengthAwarePaginator;

class ExpenseRepository
{
    public function paginateWithFilters(array $filters = [], $perPage = 15): LengthAwarePaginator
    {
        $query = Expense::with('taxonomy');

        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%'.$filters['name'].'%');
        }

        if (!empty($filters['taxonomy_id'])) {
            $query->where('taxonomy_id', $filters['taxonomy_id']);
        }

        return $query->orderBy('expense_date', 'desc')->paginate($perPage)->appends($filters);
    }

    public function all()
    {
        return Expense::orderBy('expense_date', 'desc')->get();
    }

    public function find(int $id): Expense
    {
        return Expense::findOrFail($id);
    }

    public function create(array $data): Expense
    {
        return Expense::create($data);
    }

    public function update(int $id, array $data): Expense
    {
        $expense = $this->find($id);
        $expense->update($data);
        return $expense;
    }

    public function delete(int $id): ?bool
    {
        return Expense::destroy($id);
    }

    public function getExpense($fromDate, $toDate)
    {
        return Expense::whereBetween('expense_date', [$fromDate, $toDate])
                      ->sum('amount');
    }
}
