<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'        => $this->faker->randomElement([
                'Grand Ballroom', 'Obsidian Suite', 'Crystal Hall',
                'Executive Lounge', 'Garden Terrace', 'Rooftop Deck',
                'Conference Room A', 'VIP Dining Room', 'The Noir Suite', 'Penthouse Hall'
            ]),
            'type'        => $this->faker->randomElement(['room', 'event']),
            'capacity'    => $this->faker->numberBetween(10, 500),
            'description' => $this->faker->sentence(10),
        ];
    }
}