<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\PaymentRepository;

class PaymentController extends Controller
{
    protected $payments;

    public function __construct(PaymentRepository $payments)
    {
        $this->payments = $payments;
    }

    public function index()
    {
        $payments = $this->payments->getAll();
        return view('admin.payments.index', compact('payments'));
    }

    public function create()
    {
        return view('admin.payments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'method' => 'required|string',
            'status' => 'required|string',
        ]);

        $this->payments->create($request->all());

        return redirect()->route('admin.payments.index')->with('success', 'Thanh toán đã được tạo thành công.');
    }

    public function show($id)
    {
        $payment = $this->payments->find($id);
        return view('admin.payments.show', compact('payment'));
    }

    public function edit($id)
    {
        $payment = $this->payments->find($id);
        return view('admin.payments.edit', compact('payment'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'method' => 'required|string',
            'status' => 'required|string',
        ]);

        $this->payments->update($id, $request->all());

        return redirect()->route('admin.payments.index')->with('success', 'Cập nhật thanh toán thành công.');
    }

    public function destroy($id)
    {
        $this->payments->delete($id);
        return redirect()->route('admin.payments.index')->with('success', 'Xóa thanh toán thành công.');
    }
}
