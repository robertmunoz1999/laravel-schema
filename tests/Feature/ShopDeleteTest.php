<?php

namespace Tests\Feature;

use Database\Factories\ShopFactory;
use Tests\TestCase;

class ShopDeleteTest extends TestCase
{
    public function test_delete_shop_softdelete()
    {
        $shop = ShopFactory::new()->create();

        $response = $this->deleteJson("/api/shops/{$shop->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
            ]);

        $this->assertSoftDeleted('shops', [
            'id' => $shop->id,
        ]);
    }
}
