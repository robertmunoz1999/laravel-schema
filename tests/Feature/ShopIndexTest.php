<?php

namespace Tests\Feature;

use Tests\TestCase;
use Database\Factories\ShopFactory;

class ShopIndexTest extends TestCase
{
    public function test_can_list_shops()
    {
        ShopFactory::new()->create(['name' => 'Shop 1']);
        ShopFactory::new()->create(['name' => 'Shop 2']);

        $response = $this->getJson('/api/shops');

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Shop 1'])
            ->assertJsonFragment(['name' => 'Shop 2']);
    }
}
