<?php

namespace Tests\Unit\Actions;

use App\Actions\StoreShopAction;
use App\Actions\StoreProductAction;
use App\Models\Product;
use App\Models\Shop;
use Mockery\MockInterface;
use Tests\TestCase;

class StoreShopActionTest extends TestCase
{
    public function test_handle_creates_shop_without_products()
    {
        $data = ['name' => 'Test Shop'];

        $action = $this->mock(StoreShopAction::class, function (MockInterface $mock) use ($data) {
            $mock->expects('handle')
                ->once()
                ->withArgs(function ($givenData) use ($data) {
                    $this->assertSame($data, $givenData);
                    return true;
                })
                ->andReturn(new Shop($data));
        });

        $shop = $action->handle($data);

        $this->assertInstanceOf(Shop::class, $shop);
        $this->assertEquals('Test Shop', $shop->name);
    }

    public function test_handle_creates_shop_with_products()
    {
        $data = [
            'name' => 'Shop With Products',
            'products' => [
                ['name' => 'Product 1', 'quantity' => 5],
                ['name' => 'Product 2', 'quantity' => 2],
            ],
        ];

        $storeProductActionMock = $this->mock(StoreProductAction::class, function (MockInterface $mock) {
            $mock->expects('handle')
                ->twice()
                ->andReturnUsing(function ($productData) {
                    return Product::factory()->create(['name' => $productData['name']]);
                });
        });

        $action = new StoreShopAction($storeProductActionMock);
        $shop = $action->handle($data);

        $this->assertDatabaseHas('shops', ['name' => 'Shop With Products']);
        $this->assertCount(2, $shop->products);

        foreach ($data['products'] as $productData) {
            $this->assertDatabaseHas('products', ['name' => $productData['name']]);
            $this->assertDatabaseHas('product_shop', [
                'shop_id' => $shop->id,
                'quantity' => $productData['quantity'],
            ]);
        }
    }
}
