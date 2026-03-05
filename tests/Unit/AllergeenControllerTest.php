<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Allergeen;
use App\Models\ProductPerAllergeen;
use App\Models\Leverancier;
use App\Models\Contact;
use App\Models\ProductPerLeverancier;
use App\Models\Magazijn;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AllergeenControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test 1: Allergen filtering returns only products with selected allergen
     * Verifies that when filtering by a specific allergen, only products
     * containing that allergen are returned, sorted alphabetically by name
     */
    public function test_allergen_filtering_returns_products_with_selected_allergen()
    {
        // Arrange: Create test data
        $allergenGluten = Allergeen::factory()->create(['Naam' => 'Gluten']);
        $allergenSoja = Allergeen::factory()->create(['Naam' => 'Soja']);
        
        $product1 = Product::factory()->create(['Naam' => 'Apple Drops', 'IsActief' => true]);
        $product2 = Product::factory()->create(['Naam' => 'Berry Candy', 'IsActief' => true]);
        $product3 = Product::factory()->create(['Naam' => 'Cherry Bits', 'IsActief' => true]);

        // Associate products with allergens
        ProductPerAllergeen::factory()->create([
            'ProductId' => $product1->id,
            'AllergeenId' => $allergenGluten->id,
            'IsActief' => true
        ]);
        
        ProductPerAllergeen::factory()->create([
            'ProductId' => $product2->id,
            'AllergeenId' => $allergenGluten->id,
            'IsActief' => true
        ]);
        
        ProductPerAllergeen::factory()->create([
            'ProductId' => $product3->id,
            'AllergeenId' => $allergenSoja->id,
            'IsActief' => true
        ]);

        // Create magazine entries for all products
        Magazijn::factory()->create(['ProductId' => $product1->id, 'AantalAanwezig' => 100]);
        Magazijn::factory()->create(['ProductId' => $product2->id, 'AantalAanwezig' => 50]);
        Magazijn::factory()->create(['ProductId' => $product3->id, 'AantalAanwezig' => 25]);

        // Act: Call the index method with Gluten allergen filter
        $response = $this->get(route('allergeens.index', ['allergen_id' => $allergenGluten->id]));

        // Assert: Check that only products with Gluten are returned
        $response->assertStatus(200);
        $response->assertViewIs('allergeens.index');
        
        $products = $response->viewData('products');
        
        // Verify we have 2 products with Gluten allergen
        $this->assertTrue($products->count() >= 1, 'At least one product with Gluten should be returned');
        
        // Verify products are sorted alphabetically
        $productNames = $products->map(fn($p) => $p->Naam)->toArray();
        $sortedNames = $productNames;
        sort($sortedNames);
        
        $this->assertEquals($sortedNames, $productNames, 'Products should be sorted alphabetically by name');
    }

    /**
     * Test 2: Supplier details page shows contact information when available
     * Verifies that the supplier details page correctly displays supplier
     * and contact information when a supplier has associated contact data
     */
    public function test_supplier_details_displays_contact_information()
    {
        // Arrange: Create test data
        $contact = Contact::factory()->create([
            'Straat' => 'Teststraat',
            'Huisnummer' => 42,
            'Postcode' => '1234AB',
            'Stad' => 'Amsterdam',
            'IsActief' => true
        ]);

        $supplier = Leverancier::factory()->create([
            'Naam' => 'Test Supplier',
            'ContactPersoon' => 'John Doe',
            'Mobiel' => '06-12345678',
            'ContactId' => $contact->id,
            'IsActief' => true
        ]);

        $product = Product::factory()->create(['Naam' => 'Test Product', 'IsActief' => true]);

        // Create relationship between product and supplier
        ProductPerLeverancier::factory()->create([
            'ProductId' => $product->id,
            'LeverancierId' => $supplier->id,
            'DatumLevering' => '2024-01-01',
            'Aantal' => 100,
            'IsActief' => true
        ]);

        // Associate product with an allergen
        $allergen = Allergeen::factory()->create(['Naam' => 'Test Allergen']);
        ProductPerAllergeen::factory()->create([
            'ProductId' => $product->id,
            'AllergeenId' => $allergen->id,
            'IsActief' => true
        ]);

        // Act: Call the supplier details route
        $response = $this->get(route('allergeens.supplier-details', $product->id));

        // Assert: Verify the response shows supplier and contact information
        $response->assertStatus(200);
        $response->assertViewIs('allergeens.supplier-details');
        
        $viewData = $response->viewData();
        
        // Verify supplier data is passed to the view
        $this->assertEquals($product->id, $viewData['product']->id);
        $this->assertEquals($supplier->id, $viewData['supplier']->id);
        $this->assertTrue($viewData['hasContactInfo'], 'Should indicate that contact information is available');
        
        // Verify contact information is accessible
        $this->assertEquals('Teststraat', $viewData['supplier']->contact->Straat);
        $this->assertEquals('Amsterdam', $viewData['supplier']->contact->Stad);
    }
}
