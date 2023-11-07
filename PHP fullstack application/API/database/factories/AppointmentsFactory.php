<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointments>
 */
class AppointmentsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'phone' => $this->faker->numerify('+1 ###-###-####'),
            'howdiduhearaboutus' => $this->faker->sentence(15),
            'date'=>$this->faker->date(),
            'time'=>$this->faker->time(),
            'specialist' => $this->faker->randomElement(['Hygiene & Prevention', 'Dental Crowns', 'Dental Bridges', 'Dental Fillings', 'Root Canal', 'Oral Surgery', 'Implants']),
            'comment'=>$this->faker->paragraph(1),
            'user_id'=>$this->faker->numberBetween(1,10),
        ];
    }
}