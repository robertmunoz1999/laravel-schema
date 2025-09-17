<?php

namespace App\Queries;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;

class ShopsQuery extends Query
{
    public static function filters(): array
    {
        return [
            AllowedFilter::scope('search'),
        ];
    }

    public function getQueryBuilder(): Builder
    {
        return Shop::query();
    }

    protected function getDefaultSort(): string
    {
        return 'shops.id';
    }

    protected function getAllowedFilters(): array
    {
        return self::filters();
    }

    protected function getAllowedSorts(): array
    {
        return [
            'name',
        ];
    }

    protected function getAllowedIncludes(): array
    {
        return [];
    }
}
