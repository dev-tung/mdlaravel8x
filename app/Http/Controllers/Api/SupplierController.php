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
        $success = $this->repository->updateField($id, $request->input('field'), $request->input('value'));
        return response()->json(['success' => $success]);
    }
}
