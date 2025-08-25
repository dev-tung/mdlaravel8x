<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\SupplierRepository;
use Illuminate\Http\Request;
use App\Http\Requests\SupplierRequest;

class SupplierController extends Controller
{
    protected $supplierRepository;

    public function __construct(SupplierRepository $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['name', 'phone', 'email']);
        $perPage = request('per_page', config('shared.pagination_per_page'));
        $suppliers = $this->supplierRepository->paginateWithFilters($filters, $perPage);

        return view('admin.suppliers.index', [
            'suppliers' => $suppliers,
            'filters' => $filters
        ]);
    }

    public function create()
    {
        return view('admin.suppliers.create');
    }

    public function store(SupplierRequest $request)
    {
        $data = $request->validated();
        $this->supplierRepository->create($data);

        return redirect()->route('admin.suppliers.index')->with('success', 'Nhà cung cấp tạo thành công!');
    }

    public function edit($id)
    {
        $supplier = $this->supplierRepository->find($id);
        return view('admin.suppliers.edit', compact('supplier'));
    }

    public function update(SupplierRequest $request, $id)
    {
        $data = $request->validated();
        $this->supplierRepository->update($id, $data);

        return redirect()->route('admin.suppliers.index')->with('success', 'Nhà cung cấp đã được cập nhật thành công.');
    }

    public function destroy($id)
    {
        $this->supplierRepository->delete($id);
        return redirect()->route('admin.suppliers.index')->with('success', 'Xóa nhà cung cấp thành công.');
    }
}
