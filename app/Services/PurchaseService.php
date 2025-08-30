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

        // Tạo phiếu nhập
        $purchase = $this->purchaseRepository->create([
            'supplier_id'   => $data['supplier_id'],
            'purchase_date' => $data['purchase_date'],
            'notes'         => $data['notes'] ?? null,
            'status'        => $data['status']
        ]);

        $totalAmount = 0;

        // Duyệt theo product_id (mảng từ form)
        foreach ($data['product_id'] ?? [] as $productId) {
            $productId = (int) $productId;
            if ($productId <= 0) {
                continue;
            }

            // quantity và price được map theo key = productId
            $qtyRaw   = $data['quantity'][$productId] ?? 0;
            $priceRaw = $data['product_price_input'][$productId] ?? 0;

            // Làm sạch giá (trường hợp gửi kèm ký tự . hoặc đ)
            $priceClean = preg_replace('/[^\d.]/', '', (string) $priceRaw);
            $price      = $priceClean === '' ? 0.0 : (float) $priceClean;
            $qty        = max(0, (int) $qtyRaw);

            if ($qty <= 0 || $price <= 0) {
                continue;
            }

            $subtotal = $qty * $price;

            // Thêm chi tiết nhập hàng
            $this->importRepository->create([
                'purchase_id' => $purchase->id,
                'product_id'  => $productId,
                'quantity'    => $qty,
                'price_input' => $price,
                'total_price' => $subtotal,
            ]);

            // Cập nhật tồn kho (+)
            $this->productRepository->increaseQuantity($productId, $qty);

            $totalAmount += $subtotal;
        }

        // Cập nhật tổng tiền cho phiếu nhập
        $this->purchaseRepository->update($purchase->id, [
            'total_amount' => $totalAmount
        ]);

        return $purchase;
    }


    /**
     * Xóa phiếu nhập
     */
    public function delete(int $id)
    {
        DB::beginTransaction();
        try {
            // Lấy purchase
            $purchase = $this->purchaseRepository->find($id);

            // Trừ tồn kho các sản phẩm của purchase này
            foreach ($purchase->imports as $item) {
                $this->productRepository->decreaseQuantity($item->product_id, $item->quantity);
            }

            // Xóa các imports liên quan đến purchase này
            DB::table('imports')->where('purchase_id', $id)->delete();

            // Xóa purchase
            $this->purchaseRepository->delete($id);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

}
