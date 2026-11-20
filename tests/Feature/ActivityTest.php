<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_view_recent_product_and_category_activity(): void
    {
        $category = Category::create([
            'name' => 'Kategori Aktivitas',
            'status' => 'Aktif',
        ]);
        $product = Product::create([
            'category_id' => $category->id,
            'product_code' => 'ACTIVITY-01',
            'name' => 'Produk Aktivitas',
            'price' => 10000,
            'stock' => 4,
        ]);

        $response = $this->actingAs(User::factory()->create(['role' => 'customer']))
            ->get(route('activity.index'));

        $response->assertOk()
            ->assertSeeText('Aktivitas katalog terbaru')
            ->assertSeeText('Produk Aktivitas')
            ->assertSeeText('Kategori Aktivitas')
            ->assertSee(route('products.index', ['q' => $product->product_code]))
            ->assertSee(route('products.index', ['category_id' => $category->id]));
    }

    public function test_activity_page_shows_an_empty_state_when_no_catalog_changes_exist(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'customer']))
            ->get(route('activity.index'))
            ->assertOk()
            ->assertSeeText('Belum ada aktivitas katalog');
    }

    public function test_guests_are_redirected_to_login_from_activity_page(): void
    {
        $this->get(route('activity.index'))
            ->assertRedirect(route('login'));
    }
}
