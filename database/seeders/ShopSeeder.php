<?php

namespace Database\Seeders;

use Database\Factories\ShopFactory;
use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
    public function run(): void
    {
        ShopFactory::times(5)->create();
    }
}
