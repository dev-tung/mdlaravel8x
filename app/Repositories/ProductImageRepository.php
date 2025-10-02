<?php

namespace App\Repositories;

use App\Models\ProductImage;

class ProductImageRepository
{
    protected $model;

    public function __construct(ProductImage $model)
    {
        $this->model = $model;
    }

    /**
     * Tạo 1 record
     */
    public function create(array $data)
    {
        return $this->model->create($data); // dùng fillable
    }

    /**
     * Tạo nhiều record cùng lúc
     */
    public function bulkCreate(array $data)
    {
        return $this->model->insert($data); // insert mảng associative, dùng fillable fields
    }

    /**
     * Xóa 1 record
     */
    public function delete(int $id)
    {
        return $this->model->find($id)->delete();
    }

    /**
     * Lấy danh sách ảnh theo variant hoặc product
     */
    public function getByVariant(int $variantId)
    {
        return $this->model->where('variant_id', $variantId)->get();
    }

    public function getByProduct(int $productId)
    {
        return $this->model->where('product_id', $productId)->get();
    }
}
