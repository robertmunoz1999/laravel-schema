<?php

namespace App\Queries;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;

class ProductsQuery extends Query
{
    public static function filters(): array
    {
        return [
            AllowedFilter::scope('search'),
        ];
    }

    public function getQueryBuilder(): Builder
    {
        return Product::query()
            ->select('products.*')
            ->distinct('products.id');
    }

    protected function getDefaultSort(): string
    {
        return 'products.id';
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
