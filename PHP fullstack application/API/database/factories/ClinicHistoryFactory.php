<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClinicHistory>
 */
class ClinicHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'birth_date'=>$this->faker->date(),
            'gender' => $this->faker->randomElement(['Male', 'Female', 'Non-binary', 'Other']),
            'phone' => $this->faker->numerify('+1 ###-###-####'),
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'email' => $this->faker->email,
            'medical_conditions' => $this->faker->sentence(15),
            'current_medications' => $this->faker->sentence(15),
            'allergies' => $this->faker->sentence(10),
            'personal_habits' => $this->faker->sentence(10),
            'frequency_visits' => $this->faker->sentence(10),
            'user_id' => $this->faker->unique()->numberBetween(1, 10)
        ];
    }
}
