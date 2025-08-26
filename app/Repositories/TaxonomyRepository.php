<?php

namespace App\Repositories;

use App\Models\Taxonomy;
use Illuminate\Pagination\LengthAwarePaginator;

class TaxonomyRepository
{
    public function types(): array
    {
        return [
            'product'   => 'Sản phẩm',
            'expense'   => 'Chi phí',
            'post'      => 'Bài viết',
            'customer'  => 'Khách hàng'
        ];
    }

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

    public function all()
    {
        return Taxonomy::orderBy('created_at', 'desc')->get();
    }

    public function find(int $id): Taxonomy
    {
        return Taxonomy::findOrFail($id);
    }

    public function create(array $data): Taxonomy
    {
        return Taxonomy::create($data);
    }

    public function update(int $id, array $data): Taxonomy
    {
        $taxonomy = $this->find($id);
        $taxonomy->update($data);
        return $taxonomy;
    }

    public function delete(int $id): ?bool
    {
        return Taxonomy::destroy($id);
    }

    public function getByType(string $type)
    {
        return Taxonomy::where('type', $type)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function homePage()
    {
        return Taxonomy::where('home_show', 'active')
            ->withCount('products')
            ->having('products_count', '>', 3)
            ->orderBy('home_order', 'asc')
            ->get();
    }

    public function findBySlug(string $slug): ?Taxonomy
    {
        return Taxonomy::where('slug', $slug)->first();
    }
}
