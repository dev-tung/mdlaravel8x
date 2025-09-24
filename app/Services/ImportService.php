<?php

namespace App\Services;

use App\Repositories\ImportRepository;
use App\Repositories\ImportItemRepository;
use Illuminate\Support\Facades\DB;
use App\Models\Import;
use Illuminate\Pagination\LengthAwarePaginator;

class ImportService
{
    protected $importRepository;
    protected $importItemRepository;

    public function __construct(
        ImportRepository $importRepository,
        ImportItemRepository $importItemRepository
    ) {
        $this->importRepository = $importRepository;
        $this->importItemRepository = $importItemRepository;
    }

    public function paginateWithFilters(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->importRepository->query();

        $query->when(!empty($filters['supplier_name']), function ($q) use ($filters) {
            $q->whereHas('supplier', fn($c) =>
                $c->where('name', 'like', '%' . $filters['supplier_name'] . '%')
            );
        });

        $query->when(!empty($filters['status']), fn($q) =>
            $q->where('status', $filters['status'])
        );

        $query->when(!empty($filters['payment_method']), fn($q) =>
            $q->where('payment_method', $filters['payment_method'])
        );

        $query->when(!empty($filters['from_date']) && !empty($filters['to_date']), function ($q) use ($filters) {
            $q->whereBetween('import_date', [$filters['from_date'], $filters['to_date']]);
        });

        $query->when(!empty($filters['from_date']) && empty($filters['to_date']), fn($q) =>
            $q->whereDate('import_date', '>=', $filters['from_date'])
        );

        $query->when(empty($filters['from_date']) && !empty($filters['to_date']), fn($q) =>
            $q->whereDate('import_date', '<=', $filters['to_date'])
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
                $price = (int) ($data['product_import_price'][$productId] ?? 0);
                $isGift = isset($data['is_gift'][$productId]) ? 1 : 0;

                if ($isGift) {
                    $price = 0;
                    $totalPrice = 0;
                } else {
                    $totalPrice = $quantity * $price;
                }

                return [
                    'product_id'         => $productId,
                    'quantity'           => $quantity,
                    'import_price'       => $price,
                    'total_import_price' => $totalPrice,
                    'is_gift'            => $isGift,
                    'created_at'         => now(),
                    'updated_at'         => now(),
                ];
            });

            $totalAmount = $items->sum('total_import_price');

            $import = $this->importRepository->create([
                'supplier_id'         => $data['supplier_id'],
                'import_date'         => $data['import_date'],
                'status'              => $data['status'],
                'payment_method'      => $data['payment_method'],
                'notes'               => $data['notes'] ?? null,
                'total_import_amount' => $totalAmount,
            ]);

            $items = $items->map(fn($item) => array_merge($item, ['import_id' => $import->id]));

            $this->importItemRepository->createMany($items->toArray());

            return $import;
        });
    }


    public function update(array $data)
    {
        return DB::transaction(function () use ($data) {
            $importId = $data['import_id'];
            $import = $this->importRepository->find($importId);

            // Chuẩn bị items mới
            $newItems = collect($data['product_id'])->mapWithKeys(function ($productId) use ($data) {
                $quantity = (int) ($data['quantity'][$productId] ?? 0);
                $price = (float) ($data['product_import_price'][$productId] ?? 0);
                $isGift = isset($data['is_gift'][$productId]);
                $totalPrice = $isGift ? 0 : $quantity * $price;

                return [$productId => [
                    'product_id'         => $productId,
                    'quantity'           => $quantity,
                    'import_price'       => $price,
                    'total_import_price' => $totalPrice,
                    'is_gift'            => $isGift,
                ]];
            });

            // Cập nhật import chính
            $this->importRepository->update($importId, [
                'supplier_id'         => $data['supplier_id'],
                'import_date'         => $data['import_date'],
                'status'              => $data['status'],
                'payment_method'      => $data['payment_method'],
                'notes'               => $data['notes'] ?? null,
                'total_import_amount' => $newItems->sum('total_import_price'),
            ]);

            // Lấy items hiện tại
            $existingItems = $this->importItemRepository->getByImportId($importId)
                ->keyBy('product_id');

            // Xử lý items
            $itemsToUpdate = $newItems->intersectByKeys($existingItems)->map(function ($item, $productId) use ($existingItems) {
                return array_merge($item, ['id' => $existingItems[$productId]->id]);
            });

            $itemsToInsert = $newItems->diffKeys($existingItems)->map(fn($item) => array_merge($item, [
                'import_id'  => $importId,
                'created_at' => now(),
                'updated_at' => now(),
            ]));

            $itemsToDelete = $existingItems->diffKeys($newItems)->pluck('id');

            if ($itemsToDelete->isNotEmpty()) {
                $this->importItemRepository->deleteMany($itemsToDelete->all());
            }

            foreach ($itemsToUpdate as $item) {
                $this->importItemRepository->update($item['id'], $item);
            }

            if ($itemsToInsert->isNotEmpty()) {
                $this->importItemRepository->createMany($itemsToInsert->values()->all());
            }

            return $this->importRepository->find($importId);
        });
    }


    
    /**
     * Xóa phiếu nhập và tất cả items liên quan
     */
    public function destroy(int $importId)
    {
        return DB::transaction(function () use ($importId) {

            // 1. Lấy import
            $import = $this->importRepository->find($importId);
            if (!$import) {
                throw new \Exception("Import #{$importId} không tồn tại.");
            }

            // 2. Xóa tất cả import items
            $this->importItemRepository->deleteByImportId($importId);

            // 3. Xóa import chính
            $this->importRepository->delete($importId);

            return true;
        });
    }


}
