<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Corousel;

class CorouselSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Corousel::create([
            'id' => 1,
            'image' => 'https://yemarket/uploads/corousel/1.png',
        ]);
        Corousel::create([
            'id' => 2,
            'image' => 'https://yemarket/uploads/corousel/2.png',
        ]);
        Corousel::create([
            'id' => 3,
            'image' => 'https://yemarket/uploads/corousel/3.png',
        ]);
    }
}
