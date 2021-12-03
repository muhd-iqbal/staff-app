<?php

namespace Database\Factories;

use App\Models\LeaveType;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeaveFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'leave_type_id' => 1,
            'detail' => $this->faker->catchPhrase(),
            'start' => date('Y-m-d'),
            'return' => date('Y-m-d', time() + 86400),
            'day' => 1,
            'time' => 'full',
            'hr_approval' => 0,
            'approved' => 0,
        ];
    }
}
