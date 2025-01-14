<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\WasteCategory;
use App\Models\WasteLocation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WasteReport>
 */
class WasteReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'user_id' => User::inRandomOrder()->value('id'),
            'location_id' => WasteLocation::inRandomOrder()->value('id'),
            'category_id' => WasteCategory::inRandomOrder()->value('id'),
            'estimated_weight' => $this->faker->numberBetween(1, 100),
            'description' => $this->faker->sentence(),
            'photo_path' => $this->faker->imageUrl(),
            'latitude' => $this->faker->latitude(-90, 90),
            'longitude' => $this->faker->longitude(-180, 180),
            'status' => $this->faker->randomElement(['pending', 'verified', 'resolved']),
            'verified_by' => User::inRandomOrder()->value('id'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
