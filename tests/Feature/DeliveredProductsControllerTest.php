<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Leverancier;
use App\Models\ProductPerLeverancier;
use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeliveredProductsControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test Case 1: View overview of delivered products within a date range
     * This tests Scenario 01 - Display delivered products
     */
    public function test_delivered_products_index_with_valid_date_range()
    {
        // Arrange: Create test data
        $contact = Contact::factory()->create();
        $leverancier = Leverancier::factory()->create(['ContactId' => $contact->id]);
        $product = Product::factory()->create();
        
        // Create delivery records
        ProductPerLeverancier::create([
            'LeverancierId' => $leverancier->id,
            'ProductId' => $product->id,
            'DatumLevering' => '2023-04-10',
            'Aantal' => 25,
            'DatumEerstVolgendeLevering' => '2023-04-17',
        ]);

        // Act: Make the request
        $response = $this->get(route('delivered-products.index', [
            'start_date' => '2023-04-08',
            'end_date' => '2023-04-15',
        ]));

        // Assert: Verify response
        $response->assertStatus(200);
        $response->assertSee($product->Naam);
        $response->assertSee($leverancier->Naam);
    }

    /**
     * Test Case 2: View product delivery specifications within a date range
     * This tests Scenario 02 - Display product specifications
     */
    public function test_delivered_products_specifications_with_valid_product()
    {
        // Arrange: Create test data
        $contact = Contact::factory()->create();
        $leverancier = Leverancier::factory()->create(['ContactId' => $contact->id]);
        $product = Product::factory()->create(['Naam' => 'Mintnopjes']);
        
        // Create multiple delivery records
        for ($i = 0; $i < 3; $i++) {
            ProductPerLeverancier::create([
                'LeverancierId' => $leverancier->id,
                'ProductId' => $product->id,
                'DatumLevering' => '2023-04-' . (9 + $i),
                'Aantal' => 20 + ($i * 5),
                'DatumEerstVolgendeLevering' => '2023-04-' . (16 + $i),
            ]);
        }

        // Act: Make the request
        $response = $this->get(route('delivered-products.specifications', [
            'productId' => $product->id,
        ], [
            'start_date' => '2023-04-08',
            'end_date' => '2023-04-15',
        ]));

        // Assert: Verify response
        $response->assertStatus(200);
        $response->assertSee($product->Naam);
        $response->assertSee($leverancier->Naam);
    }

    /**
     * Test Case 3: No deliveries found - Scenario 03
     * This tests handling when no products are delivered in the date range
     */
    public function test_delivered_products_index_with_no_results()
    {
        // Arrange: Create test data but with deliveries outside the requested range
        $contact = Contact::factory()->create();
        $leverancier = Leverancier::factory()->create(['ContactId' => $contact->id]);
        $product = Product::factory()->create();
        
        ProductPerLeverancier::create([
            'LeverancierId' => $leverancier->id,
            'ProductId' => $product->id,
            'DatumLevering' => '2023-05-10',
            'Aantal' => 25,
        ]);

        // Act: Make request for different date range
        $response = $this->get(route('delivered-products.index', [
            'start_date' => '2023-04-08',
            'end_date' => '2023-04-15',
        ]));

        // Assert: Verify no results message is shown
        $response->assertStatus(200);
        $response->assertSee('Er zijn geen leveringen geweest van producten in deze periode');
    }

    /**
     * Test Case 4: Pagination works correctly
     * Verifies that pagination with max 4 records per page works as expected
     */
    public function test_pagination_shows_max_4_records_per_page()
    {
        // Arrange: Create 8 delivered products
        $contact = Contact::factory()->create();
        $leverancier = Leverancier::factory()->create(['ContactId' => $contact->id]);
        
        for ($i = 0; $i < 8; $i++) {
            $product = Product::factory()->create(['Naam' => 'Product' . $i]);
            ProductPerLeverancier::create([
                'LeverancierId' => $leverancier->id,
                'ProductId' => $product->id,
                'DatumLevering' => '2023-04-' . (10 + $i),
                'Aantal' => 20,
            ]);
        }

        // Act & Assert: First page should have 4 items
        $response = $this->get(route('delivered-products.index', [
            'start_date' => '2023-04-08',
            'end_date' => '2023-04-20',
            'page' => 1,
        ]));
        
        $response->assertStatus(200);
        $response->assertViewHas('totalPages', 2);
        $response->assertViewHas('itemsPerPage', 4);
    }
}
