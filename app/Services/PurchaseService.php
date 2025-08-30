<?php

namespace App\Services;

use App\Repositories\PurchaseRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ImportRepository;
use Illuminate\Support\Facades\DB;
use Exception;

class PurchaseService
{
    protected PurchaseRepository $purchaseRepository;
    protected ProductRepository $productRepository;
    protected ImportRepository $importRepository;

    public function __construct(
        PurchaseRepository $purchaseRepository,
        ProductRepository $productRepository,
        ImportRepository $importRepository
    ) {
        $this->purchaseRepository = $purchaseRepository;
        $this->productRepository = $productRepository;
        $this->importRepository = $importRepository;
    }

    /**
     * Tạo phiếu nhập mới
     */
    public function create(array $data)
    {
        // Tạo purchase (phiếu mua hàng)
        $purchase = $this->purchaseRepository->create([
            'supplier_id'   => $data['supplier_id'],
            'purchase_date' => $data['purchase_date'],
            'notes'         => $data['notes'] ?? null,
        ]);

        // Chuẩn hoá danh sách items từ form
        $totalAmount = 0;
        foreach ($data['product_id'] ?? [] as $productId) {

            $subtotal = (int) ($data['quantity'][$productId] ?? 0) * (float) ($data['product_price_input'][$productId] ?? 0);
            // Thêm chi tiết vào bảng imports
            $this->importRepository->create([
                'purchase_id'           => $purchase->id,
                'product_id'            => $productId,
                'quantity'              => $data['quantity'][$productId],
                'price_input'   => $data['product_price_input'][$productId],
                'total_price'           => $subtotal
            ]);

            // Cập nhật tồn kho (+)
            $this->productRepository->increaseQuantity($productId, $data['quantity'][$productId]);
            $totalAmount += $subtotal;
        }

        // Cập nhật tổng tiền cho phiếu nhập
        $this->purchaseRepository->update($purchase->id, ['total_amount' => $totalAmount]);
    }


    /**
     * Xóa phiếu nhập
     */
    public function delete(int $id)
    {
        DB::beginTransaction();
        try {
            $purchase = $this->purchaseRepository->find($id);

            // Trừ tồn kho khi xóa
            foreach ($purchase->imports as $item) {
                $this->productRepository->decreaseQuantity($item->product_id, $item->quantity);
            }

            $this->purchaseRepository->delete($id);

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
