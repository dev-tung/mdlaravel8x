<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\ExpenseRepository;
use App\Repositories\TaxonomyRepository;
use Illuminate\Http\Request;
use App\Http\Requests\ExpenseRequest;

class ExpenseController extends Controller
{
    protected $expenseRepository;
    protected $taxonomyRepository;

    public function __construct(ExpenseRepository $expenseRepository, TaxonomyRepository $taxonomyRepository)
    {
        $this->expenseRepository = $expenseRepository;
        $this->taxonomyRepository = $taxonomyRepository;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['name', 'taxonomy_id']);
        $perPage = $request->input('per_page', config('shared.pagination_per_page', 15));
        $expenses = $this->expenseRepository->paginateWithFilters($filters, $perPage);

        $taxonomies = $this->taxonomyRepository->getByType('expense');

        return view('admin.expenses.index', compact('expenses', 'filters', 'taxonomies'));
    }

    public function create()
    {
        $taxonomies = $this->taxonomyRepository->getByType('expense');
        return view('admin.expenses.create', compact('taxonomies'));
    }

    public function store(ExpenseRequest $request)
    {
        $data = $request->validated();
        $this->expenseRepository->create($data);

        return redirect()->route('admin.expenses.index')->with('success', 'Chi phí được tạo thành công.');
    }

    public function edit($id)
    {
        $expense = $this->expenseRepository->find($id);
        $taxonomies = $this->taxonomyRepository->getByType('expense');

        return view('admin.expenses.edit', compact('expense', 'taxonomies'));
    }

    public function update(ExpenseRequest $request, $id)
    {
        $data = $request->validated();
        $this->expenseRepository->update($id, $data);

        return redirect()->route('admin.expenses.index')->with('success', 'Chi phí đã được cập nhật thành công.');
    }

    public function destroy($id)
    {
        $this->expenseRepository->delete($id);

        return redirect()->route('admin.expenses.index')->with('success', 'Xóa chi phí thành công.');
    }
}
