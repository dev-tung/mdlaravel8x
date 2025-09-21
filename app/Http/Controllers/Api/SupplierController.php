<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\SupplierRepository;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    protected $repo;

    public function __construct(SupplierRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        return response()->json($this->repo->all());
    }

    public function updateField(Request $request, $id)
    {
        $field = $request->input('field');
        $value = $request->input('value');
        $success = $this->repo->updateField($id, $field, $value);
        return response()->json(['success' => $success]);
    }
}
