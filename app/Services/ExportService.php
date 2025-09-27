<?php

namespace App\Services;

use App\Repositories\ExportRepository;
use App\Repositories\ExportItemRepository;
use Illuminate\Support\Facades\DB;
use App\Models\Export;
use Illuminate\Pagination\LengthAwarePaginator;

class ExportService
{
    protected $exportRepository;
    protected $exportItemRepository;

    public function __construct(
        ExportRepository $exportRepository,
        ExportItemRepository $exportItemRepository
    ) {
        $this->exportRepository = $exportRepository;
        $this->exportItemRepository = $exportItemRepository;
    }

    public function paginateWithFilters(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->exportRepository->query();

        $query->when(!empty($filters['customer_name']), function ($q) use ($filters) {
            $q->whereHas('customer', fn($c) =>
                $c->where('name', 'like', '%' . $filters['customer_name'] . '%')
            );
        });

        $query->when(!empty($filters['status']), fn($q) =>
            $q->where('status', $filters['status'])
        );

        $query->when(!empty($filters['payment_method']), fn($q) =>
            $q->where('payment_method', $filters['payment_method'])
        );

        $query->when(!empty($filters['from_date']) && !empty($filters['to_date']), function ($q) use ($filters) {
            $q->whereBetween('export_date', [$filters['from_date'], $filters['to_date']]);
        });

        $query->when(!empty($filters['from_date']) && empty($filters['to_date']), fn($q) =>
            $q->whereDate('export_date', '>=', $filters['from_date'])
        );

        $query->when(empty($filters['from_date']) && !empty($filters['to_date']), fn($q) =>
            $q->whereDate('export_date', '<=', $filters['to_date'])
        );

        return $query->orderBy('created_at', 'desc')
                     ->paginate($perPage)
                     ->appends($filters);
    }

    /**
     * Tạo phiếu nhập + chi tiết items
     */
    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {

            $items = collect($data['product_id'])->map(function ($productId) use ($data) {
                $quantity = (int) ($data['quantity'][$productId] ?? 0);
                $priceSale = (float) ($data['price_sale'][$productId] ?? 0);
                $importPrice = (float) ($data['current_import_price'][$productId] ?? 0);
                $originalPrice = (float) ($data['current_price_original'][$productId] ?? $priceSale);
                $discount = (float) ($data['discount'][$productId] ?? 0);
                $isGift = !empty($data['is_gift'][$productId]);

                $totalPrice = $isGift ? 0 : max(0, $quantity * $priceSale - $discount);

                return [
                    'product_id'             => $productId,
                    'quantity'               => $quantity,
                    'current_import_price'   => $importPrice,
                    'current_price_original' => $originalPrice,
                    'discount'               => $discount,
                    'current_price_sale'     => $priceSale,
                    'total_export_price'     => $totalPrice,
                    'is_gift'                => $isGift ? 1 : 0,
                    'created_at'             => now(),
                    'updated_at'             => now(),
                ];
            })->filter(fn($item) => $item['quantity'] > 0 || $item['is_gift']);

            

            $totalAmount = $items->sum('total_export_price');

            $export = $this->exportRepository->create([
                'customer_id'         => $data['customer_id'],
                'export_date'         => $data['export_date'],
                'status'              => $data['status'],
                'payment_method'      => $data['payment_method'],
                'notes'               => $data['notes'] ?? null,
                'total_export_amount' => $totalAmount,
                'created_at'          => now(),
                'updated_at'          => now(),
            ]);

            $items = $items->map(fn($item) => array_merge($item, ['export_id' => $export->id]));

            $this->exportItemRepository->createMany($items->toArray());

            return $export;
        });
    }

    public function update(array $data)
    {
        return DB::transaction(function () use ($data) {
            $exportId = $data['export_id'];
            $export = $this->exportRepository->find($exportId);

            // Chuẩn bị items mới
            $newItems = collect($data['product_id'])->mapWithKeys(function ($productId) use ($data) {
                $quantity = (int) ($data['quantity'][$productId] ?? 0);
                $price = (float) ($data['product_export_price'][$productId] ?? 0);
                $isGift = isset($data['is_gift'][$productId]);
                $totalPrice = $isGift ? 0 : $quantity * $price;

                return [$productId => [
                    'product_id'         => $productId,
                    'quantity'           => $quantity,
                    'export_price'       => $price,
                    'total_export_price' => $totalPrice,
                    'is_gift'            => $isGift,
                ]];
            });

            // Cập nhật export chính
            $this->exportRepository->update($exportId, [
                'customer_id'         => $data['customer_id'],
                'export_date'         => $data['export_date'],
                'status'              => $data['status'],
                'payment_method'      => $data['payment_method'],
                'notes'               => $data['notes'] ?? null,
                'total_export_amount' => $newItems->sum('total_export_price'),
            ]);

            // Lấy items hiện tại
            $existingItems = $this->exportItemRepository->getByExportId($exportId)->keyBy('product_id');

            // Xử lý items
            $itemsToUpdate = $newItems->intersectByKeys($existingItems)->map(function ($item, $productId) use ($existingItems) {
                return array_merge($item, ['id' => $existingItems[$productId]->id]);
            });

            $itemsToInsert = $newItems->diffKeys($existingItems)->map(fn($item) => array_merge($item, [
                'export_id'  => $exportId,
                'created_at' => now(),
                'updated_at' => now(),
            ]));

            $itemsToDelete = $existingItems->diffKeys($newItems)->pluck('id');

            if ($itemsToDelete->isNotEmpty()) {
                $this->exportItemRepository->deleteMany($itemsToDelete->all());
            }

            foreach ($itemsToUpdate as $item) {
                $this->exportItemRepository->update($item['id'], $item);
            }

            if ($itemsToInsert->isNotEmpty()) {
                $this->exportItemRepository->createMany($itemsToInsert->values()->all());
            }

            return $this->exportRepository->find($exportId);
        });
    }


    
    /**
     * Xóa phiếu nhập và tất cả items liên quan
     */
    public function destroy(int $exportId)
    {
        return DB::transaction(function () use ($exportId) {

            // 1. Lấy export
            $export = $this->exportRepository->find($exportId);
            if (!$export) {
                throw new \Exception("Export #{$exportId} không tồn tại.");
            }

            // 2. Xóa tất cả export items
            $this->exportItemRepository->deleteByExportId($exportId);

            // 3. Xóa export chính
            $this->exportRepository->delete($exportId);

            return true;
        });
    }


}
