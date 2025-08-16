<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CustomerRepository;
use App\Models\Customer;

class CustomerController extends Controller
{
    protected $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    // GET /admin/customers
    public function index(Request $request)
    {
        $customers = $this->customerRepository->getAll($request->all());
        return view('admin.customers.index', compact('customers'));
    }

    // GET /admin/customers/create
    public function create()
    {
        return view('admin.customers.create');
    }

    // POST /admin/customers
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'nullable|email|unique:customers,email',
            'phone' => 'nullable|string|max:20',
            'status'=> 'boolean'
        ]);

        $this->customerRepository->create($data);

        return redirect()->route('admin.customers.index')
            ->with('success', 'Thêm khách hàng thành công');
    }

    // GET /admin/customers/{id}/edit
    public function edit($id)
    {
        $customer = $this->customerRepository->find($id);
        return view('admin.customers.edit', compact('customer'));
    }

    // PUT/PATCH /admin/customers/{id}
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'nullable|email|unique:customers,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'status'=> 'boolean'
        ]);

        $this->customerRepository->update($id, $data);

        return redirect()->route('admin.customers.index')
            ->with('success', 'Cập nhật khách hàng thành công');
    }

    // DELETE /admin/customers/{id}
    public function destroy($id)
    {
        $this->customerRepository->delete($id);

        return redirect()->route('admin.customers.index')
            ->with('success', 'Xóa khách hàng thành công');
    }
}
