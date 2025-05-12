<?php

namespace Database\Seeders;
use App\Models\Employee;
use App\Models\LeaveType;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
{
    Employee::factory()->count(10)->create();

LeaveType::factory()->count(5)->create();
    \App\Models\Employee::factory(10)->create();
    \App\Models\LeaveType::factory(3)->create();
    \App\Models\LeaveRequest::factory(20)->create();
}

}
