<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'icno' => $this->faker->numerify('############'),
            'phone' => $this->faker->numerify('############'),
            'bank_name' => 'cimb',
            'bank_acc' => $this->faker->bankAccountNumber(),
            'address' => $this->faker->address(),
            'department_id' => Department::factory(),
            'position_id' => Position::factory(),
            'qualification' => 'Diploma of Art',
            'birthday' => $this->faker->dateTimeBetween('-40 years', '-15 years'),
            'annual_leave' => 8,
            'leave_remaining' => $this->faker->randomDigitNot(9),
            'joined_at' => $this->faker->dateTimeBetween('-10 years'),
            'active' => $this->faker->boolean(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
