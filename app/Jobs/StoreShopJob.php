<?php

namespace App\Jobs;

use App\Actions\StoreShopAction;

class StoreShopJob extends QueueableJob
{
    public function __construct(
        private readonly array $data,
    ) {}

    public function handle(StoreShopAction $action): void
    {
        $action->handle($this->data);
    }
}
