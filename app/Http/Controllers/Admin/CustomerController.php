<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\CustomerRepository;
use App\Repositories\TaxonomyRepository;
use App\Http\Requests\CustomerRequest;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected CustomerRepository $customerRepository;
    protected TaxonomyRepository $taxonomyRepository;

    public function __construct(
        CustomerRepository $customerRepository,
        TaxonomyRepository $taxonomyRepository
    ) {
        $this->customerRepository = $customerRepository;
        $this->taxonomyRepository = $taxonomyRepository;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['name', 'email']);
        $perPage = $request->input('per_page', config('shared.pagination_per_page', 15));
        $customers = $this->customerRepository->paginateWithFilters($filters, $perPage);
        $taxonomies = $this->taxonomyRepository->getByType('customer');

        return view('admin.customers.index', compact('customers', 'filters', 'taxonomies'));
    }

    public function create()
    {
        $taxonomies = $this->taxonomyRepository->getByType('customer');
        return view('admin.customers.create', compact('taxonomies'));
    }

    public function store(CustomerRequest $request)
    {
        $this->customerRepository->create($request->validated());
        return redirect()->route('admin.customers.index')->with('success', 'Khách hàng tạo thành công.');
    }

    public function edit($id)
    {
        $customer = $this->customerRepository->find($id);
        if (!$customer) {
            return redirect()->route('admin.customers.index')->with('error', 'Khách hàng không tồn tại.');
        }
        $taxonomies = $this->taxonomyRepository->getByType('customer');
        return view('admin.customers.edit', compact('customer', 'taxonomies'));
    }

    public function update(CustomerRequest $request, $id)
    {
        $this->customerRepository->update($id, $request->validated());
        return redirect()->route('admin.customers.index')->with('success', 'Khách hàng đã được cập nhật.');
    }

    public function destroy($id)
    {
        try {
            $this->customerRepository->delete($id);
            return redirect()->route('admin.customers.index')->with('success', 'Xóa khách hàng thành công.');
        } catch (\Exception $e) {
            return redirect()->route('admin.customers.index')->with('error', 'Có lỗi xảy ra khi xóa khách hàng.');
        }
    }

    public function show($id)
    {
        $customer = $this->customerRepository->find($id);
        if (!$customer) {
            return redirect()->route('admin.customers.index')->with('error', 'Khách hàng không tồn tại.');
        }
        return view('admin.customers.show', compact('customer'));
    }
}
