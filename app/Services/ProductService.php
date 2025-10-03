<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use App\Repositories\ProductImageRepository;
use App\Repositories\TaxonomyRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService
{
    protected ProductRepository $productRepository;
    protected TaxonomyRepository $taxonomyRepository;
    protected ImageService $imageService;
    protected ProductImageRepository $productImageRepository;

    public function __construct(
        ProductRepository $productRepository,
        TaxonomyRepository $taxonomyRepository,
        ImageService $imageService,
        ProductImageRepository $productImageRepository
    ) {
        $this->productRepository = $productRepository;
        $this->taxonomyRepository = $taxonomyRepository;
        $this->imageService = $imageService;
        $this->productImageRepository = $productImageRepository;
    }

    /**
     * Lấy danh sách sản phẩm với filter + paginate
     */
    public function paginateWithFilters(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->productRepository->query();

        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%'.$filters['name'].'%');
        }

        if (!empty($filters['taxonomy_id'])) {
            $query->where('taxonomy_id', $filters['taxonomy_id']);
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage)->appends($filters);
    }

    public function generateSku(?string $productName, ?string $size = null, ?string $color = null): string
    {
        // abbreviation từ tên sản phẩm, nếu null thì mặc định PRD
        $abbr = $productName
            ? strtoupper(collect(preg_split('/\s+/', trim($productName)))
                ->map(fn($w) => mb_substr(preg_replace('/[^A-Za-z0-9]/u', '', $w), 0, 1))
                ->implode(''))
            : 'PRD';

        // Size, nếu null thì gán SDEF
        $sku = $abbr . '-S' . strtoupper($size ?: 'DEF');

        // Color, nếu null thì gán CDEF
        $sku .= '-C' . strtoupper($color ?: 'DEF');

        // Thêm chuỗi random 3 ký tự
        $sku .= '-' . strtoupper(Str::random(6));

        return $sku;
    }

    public function create(array $data)
    {
        return DB::transaction(function() use ($data) {

            // tạo product chính
            $product = $this->productRepository->create($data);

            // lặp qua variants nếu có
            if (!empty($data['variants'])) {
                foreach ($data['variants'] as $variantData) {

                    // tạo variant qua quan hệ Eloquent và fillable fields
                    $variant = $product->variants()->create($variantData);

                    // upload ảnh base64 cho variant
                    if( !empty($variantData['upload_images']) ){
                        $filePaths = $this->imageService->uploadBase64($variantData['upload_images'], 'products');

                        $imagesToSave = [];
                        foreach ($filePaths as $index => $filePath) {
                            $imagesToSave[] = [
                                'product_id' => $product->id,
                                'product_variant_id' => $variant->id,
                                'file_path'  => $filePath,
                                'is_default' => $index === 0 ? 1 : 0,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ];
                        }

                        // lưu record vào product_images
                        if (!empty($imagesToSave)) {
                            $this->productImageRepository->bulkCreate($imagesToSave);
                        }
                    }
                    

                }
            }

            // lưu ảnh cho product chung nếu có
            if (!empty($data['product_images'])) {

                $imagesToSave = [];

                foreach ($data['product_images'] as $index => $uploadedFile) {
                    // upload file trực tiếp
                    $filePath = $this->imageService->upload($uploadedFile, 'products');

                    $imagesToSave[] = [
                        'product_id' => $product->id,
                        'product_variant_id' => null, // ảnh chung của product
                        'file_path'  => $filePath,
                        'is_default' => $index === 0 ? 1 : 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                if (!empty($imagesToSave)) {
                    $this->productImageRepository->bulkCreate($imagesToSave);
                }
            }



        });
    }

    public function delete(int $productId)
    {
        return DB::transaction(function() use ($productId) {

            // Lấy product
            $product = $this->productRepository->find($productId);

            // Xóa ảnh product chung
            $productImages = $this->productImageRepository->getByProduct($productId)
                ->whereNull('product_variant_id');
            foreach ($productImages as $image) {
                $this->imageService->delete($image->file_path);
                $image->delete();
            }

            // Xóa variants và ảnh của variants
            foreach ($product->variants as $variant) {
                // Xóa ảnh variant
                $variantImages = $this->productImageRepository->getByVariant($variant->id);
                foreach ($variantImages as $image) {
                    $this->imageService->delete($image->file_path);
                    $image->delete();
                }

                // Xóa variant
                $variant->delete();
            }

            // Xóa product
            $product->delete();

            return true;
        });
    }

    public function productImgURL($product){
        $imgURL = $product->images()->where('is_default', 1)->first();
        if (!$imgURL) {
            $imgURL = $product->images()->first();
        }
        return $imgURL;
    }

}
