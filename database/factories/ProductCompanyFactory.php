<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Product;
use App\Models\ProductCompany;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductCompanyFactory extends Factory
{
    protected $model = ProductCompany::class;

    public function definition()
    {
        return [
            'company_id'=>  function () {
                return Company::factory()->create()->id;
            },
            'product_id'=> function () {
                return Product::factory()->create()->id;
            },
            'price'=> $this->faker->numberBetween(1000, 5000),
            'sku'=>$this->faker->word,
            'min_order_count'=>$this->faker->numberBetween(1, 5),
            'approved'=>1,
        ];
    }
}
