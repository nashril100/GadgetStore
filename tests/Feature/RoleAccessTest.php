<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_access_dashboard_and_product_list_only(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $this->actingAs($customer);

        $this->get('/')->assertRedirect(route('dashboard'));
        $this->get(route('dashboard'))
            ->assertOk()
            ->assertSeeText('Pengguna')
            ->assertSee(route('products.index'))
            ->assertDontSee(route('categories.index'))
            ->assertDontSee(route('products.create'))
            ->assertDontSee(route('categories.create'))
            ->assertSee(route('profile.edit'))
            ->assertSee(route('settings.index'))
            ->assertSee(route('activity.index'));
        $this->get(route('products.index'))
            ->assertOk()
            ->assertSee('Data Produk')
            ->assertDontSee('Tambah Produk')
            ->assertDontSee(route('products.create'))
            ->assertDontSee(route('categories.index'));
        $this->get(route('categories.index'))->assertForbidden();
        $this->get(route('products.create'))->assertForbidden();
        $this->post(route('products.store'))->assertForbidden();
        $this->get(route('profile.edit'))
            ->assertOk()
            ->assertSeeText('Informasi profil');
        $this->get(route('settings.index'))
            ->assertOk()
            ->assertSeeText('Pengaturan akun');
        $this->get(route('activity.index'))
            ->assertOk()
            ->assertSeeText('Aktivitas katalog terbaru');
    }

    public function test_admin_can_access_dashboard_and_management_pages(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $this->get('/')->assertRedirect(route('dashboard'));
        $this->get(route('dashboard'))
            ->assertOk()
            ->assertSeeText('Administrator')
            ->assertSee(route('products.index'))
            ->assertSee(route('categories.index'))
            ->assertSee(route('products.create'))
            ->assertSee(route('categories.create'))
            ->assertSee(route('profile.edit'))
            ->assertSee(route('settings.index'))
            ->assertSee(route('activity.index'));
        $this->get(route('products.index'))->assertOk();
        $this->get(route('products.create'))->assertOk();
        $this->get(route('categories.index'))->assertOk();
        $this->get(route('categories.create'))->assertOk();
        $this->get(route('profile.edit'))->assertOk();
        $this->get(route('settings.index'))->assertOk();
        $this->get(route('activity.index'))->assertOk();
    }
}
