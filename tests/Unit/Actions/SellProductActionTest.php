<?php

namespace Tests\Unit\Actions;

use App\Actions\SellProductAction;
use App\Models\Product;
use App\Models\Shop;
use Database\Factories\ProductFactory;
use Database\Factories\ShopFactory;
use Tests\TestCase;

class SellProductActionTest extends TestCase
{
    public function test_cannot_sell_product_when_out_of_stock()
    {
        $shop = ShopFactory::new()->create();
        $product = ProductFactory::new()->create();

        $shop->products()->attach($product->id, ['quantity' => 0]);

        $action = new SellProductAction();
        $result = $action->handle($shop, $product);

        $this->assertFalse($result['success']);
        $this->assertEquals(__('titles.product_out_of_stock'), $result['message']);
    }

    public function test_sell_last_unit_of_product()
    {
        $shop = ShopFactory::new()->create();
        $product = ProductFactory::new()->create();

        $shop->products()->attach($product->id, ['quantity' => 1]);

        $action = new SellProductAction();
        $result = $action->handle($shop, $product);

        $this->assertTrue($result['success']);
        $this->assertEquals(__('titles.product_sold_last_unit'), $result['message']);
        $this->assertEquals(0, $result['remaining']);
        $this->assertDatabaseHas('product_shop', [
            'shop_id' => $shop->id,
            'product_id' => $product->id,
            'quantity' => 0,
        ]);
    }

    public function test_sell_product_with_more_than_one_quantity()
    {
        $shop = ShopFactory::new()->create();
        $product = ProductFactory::new()->create();

        $shop->products()->attach($product->id, ['quantity' => 5]);

        $action = new SellProductAction();
        $result = $action->handle($shop, $product);

        $this->assertTrue($result['success']);
        $this->assertEquals(__('titles.product_sold_successfully'), $result['message']);
        $this->assertEquals(4, $result['remaining']);
        $this->assertDatabaseHas('product_shop', [
            'shop_id' => $shop->id,
            'product_id' => $product->id,
            'quantity' => 4,
        ]);
    }
}
