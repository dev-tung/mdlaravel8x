<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\ExpenseRepository;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    protected $expenses;

    public function __construct(ExpenseRepository $expenses)
    {
        $this->expenses = $expenses;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['title', 'status', 'date']);
        $expenses = $this->expenses->getAll($filters);
        return view('admin.expenses.index', compact('expenses'));
    }

    public function create()
    {
        return view('admin.expenses.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'  => 'required|string|max:255',
            'amount' => 'required|numeric',
            'date'   => 'required|date',
            'note'   => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        $this->expenses->create($data);

        return redirect()->route('admin.expenses.index')->with('success', 'Thêm chi phí thành công');
    }

    public function edit($id)
    {
        $expense = $this->expenses->find($id);
        return view('admin.expenses.edit', compact('expense'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title'  => 'required|string|max:255',
            'amount' => 'required|numeric',
            'date'   => 'required|date',
            'note'   => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        $this->expenses->update($id, $data);

        return redirect()->route('admin.expenses.index')->with('success', 'Cập nhật chi phí thành công');
    }

    public function destroy($id)
    {
        $this->expenses->delete($id);
        return redirect()->route('admin.expenses.index')->with('success', 'Xóa chi phí thành công');
    }
}
