<?php

namespace Tests\Feature;

use Tests\TestCase;

class ShopStoreTest extends TestCase
{
    public function test_store_shop()
    {
        $response = $this->postJson('/api/shops', [
            'name' => 'Store Shop',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'message',
            ]);

        $this->assertDatabaseHas('shops', [
            'name' => 'Store Shop',
        ]);
    }

    public function test_store_shop_with_invalid_fields_type()
    {
        $response = $this->postJson('/api/shops', [
            'name' => 12345,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    public function test_store_shop_with_wrong_keys()
    {
        $response = $this->postJson('/api/shops', [
            'title' => 'Invalid Key',
            'description' => 'Some description',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }
}
