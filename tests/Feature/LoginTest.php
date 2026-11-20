<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_log_in_and_open_the_dashboard(): void
    {
        $user = User::factory()->create([
            'email' => 'gadget.user@example.com',
            'role' => 'admin',
        ]);

        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Daftar di sini');

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($user);
        $this->get(route('dashboard'))->assertOk();
        $this->get(route('login'))->assertRedirect(route('dashboard'));
    }

    public function test_customer_can_log_in_and_open_the_dashboard(): void
    {
        $user = User::factory()->create([
            'email' => 'gadget.customer@example.com',
            'role' => 'customer',
        ]);

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($user);
        $this->get(route('dashboard'))->assertOk();
        $this->get(route('products.index'))->assertOk();
    }

    public function test_customer_can_log_out_and_return_to_the_login_page(): void
    {
        $user = User::factory()->create(['role' => 'customer']);
        $this->actingAs($user);

        $this->get(route('products.index'))
            ->assertOk()
            ->assertSee('name="_token"', false);
        $this->post(route('logout'))->assertRedirect('/');

        $this->assertGuest();
        $this->get('/')->assertRedirect(route('login'));
        $this->get(route('login'))->assertOk();
    }

    public function test_authenticated_customers_are_redirected_from_login_to_dashboard(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);

        $this->actingAs($customer)
            ->get(route('login'))
            ->assertRedirect(route('dashboard'));
    }

    public function test_invalid_password_does_not_authenticate_the_user(): void
    {
        $user = User::factory()->create(['email' => 'gadget.user@example.com']);

        $this->from(route('login'))
            ->post(route('login'), [
                'email' => $user->email,
                'password' => 'incorrect-password',
            ])
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }
}
