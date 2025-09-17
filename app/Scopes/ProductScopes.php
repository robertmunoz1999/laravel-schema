<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait ProductScopes
{
    public function scopeSearch(Builder $query, $data): Builder
    {
        if (!$data) return $query;

        return $query->where('products.name', 'like', '%' . $data . '%');
    }
}
