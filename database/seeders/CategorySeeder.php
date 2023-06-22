<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
                'id' => 1,
                'title'=> 'Алкоголь',
                'parent_id'=>0,
            ]);
        Category::create([
                'id' => 2,
                'title'=> 'Овощи и фрукты',
                'parent_id'=>0,
            ]);
        Category::create([
                'id' => 11,
                'title'=> 'Овощи',
                'parent_id'=>2,
            ]);
        Category::create([
                'id' => 12,
                'title'=> 'Фрукты',
                'parent_id'=>2,
            ]);
        Category::create([
                'id' => 3,
                'title'=> 'Напитки',
                'parent_id'=>0,
            ]); 
        Category::create([
                'id' => 13,
                'title'=> 'Натуральные',
                'parent_id'=>3,
            ]);
        Category::create([
                'id' => 14,
                'title'=> 'Газированные',
                'parent_id'=>3,
            ]);
        Category::create([
                'id' => 15,
                'title'=> 'Вода',
                'parent_id'=>3,
            ]);
        Category::create([
                'id' => 16,
                'title'=> 'Чай, кофе',
                'parent_id'=>3,
            ]);
        Category::create([
                'id' => 4,
                'title'=> 'Молоко, сыр, масло, яйца',
                'parent_id'=>0,
            ]);
        Category::create([
                'id' => 18,
                'title'=> 'Йогурт, творожные сырки',
                'parent_id'=>4,
            ]);
        Category::create([
                'id' => 19,
                'title'=> 'Сыры',
                'parent_id'=>4,
            ]);
        Category::create([
                'id' => 20,
                'title'=> 'Яйца',
                'parent_id'=>4,
            ]);
        Category::create([
                'id' => 5,
                'title'=> 'Мясо, птица',
                'parent_id'=>0,
            ]);
        Category::create([
                'id' => 21,
                'title'=> 'Мясо',
                'parent_id'=>5,
            ]);
        Category::create([
                'id' => 22,
                'title'=> 'Птица',
                'parent_id'=>5,
            ]);
        Category::create([
                'id' => 6,
                'title'=> 'Колбасы',
                'parent_id'=>0,
            ]);
        Category::create([
                'id' => 23,
                'title'=> 'Колбасы, деликатесы',
                'parent_id'=>6,
            ]);
        Category::create([
                'id' => 24,
                'title'=> 'Сосиски, сардельки',
                'parent_id'=>6,
            ]);
        Category::create([
                'id' => 7,
                'title'=> 'Полуфабрикаты',
                'parent_id'=>0,
            ]);
        Category::create([
                'id' => 25,
                'title'=> 'Пельмени, вареники, манты',
                'parent_id'=>7,
            ]);
        Category::create([
                'id' => 26,
                'title'=> 'Котлеты, тефтели',
                'parent_id'=>7,
            ]);
        Category::create([
                'id' => 27,
                'title'=> 'Самса, пирожки',
                'parent_id'=>7,
            ]);
        Category::create([
                'id' => 28,
                'title'=> 'Пицца',
                'parent_id'=>7,
            ]);
        Category::create([
                'id' => 29,
                'title'=> 'Тесто',
                'parent_id'=>7,
            ]);
        Category::create([
                'id' => 8,
                'title'=> 'Сладости',
                'parent_id'=>0,
            ]);
        Category::create([
                'id' => 30,
                'title'=> 'Мёд',
                'parent_id'=>8,
            ]);
        Category::create([
                'id' => 31,
                'title'=> 'Печенье, вафли, торты',
                'parent_id'=>8,
            ]);
        Category::create([
                'id' => 32,
                'title'=> 'Шоколад, паста',
                'parent_id'=>8,
            ]);
        Category::create([
                'id' => 33,
                'title'=> 'Конфеты',
                'parent_id'=>8,
            ]);
        Category::create([
                'id' => 9,
                'title'=> 'Крупы, консервы',
                'parent_id'=>0,
            ]);
        Category::create([
                'id' => 34,
                'title'=> 'Крупы',
                'parent_id'=>9,
            ]);
        Category::create([
                'id' => 35,
                'title'=> 'Консервы',
                'parent_id'=>9,
            ]);
        Category::create([
                'id' => 36,
                'title'=> 'Макароны',
                'parent_id'=>9,
            ]);
        Category::create([
                'id' => 37,
                'title'=> 'Соусы, уксусы',
                'parent_id'=>9,
            ]);
        Category::create([
                'id' => 38,
                'title'=> 'Продукты быстрого приготовления',
                'parent_id'=>9,
            ]);
        Category::create([
                'id' => 10,
                'title'=> 'Хозтовары',
                'parent_id'=>0,
            ]);
        Category::create([
                'id' => 39,
                'title'=> 'Средства для мытья посуды',
                'parent_id'=>10,
            ]);
        Category::create([
                'id' => 40,
                'title'=> 'Стирка и уход за бельём',
                'parent_id'=>10,
            ]);
    }
}
