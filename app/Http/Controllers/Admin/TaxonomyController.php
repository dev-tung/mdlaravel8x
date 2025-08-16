<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\TaxonomyRepository;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTaxonomyRequest;

class TaxonomyController extends Controller
{
    protected $taxonomyRepository;

    public function __construct(TaxonomyRepository $taxonomyRepository)
    {
        $this->taxonomyRepository = $taxonomyRepository;
    }

    public function index()
    {
        $taxonomies = $this->taxonomyRepository->all();
        return view('admin.taxonomies.index', compact('taxonomies'));
    }

    public function create()
    {
        $taxonomies = $this->taxonomyRepository->all();
        return view('admin.taxonomies.create', compact('taxonomies'));
    }

    public function store(StoreTaxonomyRequest $request)
    {
        $data = $request->validated();
        $taxonomy = $this->taxonomyRepository->create($data);
        return redirect()->route('admin.taxonomies.index')->with('success', 'Taxonomy tạo thành công!');
    }
}
