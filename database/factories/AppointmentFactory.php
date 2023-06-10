<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => $this->faker->randomElement($this->getClientIds()),
            'date' => $this->faker->date(),
            'time' => $this->faker->time(),
            'status' => $this->faker->randomElement(['SCHEDULED', 'CLOSED']),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'price' => $this->faker->numberBetween(1, 10000),
        ];
    }

    protected function getClientIds()
    {
        return DB::table('clients')->pluck('id')->toArray();
    }
}
