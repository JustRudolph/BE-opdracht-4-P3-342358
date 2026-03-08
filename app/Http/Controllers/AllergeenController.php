<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Allergeen;
use App\Models\Product;
use App\Models\Leverancier;
use Illuminate\Support\Facades\DB;

class AllergeenController extends Controller
{
    /**
     * Scenario 01: Display overview of products with allergies
     * Shows filtered products based on selected allergen
     */
    public function index(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'allergen_id' => 'nullable|integer|exists:allergeens,id',
        ]);

        $allergeens = Allergeen::where('IsActief', true)
            ->orderBy('Naam', 'ASC')
            ->get();
        
        $selectedAllergeenId = $validated['allergen_id'] ?? null;
        
        $query = Product::where('IsActief', true)
            ->with('magazijn');

        // Filter by allergen if selected
        if ($selectedAllergeenId) {
            $query->whereHas('allergeens', function ($q) use ($selectedAllergeenId) {
                $q->where('allergeens.id', $selectedAllergeenId);
            });

            $query->with(['allergeens' => function ($q) use ($selectedAllergeenId) {
                $q->where('allergeens.id', $selectedAllergeenId);
            }]);
        } else {
            // Show all products with any allergen
            $query->whereHas('allergeens');
            $query->with('allergeens');
        }

        // Sort by name (A-Z)
        $products = $query->orderBy('Naam', 'ASC')
            ->paginate(4); // 4 records per page as per requirement

        return view('allergeens.index', [
            'products' => $products,
            'allergeens' => $allergeens,
            'selectedAllergeenId' => $selectedAllergeenId,
        ]);
    }

    /**
     * Scenario 02 & 03: Show supplier details for a product with allergen
     * Displays supplier information including contact details if available
     */
    public function supplierDetails($productId)
    {
        // Validate input
        if (!is_numeric($productId)) {
            abort(404, 'Invalid product ID');
        }

        $product = Product::with('allergeens')
            ->where('IsActief', true)
            ->findOrFail($productId);

        // Get all suppliers for this product
        $suppliers = $product->leveranciers()
            ->where('leveranciers.IsActief', true)
            ->with(['contact'])
            ->get();

        if ($suppliers->isEmpty()) {
            abort(404, 'No supplier found for this product');
        }

        // Get the first supplier (most recent delivery)
        $supplier = $suppliers->first();

        // Check if supplier has contact information
        $hasContactInfo = $supplier->contact !== null && $supplier->contact->IsActief;

        return view('allergeens.supplier-details', [
            'product' => $product,
            'supplier' => $supplier,
            'hasContactInfo' => $hasContactInfo,
        ]);
    }
}
