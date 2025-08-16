<?php

namespace App\Repositories;

use App\Models\Taxonomy;

class TaxonomyRepository
{
    public function all()
    {
        return Taxonomy::all();
    }

    public function find($id)
    {
        return Taxonomy::findOrFail($id);
    }

    public function create(array $data)
    {
        return Taxonomy::create($data);
    }

    public function update($id, array $data)
    {
        $taxonomy = $this->find($id);
        $taxonomy->update($data);
        return $taxonomy;
    }

    public function delete($id)
    {
        return Taxonomy::destroy($id);
    }
}
