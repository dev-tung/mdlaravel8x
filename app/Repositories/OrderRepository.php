<?php
namespace App\Repositories;

use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderRepository
{
    public function paginateWithFilters(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Order::with('customer'); // Eager load customer

        
        // Filter theo tên khách hàng
        if (!empty($filters['customer_name'])) {
            $query->whereHas('customer', function($q) use ($filters) {
                $q->where('name', 'like', '%'.$filters['customer_name'].'%');
            });
        }

        // Filter theo trạng thái
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Filter theo phương thức thanh toán
        if (!empty($filters['payment_method'])) {
            $query->where('payment_method', $filters['payment_method']);
        }

        // Filter theo khoảng ngày
        if (!empty($filters['from_date']) && !empty($filters['to_date'])) {
            $query->whereBetween('order_date', [$filters['from_date'], $filters['to_date']]);
        } else {
            if (!empty($filters['from_date'])) {
                $query->whereDate('order_date', '>=', $filters['from_date']);
            }
            if (!empty($filters['to_date'])) {
                $query->whereDate('order_date', '<=', $filters['to_date']);
            }
        }

        // Sắp xếp theo ngày tạo giảm dần và phân trang
        return $query->orderBy('created_at', 'desc')
                     ->paginate($perPage)
                     ->appends($filters);
    }
    
    public function all()
    {
        return Order::with('customer')->orderBy('created_at','desc')->get();
    }

    public function find(int $id): Order
    {
        return Order::findOrFail($id);
    }

    public function create(array $data): Order
    {
        return Order::create($data);
    }

    public function update(int $id, array $data): Order
    {
        $order = $this->find($id);
        $order->update($data);
        return $order;
    }

    public function delete(int $id): ?bool
    {
        return Order::destroy($id);
    }

    public function statuses(): array
    {
        return [
            'pending' => 'Chờ xử lý',
            'processing' => 'Đang xử lý',
            'completed' => 'Hoàn thành',
            'cancelled' => 'Đã hủy',
        ];
    }

    public function payments(): array
    {
        return [
            'pending' => 'Chưa thanh toán',
            'cash' => 'Tiền mặt',
            'card' => 'Thẻ',
            'bank_transfer' => 'Chuyển khoản',
            'online' => 'Thanh toán online',
        ];
    }

    public function getRevenue($fromDate, $toDate)
    {
        return Order::whereBetween('order_date', [$fromDate, $toDate])
                    ->sum('final_amount');
    }
}
