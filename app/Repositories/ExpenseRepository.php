<?php

namespace App\Repositories;

use App\Models\Expense;

class ExpenseRepository
{
    public function getAll($filters = [])
    {
        $query = Expense::query();

        if (!empty($filters['title'])) {
            $query->where('title', 'like', '%' . $filters['title'] . '%');
        }

        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['date'])) {
            $query->whereDate('date', $filters['date']);
        }

        return $query->orderBy('id', 'desc')->paginate(10);
    }

    public function find($id)
    {
        return Expense::findOrFail($id);
    }

    public function create(array $data)
    {
        return Expense::create($data);
    }

    public function update($id, array $data)
    {
        $expense = $this->find($id);
        $expense->update($data);
        return $expense;
    }

    public function delete($id)
    {
        $expense = $this->find($id);
        return $expense->delete();
    }
}
