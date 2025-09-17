<?php

namespace App\Queries;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;

abstract class Query extends QueryBuilder
{
    abstract protected function getQueryBuilder(): Builder;

    public function __construct(Request $request)
    {
        parent::__construct($this->getQueryBuilder(), $request);

        $this->defaultSort($this->getDefaultSort())
            ->allowedSorts($this->getAllowedSorts())
            ->allowedFilters($this->getAllowedFilters())
            ->allowedIncludes($this->getAllowedIncludes())
            ->with($this->getRelationships());
    }

    public function getRecords(): Collection|LengthAwarePaginator
    {
        if (!$this->request->has('raw')) {
            return $this->paginate(config('pagination.max_items_per_page'));
        }

        return $this->get();
    }

    protected function getDefaultSort(): string
    {
        return 'created_at';
    }

    protected function getAllowedSorts(): array
    {
        return [];
    }

    protected function getAllowedFilters(): array
    {
        return [];
    }

    protected function getAllowedIncludes(): array
    {
        return [];
    }

    protected function getRelationships(): array
    {
        return [];
    }
}
