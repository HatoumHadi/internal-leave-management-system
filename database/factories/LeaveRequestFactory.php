<?php

namespace Database\Factories;

use App\Models\LeaveType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LeaveRequest>
 */
class LeaveRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'leave_type_id' => LeaveType::firstOrCreate(['name' => 'Sick Leave'])->id,
            'start_date' => now(),
            'end_date' => now()->addDays(2),
            'reason' => $this->faker->sentence,
            'status' => 'pending',
        ];
    }
}
