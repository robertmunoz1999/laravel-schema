<?php

namespace Tests\Feature;

use Tests\TestCase;
use Database\Factories\ShopFactory;

class ShopShowTest extends TestCase
{
    public function test_can_show_shop()
    {
        $shop = ShopFactory::new()->create(['name' => 'Unique Shop']);

        $response = $this->getJson("/api/shops/{$shop->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Unique Shop']);
    }
}
