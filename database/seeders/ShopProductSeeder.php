<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shop;
use App\Models\Product;

class ShopProductSeeder extends Seeder
{
    public function run(): void
    {
        $shops = Shop::all();
        $products = Product::all();

        $shops->each(function ($shop) use ($products) {
            $products->each(function ($product) use ($shop) {
                $shop->products()->attach($product->id, ['quantity' => rand(1, 100)]);
            });
        });
    }
}
