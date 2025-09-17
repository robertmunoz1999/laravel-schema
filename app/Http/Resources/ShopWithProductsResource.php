<?php

namespace App\Http\Resources;

use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShopWithProductsResource extends JsonResource
{
    /** @var Shop */
    public $resource;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'products' => ProductResource::collection($this->whenLoaded('products')),
        ];
    }
}
