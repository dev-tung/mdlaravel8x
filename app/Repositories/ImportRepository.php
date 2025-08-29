<?php

namespace App\Repositories;

use App\Models\Import;

class ImportRepository
{
    /**
     * Tạo mới 1 record trong bảng imports
     */
    public function create(array $data)
    {
        return Import::create($data);
    }

    /**
     * Lấy danh sách imports theo purchase_id
     */
    public function getByPurchaseId(int $purchaseId)
    {
        return Import::where('purchase_id', $purchaseId)->get();
    }

    /**
     * Xoá toàn bộ imports theo purchase_id (dùng khi update phiếu nhập)
     */
    public function deleteByPurchaseId(int $purchaseId)
    {
        return Import::where('purchase_id', $purchaseId)->delete();
    }

    /**
     * Cập nhật import theo id
     */
    public function update(int $id, array $data)
    {
        $import = Import::findOrFail($id);
        $import->update($data);
        return $import;
    }
}
