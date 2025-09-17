<?php

namespace App\Jobs;

use App\Actions\StoreProductAction;

class StoreProductJob extends QueueableJob
{
    public function __construct(
        private readonly array $data,
    ) {}

    public function handle(StoreProductAction $action): void
    {
        $action->handle($this->data);
    }
}
