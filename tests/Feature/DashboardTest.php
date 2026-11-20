<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_is_available_to_admin_users_and_seeding_is_idempotent(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->seed(DatabaseSeeder::class);

        $this->actingAs(User::factory()->create(['role' => 'admin']));

        $this->get('/')->assertRedirect(route('dashboard'));

        $response = $this->get(route('dashboard'));

        $response->assertOk();

        $this->assertSame(
            18,
            Product::query()->where('product_code', 'like', 'DEMO-%')->count()
        );
    }

    public function test_seeder_assigns_admin_and_customer_roles_to_seeded_users(): void
    {
        User::factory()->create(['email' => 'test@example.com']);

        $this->seed(DatabaseSeeder::class);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'role' => 'admin',
        ]);
        $this->assertDatabaseHas('users', [
            'email' => 'customer@example.com',
            'role' => 'customer',
        ]);
    }

    public function test_dashboard_lists_the_five_lowest_stock_products_for_customers_and_admins(): void
    {
        $category = Category::create([
            'name' => 'Produk Uji',
            'status' => 'Aktif',
        ]);

        foreach ([5, 0, 2, 4, 1, 3, 6] as $index => $stock) {
            Product::create([
                'category_id' => $category->id,
                'product_code' => sprintf('RESTOCK-%02d', $index + 1),
                'name' => sprintf('Produk Uji %02d', $index + 1),
                'price' => 10000,
                'stock' => $stock,
            ]);
        }

        $lowestStockProduct = Product::query()
            ->where('product_code', 'RESTOCK-02')
            ->firstOrFail();

        $admin = User::factory()->create([
            'role' => 'admin',
            'name' => 'Admin Inventaris',
        ]);
        $adminResponse = $this->actingAs($admin)
            ->get(route('dashboard'));

        $adminResponse->assertOk()
            ->assertSeeText('Produk perlu restock')
            ->assertSee('alt="Admin Inventaris"', false)
            ->assertViewHas(
                'restockProducts',
                fn (EloquentCollection $products): bool => $products->pluck('product_code')->all() === [
                    'RESTOCK-02',
                    'RESTOCK-05',
                    'RESTOCK-03',
                    'RESTOCK-06',
                    'RESTOCK-04',
                ]
            )
            ->assertSee(route('products.edit', $lowestStockProduct));

        $customer = User::factory()->create([
            'role' => 'customer',
            'name' => 'Pengguna Katalog',
        ]);

        $this->actingAs($customer)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSeeText('Produk perlu restock')
            ->assertSee('alt="Pengguna Katalog"', false)
            ->assertDontSee(route('products.edit', $lowestStockProduct));
    }

    public function test_dashboard_shows_empty_states_without_products(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'customer']))
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSeeText('Katalog masih kosong.')
            ->assertSeeText('Grafik akan tampil setelah produk tersedia.');
    }

    public function test_dashboard_confirms_when_all_products_are_above_the_restock_threshold(): void
    {
        $category = Category::create([
            'name' => 'Stok Aman',
            'status' => 'Aktif',
        ]);

        Product::create([
            'category_id' => $category->id,
            'product_code' => 'STOCK-OK-01',
            'name' => 'Produk Stok Aman',
            'price' => 10000,
            'stock' => 6,
        ]);

        $this->actingAs(User::factory()->create(['role' => 'customer']))
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSeeText('Belum ada produk yang perlu ditambah.')
            ->assertSeeText('Semua produk memiliki stok lebih dari 5 unit.')
            ->assertViewHas('restockProducts', fn (EloquentCollection $products): bool => $products->isEmpty());
    }
}
