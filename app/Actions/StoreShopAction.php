<?php

namespace App\Actions;

use App\Jobs\StoreProductJob;
use App\Models\Shop;

class StoreShopAction
{
    public function __construct(
        private readonly StoreProductAction $storeProductAction,
    ) {}

    public function handle(array $data): Shop
    {
        $shop = Shop::create([
            'name' => $data['name'],
        ]);

        if (!empty($data['products']) && is_array($data['products'])) {
            foreach ($data['products'] as $productData) {
                $product = $this->storeProductAction->handle($productData);

                $shop->products()->attach(
                    $product->id,
                    ['quantity' => $productData['quantity'] ?? 1],
                );
            }
        }

        return $shop;
    }
}
