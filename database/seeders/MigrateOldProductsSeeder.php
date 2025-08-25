<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MigrateOldProductsSeeder extends Seeder
{
    public function run()
    {
        // Lấy tất cả sản phẩm cũ
        $oldProducts = DB::table('product')->get();

        // Lấy danh sách taxonomy mới, key = taxonomy_name, value = id
        $taxonomies = DB::table('taxonomies')->pluck('id', 'name')->toArray();

        foreach ($oldProducts as $oldProduct) {
            $oldType = DB::table('productype')
                ->where('productype_id', $oldProduct->productype_id)
                ->value('productype_name'); // Lấy tên loại cũ

            // Nếu taxonomy mới tồn tại tên trùng với loại cũ
            if ($oldType && isset($taxonomies[$oldType])) {
                DB::table('products')
                    ->where('name', $oldProduct->product_name)
                    ->update([
                        'taxonomy_id' => $taxonomies[$oldType]
                    ]);
            }
        }
    }
}
