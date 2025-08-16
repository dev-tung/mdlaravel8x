<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\RoleRepository;

class RoleController extends Controller
{
    protected $roleRepo;

    public function __construct(RoleRepository $roleRepo)
    {
        $this->roleRepo = $roleRepo;
    }

    public function index()
    {
        $roles = $this->roleRepo->paginate(10);
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles',
            'slug' => 'required|string|max:255|unique:roles',
        ]);

        $this->roleRepo->create($request->all());

        return redirect()->route('admin.roles.index')->with('success', 'Thêm role thành công');
    }

    public function edit($id)
    {
        $role = $this->roleRepo->find($id);
        return view('admin.roles.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $id,
            'slug' => 'required|string|max:255|unique:roles,slug,' . $id,
        ]);

        $this->roleRepo->update($id, $request->all());

        return redirect()->route('admin.roles.index')->with('success', 'Cập nhật role thành công');
    }

    public function destroy($id)
    {
        $this->roleRepo->delete($id);
        return redirect()->route('admin.roles.index')->with('success', 'Xóa role thành công');
    }
}
