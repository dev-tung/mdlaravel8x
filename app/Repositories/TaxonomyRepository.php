<?php

namespace App\Repositories;

use App\Models\Taxonomy;
use Illuminate\Pagination\LengthAwarePaginator;

class TaxonomyRepository
{
    public function paginateWithFilters(array $filters = [], $perPage = 15)
    {
        $query = Taxonomy::query();

        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%'.$filters['name'].'%');
        }

        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('status', $filters['status']);
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage)->appends($filters);
    }

    /**
     * Lấy tất cả taxonomy (không phân trang)
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return Taxonomy::orderBy('created_at', 'desc')->get();
    }

    /**
     * Tìm taxonomy theo ID
     *
     * @param int $id
     * @return Taxonomy
     */
    public function find(int $id): Taxonomy
    {
        return Taxonomy::findOrFail($id);
    }

    /**
     * Tạo taxonomy mới
     *
     * @param array $data
     * @return Taxonomy
     */
    public function create(array $data): Taxonomy
    {
        return Taxonomy::create($data);
    }

    /**
     * Cập nhật taxonomy
     *
     * @param int $id
     * @param array $data
     * @return Taxonomy
     */
    public function update(int $id, array $data): Taxonomy
    {
        $taxonomy = $this->find($id);
        $taxonomy->update($data);
        return $taxonomy;
    }

    /**
     * Xóa taxonomy
     *
     * @param int $id
     * @return bool|null
     */
    public function delete(int $id): ?bool
    {
        return Taxonomy::destroy($id);
    }

    /**
     * Lấy danh sách type có thể dùng để hiển thị trong form
     *
     * @return array
     */
    public function types(): array
    {
        // Lấy từ config: config/taxonomy.php -> 'types'
        return config('taxonomy.types', [
            'product' => 'Sản phẩm',
            'expense' => 'Chi phí',
            'post' => 'Bài viết',
        ]);
    }
}
