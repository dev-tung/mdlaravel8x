<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Repositories\OrderRepository;
use App\Repositories\TaxonomyRepository;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected OrderRepository $orderRepository;
    protected TaxonomyRepository $taxonomyRepository;
    protected OrderService $orderService;

    public function __construct(
        OrderRepository $orderRepository,
        TaxonomyRepository $taxonomyRepository,
        OrderService $orderService
    ) {
        $this->orderRepository = $orderRepository;
        $this->taxonomyRepository = $taxonomyRepository;
        $this->orderService = $orderService;
    }

    /**
     * Hiển thị danh sách đơn hàng
     */
    public function index(Request $request)
    {
        $filters    = $request->only(['customer_name', 'status', 'payment_method', 'from_date', 'to_date']);
        $perPage    = $request->get('per_page', config('shared.pagination_per_page', 10));
        $orders     = $this->orderRepository->paginateWithFilters($filters, $perPage);
        $statuses   = $this->orderRepository->statuses();
        $payments   = $this->orderRepository->payments();

        return view('admin.orders.index', compact('orders', 'filters', 'statuses', 'payments'));
    }

    /**
     * Form tạo đơn hàng mới
     */
    public function create()
    {
        $taxonomies = $this->taxonomyRepository->getByType('customer');
        $statuses   = $this->orderRepository->statuses();
        $payments   = $this->orderRepository->payments();
        return view('admin.orders.create', compact('taxonomies', 'statuses', 'payments'));
    }

    /**
     * Lưu đơn hàng mới
     */
    public function store(OrderRequest $request)
    {
        $this->orderService->create($request->all());

        return redirect()->route('admin.orders.index')
            ->with('success', 'Đơn hàng tạo thành công.');
    }

    /**
     * Form chỉnh sửa đơn hàng
     */
    public function edit(int $id)
    {
        $order      = $this->orderRepository->find($id);
        $taxonomies = $this->taxonomyRepository->getByType('customer');
        return view('admin.orders.edit', compact('order', 'customers', 'taxonomies', 'products'));
    }

    /**
     * Cập nhật đơn hàng
     */
    public function update(Request $request, int $id)
    {
        $this->orderService->update($id, $request->all());

        return redirect()->route('admin.orders.index')
            ->with('success', 'Đơn hàng đã được cập nhật.');
    }

    /**
     * Xóa đơn hàng
     */
    public function destroy(int $id)
    {
        $this->orderService->delete($id);

        return redirect()->route('admin.orders.index')
            ->with('success', 'Đơn hàng đã được xóa.');
    }

    /**
     * Xem chi tiết đơn hàng
     */
    public function show(int $id)
    {
        $order = $this->orderRepository->find($id);
        return view('admin.orders.show', compact('order'));
    }
}
