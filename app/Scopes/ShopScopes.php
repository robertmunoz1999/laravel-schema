<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait ShopScopes
{
    public function scopeSearch(Builder $query, $data): Builder
    {
        if (!$data) return $query;

        return $query->where('shops.name', 'like', '%' . $data . '%');
    }
}
