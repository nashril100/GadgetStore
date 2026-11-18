<?php

namespace Tests\Feature;

use App\Models\Product;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_shows_charts_and_seeded_products_without_duplicate_seed_data(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->seed(DatabaseSeeder::class);

        $response = $this->get(route('dashboard'));

        $response->assertOk()
            ->assertSee('categoryChart')
            ->assertSee('stockChart')
            ->assertSee('stockByCategoryChart')
            ->assertSee('Galaxy A55 5G 128GB')
            ->assertDontSee('cdn.jsdelivr.net/npm/chart.js');

        $this->assertSame(
            18,
            Product::query()->where('product_code', 'like', 'DEMO-%')->count()
        );
    }
}
