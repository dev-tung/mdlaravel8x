<?php

namespace App\Repositories;

use App\Models\Item;

class ItemRepository
{
    /**
     * Lấy tất cả Item, có thể eager load quan hệ nếu muốn
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return Item::with(['order', 'product'])->orderBy('created_at', 'desc')->get();
    }

    /**
     * Tìm Item theo ID
     *
     * @param int $id
     * @return Item
     */
    public function find(int $id): Item
    {
        return Item::findOrFail($id);
    }

    /**
     * Tạo Item mới
     *
     * @param array $data
     * @return Item
     */
    public function create(array $data): Item
    {
        return Item::create($data);
    }

    /**
     * Cập nhật Item theo ID
     *
     * @param int $id
     * @param array $data
     * @return Item
     */
    public function update(int $id, array $data): Item
    {
        $Item = $this->find($id);
        $Item->update($data);
        return $Item;
    }

    /**
     * Xóa Item theo ID
     *
     * @param int $id
     * @return bool|null
     */
    public function delete(int $id): ?bool
    {
        return Item::destroy($id);
    }

    /**
     * Trả về trạng thái quà tặng hoặc không
     *
     * @return array
     */
    public function giftStatuses(): array
    {
        return [
            0 => 'Không phải quà tặng',
            1 => 'Là quà tặng'
        ];
    }

    public function deleteByOrderId(int $orderId): int
    {
        return Item::where('order_id', $orderId)->delete();
    }

    
}
