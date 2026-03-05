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
        $allergeens = Allergeen::where('IsActief', true)->get();
        $selectedAllergeenId = $request->input('allergen_id');
        
        $query = Product::where('IsActief', true);

        // Filter by allergen if selected
        if ($selectedAllergeenId) {
            $query->whereHas('allergeens', function ($q) use ($selectedAllergeenId) {
                $q->where('AllergeenId', $selectedAllergeenId);
            });
        } else {
            // Show all products with any allergen
            $query->whereHas('allergeens');
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
        $product = Product::with('allergeens')
            ->findOrFail($productId);

        // Get all suppliers for this product
        $suppliers = $product->leveranciers()
            ->with(['contact'])
            ->get();

        if ($suppliers->isEmpty()) {
            abort(404, 'Geen leverancier gevonden voor dit product');
        }

        // Get the first supplier (most recent delivery)
        $supplier = $suppliers->first();

        // Check if supplier has contact information
        $hasContactInfo = $supplier->contact !== null;

        return view('allergeens.supplier-details', [
            'product' => $product,
            'supplier' => $supplier,
            'hasContactInfo' => $hasContactInfo,
        ]);
    }
}
