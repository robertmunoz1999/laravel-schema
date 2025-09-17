<?php

namespace Tests\Unit\Actions;

use App\Actions\StoreProductAction;
use Tests\TestCase;

class StoreProductActionTest extends TestCase
{
    public function test_handle_creates_shop()
    {
        $data = ['name' => 'Test Product'];

        $action = new StoreProductAction();
        $product = $action->handle($data);

        $this->assertEquals('Test Product', $product->name);
        $this->assertDatabaseHas('products', ['name' => 'Test Product']);
    }
}

