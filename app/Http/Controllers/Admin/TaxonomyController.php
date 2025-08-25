<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\TaxonomyRepository;
use Illuminate\Http\Request;
use App\Http\Requests\TaxonomyRequest;

class TaxonomyController extends Controller
{
    protected $taxonomyRepository;

    public function __construct(TaxonomyRepository $taxonomyRepository)
    {
        $this->taxonomyRepository = $taxonomyRepository;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['name', 'type', 'status']);

        $perPage = request('per_page', config('shared.pagination_per_page'));
        $taxonomies = $this->taxonomyRepository->paginateWithFilters($filters, $perPage);

        return view('admin.taxonomies.index', [
            'taxonomies' => $taxonomies,
            'filters' => $filters,
            'types' => $this->taxonomyRepository->types()
        ]);
    }

    public function create()
    {
        $taxonomies = $this->taxonomyRepository->all();
        return view('admin.taxonomies.create', [
            'taxonomies' => $taxonomies,
            'types' => $this->taxonomyRepository->types()
        ]);
    }

    public function store(TaxonomyRequest $request)
    {
        $data = $request->validated();
        $taxonomy = $this->taxonomyRepository->create($data);
        return redirect()->route('admin.taxonomies.index')->with('success', 'Taxonomy tạo thành công!');
    }

    public function edit($id)
    {
        $taxonomy = $this->taxonomyRepository->find($id);
        $taxonomies = $this->taxonomyRepository->all();
        return view('admin.taxonomies.edit', [
            'taxonomy' => $taxonomy,
            'taxonomies' => $taxonomies,
            'types' => $this->taxonomyRepository->types()
        ]);
    }

    public function update(TaxonomyRequest $request, $id)
    {
        $data = $request->validated();
        $this->taxonomyRepository->update($id, $data);

        return redirect()->route('admin.taxonomies.index')->with('success', 'Taxonomy đã được cập nhật thành công.');
    }

    public function destroy($id)
    {
        $this->taxonomyRepository->delete($id);

        return redirect()->route('admin.taxonomies.index')->with('success', 'Xóa taxonomy thành công.');
    }
}
