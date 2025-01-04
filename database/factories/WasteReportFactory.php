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

        $users = User::all();
        $locations = WasteLocation::all();
        $categories = WasteCategory::all();

        return [
            'id' => str()->uuid(),
            'user_id' => $users->random()->id,
            'location_id' => $locations->random()->id,
            'category_id' => $categories->random()->id,
            'quantity' => $this->faker->numberBetween(1, 100),
            'description' => $this->faker->text,
            'status' => $this->faker->randomElement(['pending', 'verified', 'resolved']),
        ];
    }
}
