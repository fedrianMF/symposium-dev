<?php

namespace Database\Factories;

use App\Models\Conference;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Conference>
 */
class ConferenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startsAt = now()->toImmutable()->addMonths(6)->startOfDay();
        $cfpStartsAt = $startsAt->subMonths(4);

        return [
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'url' => fake()->url(),
            'location' => fake()->city(),
            'starts_at' => $startsAt,
            'ends_at' => $startsAt->addDays(3),
            'cfp_starts_at' => $cfpStartsAt,
            'cfp_ends_at' => $cfpStartsAt->addMonths(2),
        ];
    }
}
