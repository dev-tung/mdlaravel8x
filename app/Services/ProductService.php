<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use App\Services\ImageService;
use App\Models\Product;

class ProductService
{
    protected ProductRepository $productRepository;
    protected ImageService $imageService;

    public function __construct(
        ProductRepository $productRepository,
        ImageService $imageService
    ) {
        $this->productRepository = $productRepository;
        $this->imageService = $imageService;
    }

    public function create(array $data): Product
    {
        if (isset($data['thumbnail'])) {
            $data['thumbnail'] = $this->imageService->upload($data['thumbnail'], 'products');
        }

        return $this->productRepository->create($data);
    }

    public function update(int $id, array $data): Product
    {
        $product = $this->productRepository->find($id);

        if (isset($data['thumbnail'])) {
            $this->imageService->delete($product->thumbnail ?? null);
            $data['thumbnail'] = $this->imageService->upload($data['thumbnail'], 'products');
        }

        return $this->productRepository->update($id, $data);
    }

    public function delete(int $id): ?bool
    {
        $product = $this->productRepository->find($id);
        $this->imageService->delete($product->thumbnail ?? null);

        return $this->productRepository->delete($id);
    }

}
