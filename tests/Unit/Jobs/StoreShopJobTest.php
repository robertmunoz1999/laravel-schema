<?php

namespace Tests\Unit\Jobs;

use App\Actions\StoreShopAction;
use App\Jobs\StoreShopJob;
use Mockery\MockInterface;
use Tests\TestCase;

class StoreShopJobTest extends TestCase
{
    public function test_handle_calls_action_with_data()
    {
        $data = ['name' => 'Job Shop'];

        $action = $this->mock(
            StoreShopAction::class,
            function (MockInterface $mock) use ($data) {
                $mock->expects('handle')
                    ->once()
                    ->withArgs(function ($givenData) use ($data) {
                        $this->assertSame($data, $givenData);
                        return true;
                    });
            }
        );

        $job = new StoreShopJob($data);
        $job->handle($action);
    }
}

