<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Services\ProductService;

class UpdateProductSku extends Command
{
    protected $signature = 'products:update-sku';
    protected $description = 'Cập nhật lại SKU cho toàn bộ sản phẩm';

    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        parent::__construct();
        $this->productService = $productService;
    }

    public function handle()
    {
        $products = Product::with('taxonomy')->get();

        foreach ($products as $product) {
            $product->sku = $this->productService->generateSku(
                $product->taxonomy_id,
                $product->name
            );
            $product->save();
        }

        $this->info("Đã cập nhật lại SKU cho {$products->count()} sản phẩm.");
    }
}
