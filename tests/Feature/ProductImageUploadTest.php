<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductImageUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_upload_and_view_a_product_image(): void
    {
        Storage::fake('public');
        $category = Category::create([
            'name' => 'Smartphone',
            'description' => 'Kategori untuk pengujian.',
            'status' => 'Aktif',
        ]);
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post(route('products.store'), [
            'category_id' => $category->id,
            'product_code' => 'IMAGE-001',
            'name' => 'Produk dengan gambar',
            'brand' => 'Contoh',
            'price' => 100000,
            'stock' => 3,
            'description' => 'Produk untuk menguji upload gambar.',
            'image' => UploadedFile::fake()->image('product.png'),
        ]);

        $response->assertRedirect(route('products.index'));

        $product = Product::query()->where('product_code', 'IMAGE-001')->firstOrFail();
        $this->assertNotNull($product->image);
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'image' => $product->image,
        ]);
        Storage::disk('public')->assertExists($product->image);

        $this->get(route('products.index'))
            ->assertOk()
            ->assertSee(asset('storage/'.$product->image), false);
    }

    public function test_admin_can_replace_a_product_image_without_losing_the_existing_file_first(): void
    {
        Storage::fake('public');
        $category = Category::create([
            'name' => 'Smartphone',
            'description' => 'Kategori untuk pengujian.',
            'status' => 'Aktif',
        ]);
        $oldImage = 'product_images/old-image.png';
        Storage::disk('public')->put($oldImage, 'old image');
        $product = Product::create([
            'category_id' => $category->id,
            'product_code' => 'IMAGE-002',
            'name' => 'Produk edit gambar',
            'brand' => 'Contoh',
            'price' => 100000,
            'stock' => 3,
            'image' => $oldImage,
        ]);
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->put(route('products.update', $product), [
            'category_id' => $category->id,
            'product_code' => $product->product_code,
            'name' => $product->name,
            'brand' => $product->brand,
            'price' => $product->price,
            'stock' => $product->stock,
            'description' => $product->description,
            'image' => UploadedFile::fake()->image('replacement.png'),
        ]);

        $response->assertRedirect(route('products.index'));

        $product->refresh();
        $this->assertNotSame($oldImage, $product->image);
        Storage::disk('public')->assertMissing($oldImage);
        Storage::disk('public')->assertExists($product->image);
    }
}
