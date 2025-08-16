<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use DB;
use App\Models\ProductNew;

class MigrateOldProductsSeeder extends Seeder
{
    public function run()
    {
        // Lấy dữ liệu từ bảng cũ
        $oldProducts = DB::table('product')->get();

        foreach ($oldProducts as $old) {
            DB::table('products')->insert([
                'taxonomy_id' => $old->productype_id, // map cột category_id sang taxonomy_id
                'name' => $old->product_name,            // map tên cột
                'slug' => Str::slug($old->product_name),
                'sku' => $old->product_id,
                'price' => $old->product_price_output,
                'sale_price' => $old->product_price_output,
                'stock' => $old->product_quantity,
                'description' => $old->product_description,
                'status' => 'active', // map trạng thái
            ]);
        }
    }
}
