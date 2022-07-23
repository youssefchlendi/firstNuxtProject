<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Materiel>
 */
class MaterielFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "name"=>$this->faker->word,
            "description"=>$this->faker->sentence,
            "quantity"=>$this->faker->numberBetween(1,10),
            "responsable_id"=>User::get()->random()->id,
        ];
    }


}
