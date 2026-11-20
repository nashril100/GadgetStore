<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;

class ActivityController extends Controller
{
    public function index(): View
    {
        $productActivities = Product::query()
            ->select(['id', 'name', 'product_code', 'created_at', 'updated_at'])
            ->whereNotNull('updated_at')
            ->latest('updated_at')
            ->limit(10)
            ->get()
            ->map(static function (Product $product): array {
                $updatedAt = $product->updated_at;

                return [
                    'action' => $product->created_at?->equalTo($updatedAt) ? 'Produk ditambahkan' : 'Produk diperbarui',
                    'name' => $product->name,
                    'detail' => 'Kode produk: '.$product->product_code,
                    'occurred_at' => $updatedAt,
                    'url' => route('products.index', ['q' => $product->product_code]),
                    'icon' => 'fa-mobile-alt',
                    'color' => 'bg-primary',
                ];
            });

        $categoryActivities = Category::query()
            ->select(['id', 'name', 'created_at', 'updated_at'])
            ->whereNotNull('updated_at')
            ->latest('updated_at')
            ->limit(10)
            ->get()
            ->map(static function (Category $category): array {
                $updatedAt = $category->updated_at;

                return [
                    'action' => $category->created_at?->equalTo($updatedAt) ? 'Kategori ditambahkan' : 'Kategori diperbarui',
                    'name' => $category->name,
                    'detail' => 'Data kategori',
                    'occurred_at' => $updatedAt,
                    'url' => route('products.index', ['category_id' => $category->id]),
                    'icon' => 'fa-tags',
                    'color' => 'bg-info',
                ];
            });

        $activities = array_merge($productActivities->all(), $categoryActivities->all());

        usort(
            $activities,
            static fn (array $left, array $right): int => $right['occurred_at']->getTimestamp()
                <=> $left['occurred_at']->getTimestamp()
        );

        return view('activity.index', [
            'activities' => array_slice($activities, 0, 15),
        ]);
    }
}
