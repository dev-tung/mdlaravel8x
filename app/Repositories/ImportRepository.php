<?php

namespace App\Repositories;

use App\Models\Import;
use Illuminate\Pagination\LengthAwarePaginator;

class ImportRepository
{
    public function paginateWithFilters(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Import::with('supplier'); // Eager load nhà cung cấp

        // Filter theo tên nhà cung cấp
        $query->when(!empty($filters['supplier_name']), function ($q) use ($filters) {
            $q->whereHas('supplier', fn($c) =>
                $c->where('name', 'like', '%' . $filters['supplier_name'] . '%')
            );
        });

        // Filter theo trạng thái
        $query->when(!empty($filters['status']), fn($q) =>
            $q->where('status', $filters['status'])
        );

        // Filter theo phương thức thanh toán
        $query->when(!empty($filters['payment_method']), fn($q) =>
            $q->where('payment_method', $filters['payment_method'])
        );

        // Filter theo khoảng ngày nhập
        $query->when(!empty($filters['from_date']) && !empty($filters['to_date']), function ($q) use ($filters) {
            $q->whereBetween('import_date', [$filters['from_date'], $filters['to_date']]);
        });

        $query->when(!empty($filters['from_date']) && empty($filters['to_date']), fn($q) =>
            $q->whereDate('import_date', '>=', $filters['from_date'])
        );

        $query->when(empty($filters['from_date']) && !empty($filters['to_date']), fn($q) =>
            $q->whereDate('import_date', '<=', $filters['to_date'])
        );

        // Trả về kết quả phân trang
        return $query->orderBy('created_at', 'desc')
                     ->paginate($perPage)
                     ->appends($filters);
    }

    public function all()
    {
        return Import::with('supplier')->orderBy('created_at', 'desc')->get();
    }

    public function find(int $id): Import
    {
        return Import::with(['supplier', 'imports.product'])->findOrFail($id);
    }

    public function create(array $data): Import
    {
        return Import::create($data);
    }

    public function update(int $id, array $data): Import
    {
        $import = $this->find($id);
        $import->update($data);
        return $import;
    }

    public function delete(int $id): ?bool
    {
        return Import::destroy($id);
    }

    public function statuses(): array
    {
        return [
            'pending'    => 'Chờ nhập',
            'received'   => 'Đã nhập kho',
            'cancelled'  => 'Đã hủy',
        ];
    }

    public function payments(): array
    {
        return [
            'pending'        => 'Chưa thanh toán',
            'cash'           => 'Tiền mặt',
            'bank_transfer'  => 'Chuyển khoản',
            'card'           => 'Thẻ',
        ];
    }

    public function getTotalImportCost($fromDate, $toDate)
    {
        return Import::whereBetween('import_date', [$fromDate, $toDate])
                       ->sum('final_amount');
    }

    public function updateStatus(int $id, string $status): Import
    {
        $import = $this->find($id);
        $import->update(['status' => $status]);
        return $import;
    }

    public function updatePayment(int $id, string $method): Import
    {
        $import = $this->find($id);
        $import->update(['payment_method' => $method]);
        return $import;
    }
}
