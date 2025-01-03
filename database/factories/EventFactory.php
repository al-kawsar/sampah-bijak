<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => str()->uuid(),
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'date' => $this->faker->dateTime,
            'location' => $this->faker->address,
            'organizer_id' => User::inRandomOrder()->first()->id,
            'image' => $this->faker->imageUrl(),
            'max_participants' => $this->faker->numberBetween(10, 100),
        ];
    }
}
