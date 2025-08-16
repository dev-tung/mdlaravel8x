<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\OrderRepository;

class OrderController extends Controller
{
    protected $orders;

    public function __construct(OrderRepository $orders)
    {
        $this->orders = $orders;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['status', 'customer_id']);
        $orders = $this->orders->getAll($filters);

        return view('admin.orders.index', compact('orders'));
    }

    public function create()
    {
        return view('admin.orders.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id'      => 'required|exists:customers,id',
            'total_amount'     => 'required|numeric',
            'status'           => 'required|string',
            'payment_method'   => 'nullable|string',
            'shipping_address' => 'nullable|string',
        ]);

        $this->orders->create($data);

        return redirect()->route('admin.orders.index')->with('success', 'Thêm đơn hàng thành công');
    }

    public function show($id)
    {
        $order = $this->orders->find($id);
        return view('admin.orders.show', compact('order'));
    }

    public function edit($id)
    {
        $order = $this->orders->find($id);
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'customer_id'      => 'required|exists:customers,id',
            'total_amount'     => 'required|numeric',
            'status'           => 'required|string',
            'payment_method'   => 'nullable|string',
            'shipping_address' => 'nullable|string',
        ]);

        $this->orders->update($id, $data);

        return redirect()->route('admin.orders.index')->with('success', 'Cập nhật đơn hàng thành công');
    }

    public function destroy($id)
    {
        $this->orders->delete($id);
        return redirect()->route('admin.orders.index')->with('success', 'Xóa đơn hàng thành công');
    }
}
