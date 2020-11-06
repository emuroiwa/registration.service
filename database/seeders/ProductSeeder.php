<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filePath = storage_path("fixtures/products.csv");
        foreach (array_slice(glob($filePath), 0, 2) as $file) {
            $data = array_map('str_getcsv', file($file));

            foreach ($data as $row) {
                $user = Product::create([
                        'sku' => $row[0],
                        'name' => $row[1],
                    ]);
            }
        }
    }
}
