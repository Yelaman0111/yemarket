<?php

namespace Database\Seeders;

use App\Models\ProductCompany;
use Illuminate\Database\Seeder;

class ProductCompanySeeder extends Seeder
{
    public function run()
    {
        ProductCompany::factory()->count(5)->create();

    }
}
