<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Brand::create([
            'id' => 1,
            'name' => 'Coca-Cola',
        ]);
        Brand::create([
            'id' => 2,
            'name' => 'Fanta',
        ]);
        Brand::create([
            'id' => 3,
            'name' => 'Pepsi',
        ]);
        Brand::create([
            'id' => 4,
            'name' => 'Snikers',
        ]);
        Brand::create([
            'id' => 5,
            'name' => 'MasloDel',
        ]);
    }
}
