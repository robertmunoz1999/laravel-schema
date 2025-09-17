<?php

namespace App\Actions;

use App\Models\Shop;
use App\Models\Product;

class StoreProductAction
{
    public function handle(array $data): Product
    {
        return Product::create([
            'name' => $data['name'],
        ]);
    }
}
