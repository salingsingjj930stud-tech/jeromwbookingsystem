<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'event_id'         => Event::inRandomOrder()->first()->id,
            'customer_name'    => $this->faker->name(),
            'booking_id'       => strtoupper($this->faker->unique()->lexify('????????')),
            'num_persons'      => $this->faker->numberBetween(1, 20),
            'booking_datetime' => $this->faker->dateTimeBetween('now', '+6 months'),  
            'file_name'        => 'sample_confirmation.pdf',
            'file_path'        => 'confirmations/sample_confirmation.pdf',
        ];
    }
}