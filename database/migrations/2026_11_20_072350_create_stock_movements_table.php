<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('product_name', 150);
            $table->string('product_code', 50)->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('movement_type', 20);
            $table->integer('quantity');
            $table->unsignedInteger('stock_before');
            $table->unsignedInteger('stock_after');
            $table->string('reason');
            $table->string('reference_type')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->timestamps();

            $table->index('created_at');
            $table->index(['reference_type', 'reference_id']);
        });

        DB::table('products')
            ->where('stock', '>', 0)
            ->orderBy('id')
            ->chunkById(500, function ($products): void {
                $now = now();
                $movements = $products->map(static fn (object $product): array => [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_code' => $product->product_code,
                    'user_id' => null,
                    'movement_type' => 'opening',
                    'quantity' => $product->stock,
                    'stock_before' => 0,
                    'stock_after' => $product->stock,
                    'reason' => 'Saldo awal sebelum pencatatan mutasi stok',
                    'reference_type' => null,
                    'reference_id' => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ])->all();

                DB::table('stock_movements')->insert($movements);
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
