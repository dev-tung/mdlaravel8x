<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $repo;

    public function __construct(ProductRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        return response()->json($this->repo->forOrder());
    }

    public function updateField(Request $request, $id)
    {
        $field = $request->input('field');
        $value = $request->input('value');
        $success = $this->repo->updateField($id, $field, $value);
        return response()->json(['success' => $success]);
    }
}
