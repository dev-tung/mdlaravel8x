<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseRequest;
use App\Repositories\PurchaseRepository;
use App\Repositories\SupplierRepository;
use App\Repositories\ProductRepository;
use App\Services\PurchaseService;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    protected PurchaseRepository $purchaseRepository;
    protected SupplierRepository $supplierRepository;
    protected ProductRepository $productRepository;
    protected PurchaseService $purchaseService;

    public function __construct(
        PurchaseRepository $purchaseRepository,
        SupplierRepository $supplierRepository,
        ProductRepository $productRepository,
        PurchaseService $purchaseService
    ) {
        $this->purchaseRepository = $purchaseRepository;
        $this->supplierRepository = $supplierRepository;
        $this->productRepository = $productRepository;
        $this->purchaseService = $purchaseService;
    }

    /**
     * Hiển thị danh sách phiếu nhập
     */
    public function index(Request $request)
    {
        $filters = $request->only(['supplier_name', 'status', 'payment_method', 'from_date', 'to_date']);
        $perPage = $request->get('per_page', config('shared.pagination_per_page', 10));
        $purchases = $this->purchaseRepository->paginateWithFilters($filters, $perPage);
        $statuses = $this->purchaseRepository->statuses();
        $payments = $this->purchaseRepository->payments();

        return view('admin.purchases.index', compact('purchases', 'filters', 'statuses', 'payments'));
    }

    /**
     * Form tạo phiếu nhập mới
     */
    public function create()
    {
        $suppliers = $this->supplierRepository->all();
        $products = $this->productRepository->all();
        $statuses = $this->purchaseRepository->statuses();
        $payments = $this->purchaseRepository->payments();

        return view('admin.purchases.create', compact('suppliers', 'products', 'statuses', 'payments'));
    }

    /**
     * Lưu phiếu nhập mới
     */
    public function store(PurchaseRequest $request)
    {
        $this->purchaseService->create($request->all());

        return redirect()->route('admin.purchases.index')
            ->with('success', 'Phiếu nhập tạo thành công.');
    }

    /**
     * Form chỉnh sửa phiếu nhập
     */
    public function edit(int $id)
    {
        $purchase = $this->purchaseRepository->find($id);
        $suppliers = $this->supplierRepository->all();
        $products = $this->productRepository->all();

        return view('admin.purchases.edit', compact('purchase', 'suppliers', 'products'));
    }

    /**
     * Cập nhật phiếu nhập
     */
    public function update(Request $request, int $id)
    {
        $this->purchaseService->update($id, $request->all());

        return redirect()->route('admin.purchases.index')
            ->with('success', 'Phiếu nhập đã được cập nhật.');
    }

    /**
     * Xóa phiếu nhập
     */
    public function destroy(int $id)
    {
        $this->purchaseService->delete($id);

        return redirect()->route('admin.purchases.index')
            ->with('success', 'Phiếu nhập đã được xóa.');
    }

    /**
     * Xem chi tiết phiếu nhập
     */
    public function show(int $id)
    {
        $purchase = $this->purchaseRepository->find($id);
        return view('admin.purchases.show', compact('purchase'));
    }
}
