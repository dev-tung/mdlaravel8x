<?php

namespace App\Repositories;

use App\Models\ExportItem;
use Illuminate\Database\Eloquent\Collection;

class ExportItemRepository
{
    /**
     * Lấy tất cả item theo export_id
     */
    public function getByExportId(int $exportId): Collection
    {
        return ExportItem::with('product')
            ->where('export_id', $exportId)
            ->get();
    }

    /**
     * Tìm 1 item theo id
     */
    public function find(int $id): ExportItem
    {
        return ExportItem::with('product')->findOrFail($id);
    }

    /**
     * Tạo mới item
     */
    public function create(array $data): ExportItem
    {
        return ExportItem::create($data);
    }

    /**
     * Tạo nhiều items một lúc
     */
    public function createMany(array $items): void
    {
        ExportItem::insert($items);
    }

    /**
     * Cập nhật item
     */
    public function update(int $id, array $data): bool
    {
        return ExportItem::where('id', $id)->update($data);
    }

    /**
     * Xóa item theo id
     */
    public function delete(int $id): ?bool
    {
        return ExportItem::destroy($id);
    }

    /**
     * Xóa toàn bộ items theo export_id
     */
    public function deleteByExportId(int $exportId): int
    {
        return ExportItem::where('export_id', $exportId)->delete();
    }

    public function deleteMany(array $ids)
    {
        return ExportItem::whereIn('id', $ids)->delete();
    }
}
