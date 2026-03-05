<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Allergeen;
use App\Models\Contact;
use App\Models\Leverancier;
use App\Models\ProductPerAllergeen;
use App\Models\ProductPerLeverancier;
use App\Models\Magazijn;

class AllergenSeeder extends Seeder
{
    /**
     * Run the database seeds for User Story 01: Allergen Overview
     */
    public function run(): void
    {
        // 1. Create Allergeens
        $allergeens = [
            ['Naam' => 'Gluten', 'Omschrijving' => 'Dit product bevat gluten'],
            ['Naam' => 'Gelatine', 'Omschrijving' => 'Dit product bevat gelatine'],
            ['Naam' => 'AZO-Kleurstof', 'Omschrijving' => 'Dit product bevat AZO-kleurstoffen'],
            ['Naam' => 'Lactose', 'Omschrijving' => 'Dit product bevat lactose'],
            ['Naam' => 'Soja', 'Omschrijving' => 'Dit product bevat soja'],
        ];

        foreach ($allergeens as $allergen) {
            Allergeen::firstOrCreate($allergen);
        }

        // 2. Create Products
        $products = [
            ['Naam' => 'Mintnopjes', 'Barcode' => '8719587231278'],
            ['Naam' => 'Schoolkrijt', 'Barcode' => '8719587326713'],
            ['Naam' => 'Honingdrop', 'Barcode' => '8719587327836'],
            ['Naam' => 'Zure Beren', 'Barcode' => '8719587321441'],
            ['Naam' => 'Cola Flesjes', 'Barcode' => '8719587321237'],
            ['Naam' => 'Turtles', 'Barcode' => '8719587322245'],
            ['Naam' => 'Witte Muizen', 'Barcode' => '8719587328256'],
            ['Naam' => 'Reuzen Slangen', 'Barcode' => '8719587325641'],
            ['Naam' => 'Zoute Rijen', 'Barcode' => '8719587322739'],
            ['Naam' => 'Winegums', 'Barcode' => '8719587327527', 'IsActief' => false],
            ['Naam' => 'Drop Munten', 'Barcode' => '8719587322345'],
            ['Naam' => 'Kruis Drop', 'Barcode' => '8719587322265'],
            ['Naam' => 'Zoute Ruitjes', 'Barcode' => '8719587323256'],
            ['Naam' => "Drop Ninja's", 'Barcode' => '8719587323277'],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(['Barcode' => $product['Barcode']], $product);
        }

        // 3. Create Contacts
        $contacts = [
            ['Straat' => 'Van Gilslaan', 'Huisnummer' => 34, 'Postcode' => '1045CB', 'Stad' => 'Hilvarenbeek'],
            ['Straat' => 'Den Dolderpad', 'Huisnummer' => 2, 'Postcode' => '1067RC', 'Stad' => 'Utrecht'],
            ['Straat' => 'Fredo Raalteweg', 'Huisnummer' => 257, 'Postcode' => '1236OP', 'Stad' => 'Nijmegen'],
            ['Straat' => 'Bertrand Russellhof', 'Huisnummer' => 21, 'Postcode' => '2034AP', 'Stad' => 'Den Haag'],
            ['Straat' => 'Leon van Bonstraat', 'Huisnummer' => 213, 'Postcode' => '145XC', 'Stad' => 'Lunteren'],
            ['Straat' => 'Bea van Lingenlaan', 'Huisnummer' => 234, 'Postcode' => '2197FG', 'Stad' => 'Sint Pancras'],
        ];

        $createdContacts = [];
        foreach ($contacts as $index => $contact) {
            $createdContacts[$index] = Contact::firstOrCreate($contact);
        }

        // 4. Create Leveranciers
        $leveranciers = [
            [
                'Naam' => 'Venco',
                'ContactPersoon' => 'Bert van Linge',
                'LeverancierNummer' => 'L1029384719',
                'Mobiel' => '06-28493827',
                'ContactId' => $createdContacts[0]->id,
            ],
            [
                'Naam' => 'Astra Sweets',
                'ContactPersoon' => 'Jasper del Monte',
                'LeverancierNummer' => 'L1029284315',
                'Mobiel' => '06-39398734',
                'ContactId' => $createdContacts[1]->id,
            ],
            [
                'Naam' => 'Haribo',
                'ContactPersoon' => 'Sven Stalman',
                'LeverancierNummer' => 'L1029324748',
                'Mobiel' => '06-24383291',
                'ContactId' => $createdContacts[2]->id,
            ],
            [
                'Naam' => 'Basset',
                'ContactPersoon' => 'Joyce Stelterberg',
                'LeverancierNummer' => 'L1023845773',
                'Mobiel' => '06-48293823',
                'ContactId' => $createdContacts[3]->id,
            ],
            [
                'Naam' => 'De Bron',
                'ContactPersoon' => 'Remco Veenstra',
                'LeverancierNummer' => 'L1023857736',
                'Mobiel' => '06-34291234',
                'ContactId' => $createdContacts[4]->id,
            ],
            [
                'Naam' => 'Quality Street',
                'ContactPersoon' => 'Johan Nooij',
                'LeverancierNummer' => 'L1029234586',
                'Mobiel' => '06-23458456',
                'ContactId' => $createdContacts[5]->id,
            ],
            [
                'Naam' => 'Hom Ken Food',
                'ContactPersoon' => 'Hom Ken',
                'LeverancierNummer' => 'L1029234599',
                'Mobiel' => '06-23458477',
                'ContactId' => null, // Scenario 03: No address
            ],
        ];

        $createdLeveranciers = [];
        foreach ($leveranciers as $index => $leverancier) {
            $createdLeveranciers[$index] = Leverancier::firstOrCreate(
                ['LeverancierNummer' => $leverancier['LeverancierNummer']],
                $leverancier
            );
        }

        // 5. Create Magazijns
        $magazijns = [
            ['ProductId' => 1, 'VerpakkingsEenheid' => 5.00, 'AantalAanwezig' => 453],
            ['ProductId' => 2, 'VerpakkingsEenheid' => 2.50, 'AantalAanwezig' => 400],
            ['ProductId' => 3, 'VerpakkingsEenheid' => 5.00, 'AantalAanwezig' => 1],
            ['ProductId' => 4, 'VerpakkingsEenheid' => 1.00, 'AantalAanwezig' => 800],
            ['ProductId' => 5, 'VerpakkingsEenheid' => 3.00, 'AantalAanwezig' => 234],
            ['ProductId' => 6, 'VerpakkingsEenheid' => 2.00, 'AantalAanwezig' => 345],
            ['ProductId' => 7, 'VerpakkingsEenheid' => 1.00, 'AantalAanwezig' => 795],
            ['ProductId' => 8, 'VerpakkingsEenheid' => 10.00, 'AantalAanwezig' => 233],
            ['ProductId' => 9, 'VerpakkingsEenheid' => 2.50, 'AantalAanwezig' => 123],
            ['ProductId' => 10, 'VerpakkingsEenheid' => 3.00, 'AantalAanwezig' => null],
            ['ProductId' => 11, 'VerpakkingsEenheid' => 2.00, 'AantalAanwezig' => 367],
            ['ProductId' => 12, 'VerpakkingsEenheid' => 1.00, 'AantalAanwezig' => 467],
            ['ProductId' => 13, 'VerpakkingsEenheid' => 5.00, 'AantalAanwezig' => 20],
            ['ProductId' => 14, 'VerpakkingsEenheid' => 10.00, 'AantalAanwezig' => 150],
        ];

        foreach ($magazijns as $magazijn) {
            Magazijn::firstOrCreate(['ProductId' => $magazijn['ProductId']], $magazijn);
        }

        // 6. Create ProductPerAllergeens relationships
        $allergenRelations = [
            [1, 2], [1, 1], [1, 3], // Mintnopjes: Gelatine, Gluten, AZO
            [3, 4], // Honingdrop: Lactose
            [6, 5], // Turtles: Soja
            [9, 2], [9, 5], // Zoute Rijen: Gelatine, Soja
            [10, 2], // Winegums: Gelatine
            [12, 4], // Kruis Drop: Lactose
            [13, 1], [13, 4], [13, 5], // Zoute Ruitjes: Gluten, Lactose, Soja
            [14, 5], // Drop Ninja's: Soja
        ];

        foreach ($allergenRelations as [$productId, $allergenId]) {
            ProductPerAllergeen::firstOrCreate([
                'ProductId' => $productId,
                'AllergeenId' => $allergenId,
            ]);
        }

        // 7. Create ProductPerLeveranciers relationships
        $deliveries = [
            [1, 1, '2024-11-09', 23, '2024-11-16'],
            [1, 1, '2024-11-18', 21, '2024-11-25'],
            [1, 2, '2024-11-09', 12, '2024-11-16'],
            [1, 3, '2024-11-10', 11, '2024-11-17'],
            [2, 4, '2024-11-14', 16, '2024-11-21'],
            [2, 4, '2024-11-21', 23, '2024-11-28'],
            [2, 5, '2024-11-14', 45, '2024-11-21'],
            [2, 6, '2024-11-14', 30, '2024-11-21'],
            [3, 7, '2024-11-12', 12, '2024-11-19'],
            [3, 7, '2024-11-19', 23, '2024-11-26'],
            [3, 8, '2024-11-10', 12, '2024-11-17'],
            [3, 9, '2024-11-11', 1, '2024-11-18'],
            [4, 10, '2024-11-16', 24, '2024-11-30'],
            [5, 11, '2024-11-10', 47, '2024-11-17'],
            [5, 11, '2024-11-19', 60, '2024-11-26'],
            [5, 12, '2024-11-11', 45, null],
            [5, 13, '2024-11-12', 23, null],
            [7, 14, '2024-11-14', 20, null],
        ];

        foreach ($deliveries as [$leverancierId, $productId, $datumLevering, $aantal, $datumEerstVolgendeLevering]) {
            ProductPerLeverancier::firstOrCreate([
                'LeverancierId' => $leverancierId,
                'ProductId' => $productId,
                'DatumLevering' => $datumLevering,
            ], [
                'Aantal' => $aantal,
                'DatumEerstVolgendeLevering' => $datumEerstVolgendeLevering,
            ]);
        }

        $this->command->info('Allergen data seeded successfully!');
    }
}
