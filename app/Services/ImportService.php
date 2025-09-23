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
            dd($data);
            $totalAmount = 0;
            $items       = [];

            // Duyệt từng sản phẩm
            foreach ($data['product_id'] as $i => $productId) {
                $quantity = isset($data['quantity'][$i])
                    ? (int) $data['quantity'][$i]
                    : 0;

                $price = isset($data['product_import_price'][$productId])
                    ? (int) $data['product_import_price'][$productId]
                    : 0;

                // lấy trạng thái gift
                $isGift = isset($data['is_gift'][$productId]) ? 1 : 0;

                // nếu là hàng tặng thì giá & tổng tiền = 0
                if ($isGift) {
                    $price = 0;
                    $totalPrice = 0;
                } else {
                    $totalPrice = $quantity * $price;
                    $totalAmount += $totalPrice;
                }

                $items[] = [
                    'product_id'         => $productId,
                    'quantity'           => $quantity,
                    'import_price'       => $price,
                    'total_import_price' => $totalPrice,
                    'is_gift'            => $isGift,
                    'created_at'         => now(),
                    'updated_at'         => now(),
                ];
            }

            // 1. Tạo Import chính
            $import = $this->importRepository->create([
                'supplier_id'         => $data['supplier_id'],
                'import_date'         => $data['import_date'],
                'status'              => $data['status'],
                'payment_method'      => $data['payment_method'],
                'notes'               => $data['notes'] ?? null,
                'total_import_amount' => $totalAmount,
            ]);

            // 2. Gắn import_id vào từng item
            foreach ($items as &$item) {
                $item['import_id'] = $import->id;
            }
            unset($item);

            // 3. Lưu items (1 lần insert)
            $this->importItemRepository->createMany($items);

            return $import;
        });
    }



}
