<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\PurchaseRepository;

class PurchaseController extends Controller
{
    protected $purchases;

    public function __construct(PurchaseRepository $purchases)
    {
        $this->purchases = $purchases;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['status']);
        $purchases = $this->purchases->getAll($filters);

        return view('admin.purchases.index', compact('purchases'));
    }

    public function create()
    {
        return view('admin.purchases.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'supplier_id'   => 'required|exists:suppliers,id',
            'user_id'       => 'required|exists:users,id',
            'total_amount'  => 'required|numeric|min:0',
            'status'        => 'required|string',
            'purchase_date' => 'required|date',
        ]);

        $this->purchases->create($data);

        return redirect()->route('admin.purchases.index')->with('success', 'Thêm phiếu nhập hàng thành công');
    }

    public function show($id)
    {
        $purchase = $this->purchases->find($id);
        return view('admin.purchases.show', compact('purchase'));
    }

    public function edit($id)
    {
        $purchase = $this->purchases->find($id);
        return view('admin.purchases.edit', compact('purchase'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'supplier_id'   => 'required|exists:suppliers,id',
            'user_id'       => 'required|exists:users,id',
            'total_amount'  => 'required|numeric|min:0',
            'status'        => 'required|string',
            'purchase_date' => 'required|date',
        ]);

        $this->purchases->update($id, $data);

        return redirect()->route('admin.purchases.index')->with('success', 'Cập nhật phiếu nhập hàng thành công');
    }

    public function destroy($id)
    {
        $this->purchases->delete($id);
        return redirect()->route('admin.purchases.index')->with('success', 'Xóa phiếu nhập hàng thành công');
    }
}
