<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\PermissionRepository;

class PermissionController extends Controller
{
    protected $permissions;

    public function __construct(PermissionRepository $permissions)
    {
        $this->permissions = $permissions;
    }

    public function index()
    {
        $permissions = $this->permissions->getAll();
        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name',
            'display_name' => 'nullable|string',
            'group' => 'nullable|string',
        ]);

        $this->permissions->create($request->all());

        return redirect()->route('admin.permissions.index')->with('success', 'Quyền mới đã được tạo.');
    }

    public function show($id)
    {
        $permission = $this->permissions->find($id);
        return view('admin.permissions.show', compact('permission'));
    }

    public function edit($id)
    {
        $permission = $this->permissions->find($id);
        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name,' . $id,
            'display_name' => 'nullable|string',
            'group' => 'nullable|string',
        ]);

        $this->permissions->update($id, $request->all());

        return redirect()->route('admin.permissions.index')->with('success', 'Cập nhật quyền thành công.');
    }

    public function destroy($id)
    {
        $this->permissions->delete($id);
        return redirect()->route('admin.permissions.index')->with('success', 'Xóa quyền thành công.');
    }
}
