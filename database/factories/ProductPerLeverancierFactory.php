<?php

namespace Database\Factories;

use App\Models\ProductPerLeverancier;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductPerLeverancierFactory extends Factory
{
    protected $model = ProductPerLeverancier::class;

    public function definition()
    {
        return [
            'LeverancierId' => null,
            'ProductId' => null,
            'DatumLevering' => $this->faker->dateTime(),
            'Aantal' => $this->faker->numberBetween(1, 1000),
            'DatumEerstVolgendeLevering' => null,
            'IsActief' => true,
            'Opmerking' => null,
        ];
    }
}
