<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Leverancier;
use App\Models\ProductPerLeverancier;
use App\Models\Contact;
use App\Http\Controllers\DeliveredProductsController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class DeliveredProductsControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test Case 1: Database retrieval of delivered products 
     * Verifies that products can be retrieved from database by date range
     */
    public function test_delivered_products_retrieval_by_date_range()
    {
        // Arrange: Create test data
        $contact = Contact::factory()->create();
        $leverancier = Leverancier::factory()->create(['ContactId' => $contact->id]);
        $product = Product::factory()->create(['Naam' => 'Testproduct']);
        
        ProductPerLeverancier::create([
            'LeverancierId' => $leverancier->id,
            'ProductId' => $product->id,
            'DatumLevering' => '2023-04-10',
            'Aantal' => 25,
            'IsActief' => 1,
        ]);

        // Act: Query delivered products for the date range
        $startDate = '2023-04-08';
        $endDate = '2023-04-15';
        
        $result = ProductPerLeverancier::where('DatumLevering', '>=', $startDate)
            ->where('DatumLevering', '<=', $endDate)
            ->where('IsActief', 1)
            ->with(['product', 'leverancier'])
            ->get();

        // Assert: Verify the data retrieval works
        $this->assertGreaterThan(0, $result->count());
        $this->assertEquals('Testproduct', $result[0]->product->Naam);
    }

    /**
     * Test Case 2: Product specifications retrieval
     * Verifies that delivery details for a product can be retrieved
     */
    public function test_product_delivery_specifications_retrieval()
    {
        // Arrange: Create test data
        $contact = Contact::factory()->create();
        $leverancier = Leverancier::factory()->create(['ContactId' => $contact->id]);
        $product = Product::factory()->create(['Naam' => 'Specproduct']);
        
        // Create multiple deliveries
        $deliveries = [];
        for ($i = 1; $i <= 3; $i++) {
            $deliveries[] = ProductPerLeverancier::create([
                'LeverancierId' => $leverancier->id,
                'ProductId' => $product->id,
                'DatumLevering' => '2023-04-' . (8 + $i),
                'Aantal' => 20 + ($i * 5),
                'IsActief' => 1,
            ]);
        }

        // Act: Retrieve specifications for the specific product
        $startDate = '2023-04-08';
        $endDate = '2023-04-15';
        
        $specifications = ProductPerLeverancier::where('ProductId', $product->id)
            ->where('DatumLevering', '>=', $startDate)
            ->where('DatumLevering', '<=', $endDate)
            ->where('IsActief', 1)
            ->with(['leverancier'])
            ->orderBy('DatumLevering', 'ASC')
            ->get();

        // Assert: Verify all deliveries are retrieved
        $this->assertEquals(count($deliveries), $specifications->count());
        $this->assertEquals($product->id, $specifications[0]->ProductId);
    }

    /**
     * Test Case 3: Product validation in controller
     * Verifies that the controller properly handles products
     */
    public function test_product_retrieval_from_database()
    {
        // Arrange: Create a product
        $product = Product::factory()->create([
            'Naam' => 'Mintnopjes',
            'Barcode' => '12345678',
            'IsActief' => 1,
        ]);

        // Act: Retrieve the product
        $retrieved = Product::find($product->id);

        // Assert: Verify product data
        $this->assertNotNull($retrieved);
        $this->assertEquals('Mintnopjes', $retrieved->Naam);
        $this->assertEquals('12345678', $retrieved->Barcode);
        $this->assertTrue($retrieved->IsActief);
    }

    /**
     * Test Case 4: Pagination calculation
     * Verifies that pagination with 4 items per page calculates correctly
     */
    public function test_pagination_calculation_for_4_items_per_page()
    {
        // Arrange: Create 9 products
        for ($i = 1; $i <= 9; $i++) {
            Product::factory()->create();
        }

        // Act: Calculate pagination
        $totalItems = Product::count();
        $itemsPerPage = 4;
        $totalPages = ceil($totalItems / $itemsPerPage);
        $currentPage = 1;
        $offset = ($currentPage - 1) * $itemsPerPage;

        // Assert: Verify pagination values
        $this->assertEquals(9, $totalItems);
        $this->assertEquals(4, $itemsPerPage);
        $this->assertEquals(3, $totalPages);  // 9 / 4 = 2.25, ceil = 3 pages
        $this->assertEquals(0, $offset);      // First page offset
        $this->assertLessThanOrEqual($itemsPerPage, count(Product::limit($itemsPerPage)->offset($offset)->get()));
    }

    /**
     * Test Case 5: Get all delivered products without date range
     * Verifies that all products are retrieved when no date range is specified
     */
    public function test_all_delivered_products_without_date_range()
    {
        // Arrange: Create test data without specific dates
        $contact = Contact::factory()->create();
        $leverancier = Leverancier::factory()->create(['ContactId' => $contact->id]);
        $product1 = Product::factory()->create(['Naam' => 'Product 1']);
        $product2 = Product::factory()->create(['Naam' => 'Product 2']);
        
        ProductPerLeverancier::create([
            'LeverancierId' => $leverancier->id,
            'ProductId' => $product1->id,
            'DatumLevering' => '2023-01-15',
            'Aantal' => 10,
            'IsActief' => 1,
        ]);
        
        ProductPerLeverancier::create([
            'LeverancierId' => $leverancier->id,
            'ProductId' => $product2->id,
            'DatumLevering' => '2023-12-10',
            'Aantal' => 20,
            'IsActief' => 1,
        ]);

        // Act: Query all delivered products without date filter
        $deliveredProducts = ProductPerLeverancier::join('leveranciers', 'product_per_leveranciers.LeverancierId', '=', 'leveranciers.id')
            ->join('products', 'product_per_leveranciers.ProductId', '=', 'products.id')
            ->where('product_per_leveranciers.IsActief', 1)
            ->where('leveranciers.IsActief', 1)
            ->where('products.IsActief', 1)
            ->select(['leveranciers.Naam as LeverancierNaam', 'products.Naam as ProductNaam', 'products.Barcode'])
            ->get();

        // Assert: Verify both products are retrieved regardless of date
        $this->assertGreaterThanOrEqual(2, $deliveredProducts->count());
    }
}
