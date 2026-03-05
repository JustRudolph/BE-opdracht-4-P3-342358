<?php

namespace Database\Factories;

use App\Models\Allergeen;
use Illuminate\Database\Eloquent\Factories\Factory;

class AllergeenFactory extends Factory
{
    protected $model = Allergeen::class;

    public function definition()
    {
        return [
            'Naam' => $this->faker->word(),
            'Omschrijving' => $this->faker->sentence(),
            'IsActief' => true,
            'Opmerking' => null,
        ];
    }
}
