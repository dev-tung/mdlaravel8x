<?php

namespace App\Services;

use App\Repositories\OrderRepository;
use App\Repositories\ItemRepository;
use App\Repositories\ExpenseRepository;
use App\Models\Order;
use Illuminate\Validation\ValidationException;

class OrderService
{
    protected OrderRepository $orderRepository;
    protected ItemRepository $itemRepository;
    protected ExpenseRepository $expenseRepository;

    public function __construct(OrderRepository $orderRepository, ItemRepository $itemRepository, ExpenseRepository $expenseRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->itemRepository = $itemRepository;
        $this->expenseRepository = $expenseRepository;
    }

    /**
     * Tạo đơn hàng mới
     *
     * @param array $data
     * @return Order
     */
    public function create(array $data)
    {
        $order = $this->orderRepository->create($data);
        
        $totalAmount = 0; $discountAmount = 0;
        foreach( $data['product_id'] as $product_id ){
            $subtotal = $data['product_price_output'][$product_id] * $data['quantity'][$product_id];

            $this->itemRepository->create([
                'order_id'              => $order->id,
                'product_id'            => $product_id,
                'quantity'              => $data['quantity'][$product_id],
                'product_price_output'  => $data['product_price_output'][$product_id],
                'product_price_input'   => $data['product_price_input'][$product_id],
                'is_gift'               => !empty( $data['is_gift'][$product_id] ) ? true : false,
                'discount'              => $data['discount'][$product_id],
                'subtotal'              => $subtotal
            ]);

            if(!empty( $data['is_gift'][$product_id] )){
                // Ghi nhận chi phí quà tặng
                $this->expenseRepository->create([
                    'name'          => "<a href='".route('admin.orders.show', $order->id)."' target='_blank'>Quà tặng đơn hàng</a>",
                    'taxonomy_id'   => 50, // Chi phí bán hàng
                    'amount'        => $data['product_price_input'][$product_id] * $data['quantity'][$product_id],
                    'expense_date'  => $order->order_date
                ]);
            }

            $totalAmount = $totalAmount + $subtotal;
            $discountAmount = $discountAmount + $data['discount'][$product_id];
        }

        $this->orderRepository->update($order->id, [
            'total_amount'      => $totalAmount, 
            'discount_amount'   => $discountAmount
        ]);
        
    }

    /**
     * Xóa đơn hàng
     *
     * @param int $id
     * @return bool|null
     */
    public function delete(int $id): ?bool
    {
        // Có thể thêm logic kiểm tra trước khi xóa
        $this->orderRepository->delete($id);
        $this->itemRepository->deleteByOrderId($id);
        return true;
    }

}
