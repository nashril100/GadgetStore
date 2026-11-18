<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::transaction(function (): void {
            User::firstOrCreate(
                ['email' => 'test@example.com'],
                ['name' => 'Test User', 'password' => 'password']
            );

            $products = [
                ['category' => 'Smartphone', 'code' => 'DEMO-001', 'name' => 'Galaxy A55 5G 128GB', 'brand' => 'Samsung', 'price' => 6499000, 'stock' => 12],
                ['category' => 'Smartphone', 'code' => 'DEMO-002', 'name' => 'iPhone 15 128GB', 'brand' => 'Apple', 'price' => 12999000, 'stock' => 4],
                ['category' => 'Smartphone', 'code' => 'DEMO-003', 'name' => 'Redmi Note 13 5G 256GB', 'brand' => 'Xiaomi', 'price' => 3299000, 'stock' => 28],
                ['category' => 'Laptop', 'code' => 'DEMO-004', 'name' => 'Vivobook 14 OLED', 'brand' => 'ASUS', 'price' => 11999000, 'stock' => 8],
                ['category' => 'Laptop', 'code' => 'DEMO-005', 'name' => 'IdeaPad Slim 3 14"', 'brand' => 'Lenovo', 'price' => 7499000, 'stock' => 18],
                ['category' => 'Laptop', 'code' => 'DEMO-006', 'name' => 'MacBook Air M2 13"', 'brand' => 'Apple', 'price' => 16499000, 'stock' => 3],
                ['category' => 'Tablet', 'code' => 'DEMO-007', 'name' => 'Galaxy Tab S9 FE 128GB', 'brand' => 'Samsung', 'price' => 6499000, 'stock' => 10],
                ['category' => 'Tablet', 'code' => 'DEMO-008', 'name' => 'iPad 10th Gen 64GB', 'brand' => 'Apple', 'price' => 7499000, 'stock' => 6],
                ['category' => 'Tablet', 'code' => 'DEMO-009', 'name' => 'Xiaomi Pad 6 128GB', 'brand' => 'Xiaomi', 'price' => 4999000, 'stock' => 24],
                ['category' => 'Audio', 'code' => 'DEMO-010', 'name' => 'WH-CH720N Wireless Headphones', 'brand' => 'Sony', 'price' => 1599000, 'stock' => 15],
                ['category' => 'Audio', 'code' => 'DEMO-011', 'name' => 'Tune 520BT Wireless Headphones', 'brand' => 'JBL', 'price' => 699000, 'stock' => 0],
                ['category' => 'Audio', 'code' => 'DEMO-012', 'name' => 'Soundcore R50i Earbuds', 'brand' => 'Anker', 'price' => 249000, 'stock' => 42],
                ['category' => 'Aksesoris', 'code' => 'DEMO-013', 'name' => '45W USB-C Fast Charger', 'brand' => 'Samsung', 'price' => 499000, 'stock' => 35],
                ['category' => 'Aksesoris', 'code' => 'DEMO-014', 'name' => 'USB-C to USB-C Cable 1m', 'brand' => 'Anker', 'price' => 149000, 'stock' => 50],
                ['category' => 'Aksesoris', 'code' => 'DEMO-015', 'name' => 'Silicone Case for iPhone 15', 'brand' => 'Apple', 'price' => 599000, 'stock' => 2],
                ['category' => 'Smartwatch', 'code' => 'DEMO-016', 'name' => 'Galaxy Watch6 44mm', 'brand' => 'Samsung', 'price' => 3299000, 'stock' => 7],
                ['category' => 'Smartwatch', 'code' => 'DEMO-017', 'name' => 'Apple Watch SE 40mm', 'brand' => 'Apple', 'price' => 3499000, 'stock' => 2],
                ['category' => 'Smartwatch', 'code' => 'DEMO-018', 'name' => 'Amazfit GTR 4', 'brand' => 'Amazfit', 'price' => 2499000, 'stock' => 11],
            ];

            foreach ($products as $productData) {
                $categoryName = $productData['category'];
                unset($productData['category']);

                $category = Category::firstOrCreate(
                    ['name' => $categoryName],
                    ['description' => 'Produk '.$categoryName, 'status' => 'Aktif']
                );

                Product::firstOrCreate(
                    ['product_code' => $productData['code']],
                    [
                        'category_id' => $category->id,
                        'product_code' => $productData['code'],
                        'name' => $productData['name'],
                        'brand' => $productData['brand'],
                        'price' => $productData['price'],
                        'stock' => $productData['stock'],
                        'description' => $productData['name'].' - produk contoh untuk demonstrasi inventaris.',
                    ]
                );
            }
        });
    }
}
