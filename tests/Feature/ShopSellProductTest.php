<?php

namespace Tests\Feature;

use Tests\TestCase;
use Database\Factories\ShopFactory;
use Database\Factories\ProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShopSellProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_sell_product_with_more_than_one_quantity()
    {
        $shop = ShopFactory::new()->create();
        $product = ProductFactory::new()->create();

        $shop->products()->attach($product->id, ['quantity' => 5]);

        $response = $this->getJson("/api/shops/{$shop->id}/products/{$product->id}/sell");

        $response->assertStatus(200)
            ->assertJson([
                'message' => __('titles.product_sold_successfully'),
                'remaining' => 4,
            ]);

        $this->assertDatabaseHas('product_shop', [
            'shop_id' => $shop->id,
            'product_id' => $product->id,
            'quantity' => 4,
        ]);
    }

    public function test_can_sell_last_unit_of_product()
    {
        $shop = ShopFactory::new()->create();
        $product = ProductFactory::new()->create();

        $shop->products()->attach($product->id, ['quantity' => 1]);

        $response = $this->getJson("/api/shops/{$shop->id}/products/{$product->id}/sell");

        $response->assertStatus(200)
            ->assertJson([
                'message' => __('titles.product_sold_last_unit'),
                'remaining' => 0,
            ]);

        $this->assertDatabaseHas('product_shop', [
            'shop_id' => $shop->id,
            'product_id' => $product->id,
            'quantity' => 0,
        ]);
    }

    public function test_cannot_sell_product_out_of_stock()
    {
        $shop = ShopFactory::new()->create();
        $product = ProductFactory::new()->create();

        $shop->products()->attach($product->id, ['quantity' => 0]);

        $response = $this->getJson("/api/shops/{$shop->id}/products/{$product->id}/sell");

        $response->assertStatus(400)
            ->assertJson([
                'message' => __('titles.product_out_of_stock'),
            ]);

        $this->assertDatabaseHas('product_shop', [
            'shop_id' => $shop->id,
            'product_id' => $product->id,
            'quantity' => 0,
        ]);
    }
}
