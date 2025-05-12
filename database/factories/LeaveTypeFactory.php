<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LeaveTypeFactory extends Factory
{
    
   public function definition(): array
{
    return [
        'name' => $this->faker->randomElement(['Sick Leave', 'Annual Leave', 'Emergency Leave']),
    ];
}

}
