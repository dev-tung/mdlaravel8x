<?php

namespace App\Repositories;

use App\Models\ImportItem;
use Illuminate\Database\Eloquent\Collection;

class ImportItemRepository
{
    /**
     * Lấy tất cả item theo import_id
     */
    public function getByImportId(int $importId): Collection
    {
        return ImportItem::with('product')
            ->where('import_id', $importId)
            ->get();
    }

    /**
     * Tìm 1 item theo id
     */
    public function find(int $id): ImportItem
    {
        return ImportItem::with('product')->findOrFail($id);
    }

    /**
     * Tạo mới item
     */
    public function create(array $data): ImportItem
    {
        dd($data);
        return ImportItem::create($data);
    }

    /**
     * Tạo nhiều items một lúc
     */
    public function createMany(array $items): void
    {
        ImportItem::insert($items);
    }

    /**
     * Cập nhật item
     */
    public function update(ImportItem $item, array $data): bool
    {
        return $item->update($data);
    }

    /**
     * Xóa item theo id
     */
    public function delete(int $id): ?bool
    {
        return ImportItem::destroy($id);
    }

    /**
     * Xóa toàn bộ items theo import_id
     */
    public function deleteByImportId(int $importId): int
    {
        return ImportItem::where('import_id', $importId)->delete();
    }
}
