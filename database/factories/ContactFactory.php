<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    protected $model = Contact::class;

    public function definition()
    {
        return [
            'Straat' => $this->faker->streetName(),
            'Huisnummer' => $this->faker->numberBetween(1, 999),
            'Postcode' => $this->faker->postcode(),
            'Stad' => $this->faker->city(),
            'IsActief' => true,
            'Opmerking' => null,
        ];
    }
}
