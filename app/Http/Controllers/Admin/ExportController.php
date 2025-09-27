<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExportRequest;
use App\Repositories\ExportRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\ProductRepository;
use App\Services\ExportService;
use Illuminate\Http\Request;
use App\Enums\EnumOptions;

class ExportController extends Controller
{
    protected ExportRepository $exportRepository;
    protected CustomerRepository $customerRepository;
    protected ProductRepository $productRepository;
    protected ExportService $exportService;

    public function __construct(
        ExportRepository $exportRepository,
        CustomerRepository $customerRepository,
        ProductRepository $productRepository,
        ExportService $exportService
    ) {
        $this->exportRepository = $exportRepository;
        $this->customerRepository = $customerRepository;
        $this->productRepository = $productRepository;
        $this->exportService = $exportService;
    }

    /**
     * Hiển thị danh sách phiếu nhập
     */
    public function index(Request $request)
    {
        $filters  = $request->only(['customer_name', 'status', 'payment_method', 'from_date', 'to_date']);
        $perPage  = $request->get('per_page', config('shared.pagination_per_page', 10));
        $exports  = $this->exportService->paginateWithFilters($filters, $perPage);
        $statuses = EnumOptions::exportStatuses();
        $payments = EnumOptions::payments();

        return view('admin.exports.index', compact('exports', 'filters', 'statuses', 'payments'));
    }

    /**
     * Form tạo phiếu nhập mới
     */
    public function create()
    {
        $customers = $this->customerRepository->all();
        $products  = $this->productRepository->all();
        $statuses  = EnumOptions::exportStatuses();
        $payments  = EnumOptions::payments();

        return view('admin.exports.create', compact('customers', 'products', 'statuses', 'payments'));
    }

    /**
     * Lưu phiếu nhập mới
     */
    public function store(ExportRequest $request)
    {
        $this->exportService->create($request->all());

        return redirect()->route('admin.exports.index')
            ->with('success', 'Phiếu nhập tạo thành công.');
    }

    /**
     * Form chỉnh sửa phiếu nhập
     */
    public function edit($id)
    {
        if (!$export = $this->exportRepository->find($id)) {
            return redirect()->route('admin.exports.index')->with('error', 'Phiếu nhập không tồn tại.');
        }

        return view('admin.exports.edit', [
            'export'    => $export,
            'customers' => $this->customerRepository->all(),
            'products'  => $this->productRepository->all(),
            'statuses'  => EnumOptions::exportStatuses(),
            'payments'  => EnumOptions::payments(),
        ]);
    }


    /**
     * Cập nhật phiếu nhập
     */
    public function update(ExportRequest $request, int $id)
    {
        $this->exportService->update($request->all());

        return redirect()->route('admin.exports.index')
            ->with('success', 'Phiếu nhập đã được cập nhật.');
    }

    /**
     * Xóa phiếu nhập
     */
    public function destroy(int $id)
    {
        $this->exportService->destroy($id);

        return redirect()->route('admin.exports.index')
            ->with('success', 'Phiếu nhập đã được xóa.');
    }

    /**
     * Xem chi tiết phiếu nhập
     */
    public function show(int $id)
    {
        $purchase = $this->exportRepository->find($id);
        return view('admin.exports.show', compact('purchase'));
    }
}
