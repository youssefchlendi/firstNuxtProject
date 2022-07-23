<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DemandeMateriel>
 */
class DemandeMaterielFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "message" => $this->faker->text,
            "date_demande" => $this->faker->dateTimeBetween('-1 years', 'now'),
            "date_fin_demande" => $this->faker->dateTimeBetween('-1 years', 'now'),
            "user_id" => User::all()->random()->id,
        ];
    }
}
