<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
                'category_id'=> $this->faker->numberBetween(11, 26),
                'name'=> $this->faker->name(),
                'description'=> $this->faker->text(50),
                'image'=>  '1686816858.jpg',
                'brand_id'=>1,
                'approved'=>1
        ];
    }
}
