<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductPerLeverancier;
use App\Models\Magazijn;
use App\Models\Leverancier;

class ProductController extends Controller
{
    // User Story 2 - Show form to add new delivery
    public function showLeveringForm($leverancierId, $productId)
    {
        $leverancier = Leverancier::findOrFail($leverancierId);
        $product = Product::findOrFail($productId);

        return view('producten.levering-product', [
            'leverancier' => $leverancier,
            'product' => $product
        ]);
    }

    // User Story 2 - Scenario 1 & 2: Process new delivery
    public function storeLevering(Request $request, $leverancierId, $productId)
    {
        $request->validate([
            'aantal_producteenheden' => 'required|integer|min:1',
            'datum_eerstvolgende_levering' => 'required|date',
        ]);

        $leverancier = Leverancier::findOrFail($leverancierId);
        $product = Product::findOrFail($productId);

        // Check if product is active (Scenario 2)
        if (!$product->IsActief) {
            return view('producten.levering-product', [
                'leverancier' => $leverancier,
                'product' => $product,
                'error' => "Het product {$product->Naam} van de leverancier {$leverancier->Naam} wordt niet meer geproduceerd"
            ]);
        }

        // Create new delivery record
        ProductPerLeverancier::create([
            'LeverancierId' => $leverancierId,
            'ProductId' => $productId,
            'DatumLevering' => now()->format('Y-m-d'),
            'Aantal' => $request->aantal_producteenheden,
            'DatumEerstVolgendeLevering' => $request->datum_eerstvolgende_levering,
        ]);

        // Update warehouse quantity
        $magazijn = Magazijn::where('ProductId', $productId)->first();
        if ($magazijn) {
            $magazijn->AantalAanwezig = ($magazijn->AantalAanwezig ?? 0) + $request->aantal_producteenheden;
            $magazijn->save();
        }

        // Redirect back to supplier products
        return redirect()->route('leveranciers.products', $leverancierId)
            ->with('success', 'Levering succesvol toegevoegd');
    }
}
