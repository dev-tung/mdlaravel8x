<?php

namespace App\Repositories;

use App\Models\Point;

class PointRepository
{
    public function getAll()
    {
        return Point::with('customer')->latest()->paginate(20);
    }

    public function find($id)
    {
        return Point::findOrFail($id);
    }

    public function create(array $data)
    {
        return Point::create($data);
    }

    public function update($id, array $data)
    {
        $point = $this->find($id);
        $point->update($data);
        return $point;
    }

    public function delete($id)
    {
        $point = $this->find($id);
        return $point->delete();
    }
}
