<?php

namespace Database\Factories;

use App\Models\Leverancier;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeverancierFactory extends Factory
{
    protected $model = Leverancier::class;

    public function definition()
    {
        return [
            'Naam' => $this->faker->company(),
            'ContactPersoon' => $this->faker->name(),
            'LeverancierNummer' => 'L' . $this->faker->numerify('##########'),
            'Mobiel' => $this->faker->numerify('06-########'),
            'ContactId' => null,
            'IsActief' => true,
            'Opmerking' => null,
        ];
    }
}
