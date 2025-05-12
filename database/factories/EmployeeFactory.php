<?php

namespace Database\Factories;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    protected $model = Employee::class;
    public function definition(): array
{
    return [
        'name' => $this->faker->name,
        // ضمان تفرد الرقم مع تضمين تاريخ ووقت أو معرّف فريد
        'employee_number' => 'EMP' . $this->faker->unique()->numerify('###') . now()->timestamp,
        'mobile_number' => $this->faker->phoneNumber,
        'address' => $this->faker->address,
        'notes' => $this->faker->optional()->sentence,
    ];
}

}
