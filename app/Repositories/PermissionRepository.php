<?php

namespace App\Repositories;

use App\Models\Permission;

class PermissionRepository
{
    public function getAll()
    {
        return Permission::latest()->paginate(20);
    }

    public function find($id)
    {
        return Permission::findOrFail($id);
    }

    public function create(array $data)
    {
        return Permission::create($data);
    }

    public function update($id, array $data)
    {
        $permission = $this->find($id);
        $permission->update($data);
        return $permission;
    }

    public function delete($id)
    {
        $permission = $this->find($id);
        return $permission->delete();
    }
}
