<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreShopRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'products' => 'sometimes|array',
            'products.*.name' => 'required|string|max:255',
            'products.*.quantity' => 'required|string|max:255',
        ];
    }
}

