<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'Naam' => $this->faker->word(),
            'Barcode' => $this->faker->ean13(),
            'IsActief' => true,
            'Opmerking' => null,
        ];
    }
}
