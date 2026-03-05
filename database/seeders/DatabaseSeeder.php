<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Leverancier;
use App\Models\Product;
use App\Models\Magazijn;
use App\Models\Allergeen;
use App\Models\ProductPerAllergeen;
use App\Models\ProductPerLeverancier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Contacts
        $contacts = [
            ['Straat' => 'Van Gilslaan', 'Huisnummer' => 34, 'Postcode' => '1045CB', 'Stad' => 'Hilvarenbeek'],
            ['Straat' => 'Den Dolderpad', 'Huisnummer' => 2, 'Postcode' => '1067RC', 'Stad' => 'Utrecht'],
            ['Straat' => 'Fredo Raalteweg', 'Huisnummer' => 257, 'Postcode' => '1236OP', 'Stad' => 'Nijmegen'],
            ['Straat' => 'Bertrand Russellhof', 'Huisnummer' => 21, 'Postcode' => '2034AP', 'Stad' => 'Den Haag'],
            ['Straat' => 'Leon van Bonstraat', 'Huisnummer' => 213, 'Postcode' => '145XC', 'Stad' => 'Lunteren'],
            ['Straat' => 'Bea van Lingenlaan', 'Huisnummer' => 234, 'Postcode' => '2197FG', 'Stad' => 'Sint Pancras'],
        ];

        foreach ($contacts as $c) {
            DB::table('contacts')->insert($c);
        }

        // Seed Leveranciers with ContactId
        $leveranciers = [
            ['Naam' => 'Venco', 'ContactPersoon' => 'Bert van Linge', 'LeverancierNummer' => 'L1029384719', 'Mobiel' => '06-28493827', 'ContactId' => 1],
            ['Naam' => 'Astra Sweets', 'ContactPersoon' => 'Jasper del Monte', 'LeverancierNummer' => 'L1029284315', 'Mobiel' => '06-39398734', 'ContactId' => 2],
            ['Naam' => 'Haribo', 'ContactPersoon' => 'Sven Stalman', 'LeverancierNummer' => 'L1029324748', 'Mobiel' => '06-24383291', 'ContactId' => 3],
            ['Naam' => 'Basset', 'ContactPersoon' => 'Joyce Stelterberg', 'LeverancierNummer' => 'L1023845773', 'Mobiel' => '06-48293823', 'ContactId' => 4],
            ['Naam' => 'De Bron', 'ContactPersoon' => 'Remco Veenstra', 'LeverancierNummer' => 'L1023857736', 'Mobiel' => '06-34291234', 'ContactId' => 5],
            ['Naam' => 'Quality Street', 'ContactPersoon' => 'Johan Nooij', 'LeverancierNummer' => 'L1029234586', 'Mobiel' => '06-23458456', 'ContactId' => 6],
        ];

        foreach ($leveranciers as $lev) {
            Leverancier::create($lev);
        }

        // Seed Products
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
        ];

        foreach ($products as $prod) {
            Product::create($prod);
        }

        // Seed Magazijn
        $magazijns = [
            ['ProductId' => 1, 'VerpakkingsEenheid' => 5, 'AantalAanwezig' => 453],
            ['ProductId' => 2, 'VerpakkingsEenheid' => 2.5, 'AantalAanwezig' => 400],
            ['ProductId' => 3, 'VerpakkingsEenheid' => 5, 'AantalAanwezig' => 1],
            ['ProductId' => 4, 'VerpakkingsEenheid' => 1, 'AantalAanwezig' => 800],
            ['ProductId' => 5, 'VerpakkingsEenheid' => 3, 'AantalAanwezig' => 234],
            ['ProductId' => 6, 'VerpakkingsEenheid' => 2, 'AantalAanwezig' => 345],
            ['ProductId' => 7, 'VerpakkingsEenheid' => 1, 'AantalAanwezig' => 795],
            ['ProductId' => 8, 'VerpakkingsEenheid' => 10, 'AantalAanwezig' => 233],
            ['ProductId' => 9, 'VerpakkingsEenheid' => 2.5, 'AantalAanwezig' => 123],
            ['ProductId' => 10, 'VerpakkingsEenheid' => 3, 'AantalAanwezig' => null],
            ['ProductId' => 11, 'VerpakkingsEenheid' => 2, 'AantalAanwezig' => 367],
            ['ProductId' => 12, 'VerpakkingsEenheid' => 1, 'AantalAanwezig' => 467],
            ['ProductId' => 13, 'VerpakkingsEenheid' => 5, 'AantalAanwezig' => 20],
        ];

        foreach ($magazijns as $mag) {
            Magazijn::create($mag);
        }

        // Seed Allergeens
        $allergeens = [
            ['Naam' => 'Gluten', 'Omschrijving' => 'Dit product bevat gluten'],
            ['Naam' => 'Gelatine', 'Omschrijving' => 'Dit product bevat gelatine'],
            ['Naam' => 'AZO-Kleurstof', 'Omschrijving' => 'Dit product bevat AZO-kleurstoffen'],
            ['Naam' => 'Lactose', 'Omschrijving' => 'Dit product bevat lactose'],
            ['Naam' => 'Soja', 'Omschrijving' => 'Dit product bevat soja'],
        ];

        foreach ($allergeens as $all) {
            Allergeen::create($all);
        }

        // Seed ProductPerAllergeen
        $productAllergeens = [
            ['ProductId' => 1, 'AllergeenId' => 2],
            ['ProductId' => 1, 'AllergeenId' => 1],
            ['ProductId' => 1, 'AllergeenId' => 3],
            ['ProductId' => 3, 'AllergeenId' => 4],
            ['ProductId' => 6, 'AllergeenId' => 5],
            ['ProductId' => 9, 'AllergeenId' => 2],
            ['ProductId' => 9, 'AllergeenId' => 5],
            ['ProductId' => 10, 'AllergeenId' => 2],
            ['ProductId' => 12, 'AllergeenId' => 4],
            ['ProductId' => 13, 'AllergeenId' => 1],
            ['ProductId' => 13, 'AllergeenId' => 4],
            ['ProductId' => 13, 'AllergeenId' => 5],
        ];

        foreach ($productAllergeens as $pa) {
            ProductPerAllergeen::create($pa);
        }

        // Seed ProductPerLeverancier
        $productLeveranciers = [
            ['LeverancierId' => 1, 'ProductId' => 1, 'DatumLevering' => '2024-11-09', 'Aantal' => 23, 'DatumEerstVolgendeLevering' => '2024-11-16'],
            ['LeverancierId' => 1, 'ProductId' => 1, 'DatumLevering' => '2024-11-18', 'Aantal' => 21, 'DatumEerstVolgendeLevering' => '2024-11-25'],
            ['LeverancierId' => 1, 'ProductId' => 2, 'DatumLevering' => '2024-11-09', 'Aantal' => 12, 'DatumEerstVolgendeLevering' => '2024-11-16'],
            ['LeverancierId' => 1, 'ProductId' => 3, 'DatumLevering' => '2024-11-10', 'Aantal' => 11, 'DatumEerstVolgendeLevering' => '2024-11-17'],
            ['LeverancierId' => 2, 'ProductId' => 4, 'DatumLevering' => '2024-11-14', 'Aantal' => 16, 'DatumEerstVolgendeLevering' => '2024-11-21'],
            ['LeverancierId' => 2, 'ProductId' => 4, 'DatumLevering' => '2024-11-21', 'Aantal' => 23, 'DatumEerstVolgendeLevering' => '2024-11-28'],
            ['LeverancierId' => 2, 'ProductId' => 5, 'DatumLevering' => '2024-11-14', 'Aantal' => 45, 'DatumEerstVolgendeLevering' => '2024-11-21'],
            ['LeverancierId' => 2, 'ProductId' => 6, 'DatumLevering' => '2024-11-14', 'Aantal' => 30, 'DatumEerstVolgendeLevering' => '2024-11-21'],
            ['LeverancierId' => 3, 'ProductId' => 7, 'DatumLevering' => '2024-11-12', 'Aantal' => 12, 'DatumEerstVolgendeLevering' => '2024-11-19'],
            ['LeverancierId' => 3, 'ProductId' => 7, 'DatumLevering' => '2024-11-19', 'Aantal' => 23, 'DatumEerstVolgendeLevering' => '2024-11-26'],
            ['LeverancierId' => 3, 'ProductId' => 8, 'DatumLevering' => '2024-11-10', 'Aantal' => 12, 'DatumEerstVolgendeLevering' => '2024-11-17'],
            ['LeverancierId' => 3, 'ProductId' => 9, 'DatumLevering' => '2024-11-11', 'Aantal' => 1, 'DatumEerstVolgendeLevering' => '2024-11-18'],
            ['LeverancierId' => 4, 'ProductId' => 10, 'DatumLevering' => '2024-11-16', 'Aantal' => 24, 'DatumEerstVolgendeLevering' => '2024-11-30'],
            ['LeverancierId' => 5, 'ProductId' => 11, 'DatumLevering' => '2024-11-10', 'Aantal' => 47, 'DatumEerstVolgendeLevering' => '2024-11-17'],
            ['LeverancierId' => 5, 'ProductId' => 11, 'DatumLevering' => '2024-11-19', 'Aantal' => 60, 'DatumEerstVolgendeLevering' => '2024-11-26'],
            ['LeverancierId' => 5, 'ProductId' => 12, 'DatumLevering' => '2024-11-11', 'Aantal' => 45, 'DatumEerstVolgendeLevering' => null],
            ['LeverancierId' => 5, 'ProductId' => 13, 'DatumLevering' => '2024-11-12', 'Aantal' => 23, 'DatumEerstVolgendeLevering' => null],
        ];

        foreach ($productLeveranciers as $pl) {
            ProductPerLeverancier::create($pl);
        }
    }
}
