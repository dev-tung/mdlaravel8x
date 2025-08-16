<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\SupplierRepository;

class SupplierController extends Controller
{
    protected $suppliers;

    public function __construct(SupplierRepository $suppliers)
    {
        $this->suppliers = $suppliers;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['status', 'keyword']);
        $suppliers = $this->suppliers->getAll($filters);

        return view('admin.suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('admin.suppliers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'nullable|email|unique:suppliers,email',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'status'  => 'required|string',
        ]);

        $this->suppliers->create($data);

        return redirect()->route('admin.suppliers.index')->with('success', 'Thêm nhà cung cấp thành công');
    }

    public function show($id)
    {
        $supplier = $this->suppliers->find($id);
        return view('admin.suppliers.show', compact('supplier'));
    }

    public function edit($id)
    {
        $supplier = $this->suppliers->find($id);
        return view('admin.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'nullable|email|unique:suppliers,email,' . $id,
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'status'  => 'required|string',
        ]);

        $this->suppliers->update($id, $data);

        return redirect()->route('admin.suppliers.index')->with('success', 'Cập nhật nhà cung cấp thành công');
    }

    public function destroy($id)
    {
        $this->suppliers->delete($id);
        return redirect()->route('admin.suppliers.index')->with('success', 'Xóa nhà cung cấp thành công');
    }
}
