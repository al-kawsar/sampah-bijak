<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PickupSchedule>
 */
class PickupScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'pickup_date' => $this->faker->date,
            'pickup_time' => $this->faker->time,
            'notes' => $this->faker->sentence,
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'completed', 'cancelled']),
        ];
    }
}
