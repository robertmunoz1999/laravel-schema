<?php

namespace App\Actions;

use App\Models\Shop;
use App\Models\Product;

class SellProductAction
{
    public function handle(Shop $shop, Product $product): array
    {
        $pivot = $shop->products()->where('product_id', $product->id)->first()?->pivot;

        if (!$pivot || $pivot->quantity <= 0) {
            return [
                'success' => false,
                'message' => __('titles.product_out_of_stock'),
            ];
        }

        if ($pivot->quantity === 1) {
            $pivot->quantity = 0;
            $pivot->save();

            return [
                'success' => true,
                'message' => __('titles.product_sold_last_unit'),
                'remaining' => 0,
            ];
        }

        $actualQuantity = $pivot->quantity;
        $pivot->quantity -= 1;
        $pivot->save();

        return [
            'success' => true,
            'message' => __('titles.product_sold_successfully'),
            'remaining' => $actualQuantity - 1,
        ];
    }
}
