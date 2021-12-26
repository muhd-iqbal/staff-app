<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'customer_name'=>$this->faker->name(),
            'customer_phone'=>'0123456789',
            'date'=>$this->faker->dateTimeBetween('+1 day', '+1 month'),
            'method'=>$this->faker->randomElement(['walkin', 'online']),
            'location'=>$this->faker->randomElement(['gurun', 'guar']),
            'user_id'=>1,
            // 'remarks'=>$this->faker->sentence(),
        ];
    }
}
