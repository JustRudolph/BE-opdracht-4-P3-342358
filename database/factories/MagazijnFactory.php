<?php

namespace Database\Factories;

use App\Models\Magazijn;
use Illuminate\Database\Eloquent\Factories\Factory;

class MagazijnFactory extends Factory
{
    protected $model = Magazijn::class;

    public function definition()
    {
        return [
            'ProductId' => null,
            'VerpakkingsEenheid' => $this->faker->randomFloat(2, 0.5, 10),
            'AantalAanwezig' => $this->faker->numberBetween(0, 1000),
            'IsActief' => true,
            'Opmerking' => null,
        ];
    }
}
