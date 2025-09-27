<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\SupplierRepository;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    protected $repository;

    public function __construct(SupplierRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return response()->json($this->repository->all());
    }

    public function updateField(Request $request, $id)
    {
        $field = $request->input('field');
        $value = $request->input('value');
        $success = $this->repository->updateField($id, $field, $value);
        return response()->json(['success' => $success]);
    }
}
