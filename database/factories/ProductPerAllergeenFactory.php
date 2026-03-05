<?php

namespace Database\Factories;

use App\Models\ProductPerAllergeen;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductPerAllergeenFactory extends Factory
{
    protected $model = ProductPerAllergeen::class;

    public function definition()
    {
        return [
            'ProductId' => null,
            'AllergeenId' => null,
            'IsActief' => true,
            'Opmerking' => null,
        ];
    }
}
