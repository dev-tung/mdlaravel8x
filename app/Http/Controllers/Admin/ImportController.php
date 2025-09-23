<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImportRequest;
use App\Repositories\ImportRepository;
use App\Repositories\SupplierRepository;
use App\Repositories\ProductRepository;
use App\Services\ImportService;
use Illuminate\Http\Request;
use App\Enums\EnumOptions;

class ImportController extends Controller
{
    protected ImportRepository $importRepository;
    protected SupplierRepository $supplierRepository;
    protected ProductRepository $productRepository;
    protected ImportService $importService;

    public function __construct(
        ImportRepository $importRepository,
        SupplierRepository $supplierRepository,
        ProductRepository $productRepository,
        ImportService $importService
    ) {
        $this->importRepository = $importRepository;
        $this->supplierRepository = $supplierRepository;
        $this->productRepository = $productRepository;
        $this->importService = $importService;
    }

    /**
     * Hiển thị danh sách phiếu nhập
     */
    public function index(Request $request)
    {
        $filters  = $request->only(['supplier_name', 'status', 'payment_method', 'from_date', 'to_date']);
        $perPage  = $request->get('per_page', config('shared.pagination_per_page', 10));
        $imports  = $this->importService->paginateWithFilters($filters, $perPage);
        $statuses = EnumOptions::importStatuses();
        $payments = EnumOptions::payments();

        return view('admin.imports.index', compact('imports', 'filters', 'statuses', 'payments'));
    }

    /**
     * Form tạo phiếu nhập mới
     */
    public function create()
    {
        $suppliers = $this->supplierRepository->all();
        $products  = $this->productRepository->all();
        $statuses  = EnumOptions::importStatuses();
        $payments  = EnumOptions::payments();

        return view('admin.imports.create', compact('suppliers', 'products', 'statuses', 'payments'));
    }

    /**
     * Lưu phiếu nhập mới
     */
    public function store(ImportRequest $request)
    {
        $this->importService->create($request->all());

        return redirect()->route('admin.imports.index')
            ->with('success', 'Phiếu nhập tạo thành công.');
    }

    /**
     * Form chỉnh sửa phiếu nhập
     */
    public function edit(int $id)
    {
        $purchase = $this->importRepository->find($id);
        $suppliers = $this->supplierRepository->all();
        $products = $this->productRepository->all();

        return view('admin.imports.edit', compact('purchase', 'suppliers', 'products'));
    }

    /**
     * Cập nhật phiếu nhập
     */
    public function update(Request $request, int $id)
    {
        $this->importService->update($id, $request->all());

        return redirect()->route('admin.imports.index')
            ->with('success', 'Phiếu nhập đã được cập nhật.');
    }

    /**
     * Xóa phiếu nhập
     */
    public function destroy(int $id)
    {
        $this->importService->delete($id);

        return redirect()->route('admin.imports.index')
            ->with('success', 'Phiếu nhập đã được xóa.');
    }

    /**
     * Xem chi tiết phiếu nhập
     */
    public function show(int $id)
    {
        $purchase = $this->importRepository->find($id);
        return view('admin.imports.show', compact('purchase'));
    }
}
