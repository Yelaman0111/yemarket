<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Faker\Generator as Faker;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition()
    {
        return [
            'name'=> $this->faker->name,
            'email'=> $this->faker->unique()->email,
            'password'=> Hash::make('123456'),
            'phone'=>   $this->faker->phoneNumber(),
            'blocked'=>0,
            'image'=>'1',
            'min_order_sum'=>10000,
        ];
    }
}

