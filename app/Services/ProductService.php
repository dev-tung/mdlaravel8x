<?php

namespace App\Services;

use App\Repositories\ProductRepository;

class ProductService
{
    protected $productRepo;

    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function getAll()
    {
        return $this->productRepo->all();
    }

    public function getById($id)
    {
        return $this->productRepo->find($id);
    }

    public function create(array $data)
    {
        return $this->productRepo->create($data);
    }

    public function update($id, array $data)
    {
        $product = $this->productRepo->find($id);
        return $this->productRepo->update($product, $data);
    }

    public function delete($id)
    {
        $product = $this->productRepo->find($id);
        return $this->productRepo->delete($product);
    }

    public function getProducts(array $filters = [], $perPage = 10)
    {
        return $this->productRepo->getAllWithFilter($filters, $perPage);
    }
}
