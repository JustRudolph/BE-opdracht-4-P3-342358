<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leverancier;
use App\Models\ProductPerLeverancier;
use Illuminate\Support\Facades\DB;
use App\Services\LeverancierService;

class LeverancierController extends Controller
{
    // Overzicht leveranciers met server-side pagination (max 4)
    public function index()
    {
        $leveranciers = DB::table('leveranciers as l')
            ->leftJoin('product_per_leveranciers as ppl', 'l.id', '=', 'ppl.LeverancierId')
            ->select(
                'l.id',
                'l.Naam',
                'l.ContactPersoon',
                'l.LeverancierNummer',
                'l.Mobiel',
                DB::raw('COUNT(DISTINCT ppl.ProductId) as AantalVerschillendeProducten')
            )
            ->groupBy('l.id', 'l.Naam', 'l.ContactPersoon', 'l.LeverancierNummer', 'l.Mobiel')
            ->orderByDesc('AantalVerschillendeProducten')
            ->paginate(4);

        return view('leveranciers.index', compact('leveranciers'));
    }

    // Leverancier details
    public function details(int $id, LeverancierService $service)
    {
        $details = $service->getDetails($id);
        abort_unless($details, 404);

        return view('leveranciers.details', [
            'details' => $details,
        ]);
    }

    // Wijzig formulier
    public function edit(int $id, LeverancierService $service)
    {
        $details = $service->getDetails($id);
        abort_unless($details, 404);

        return view('leveranciers.edit', [
            'details' => $details,
        ]);
    }

    // Sla wijziging op (mobiel + straatnaam) via stored procedure
    public function update(Request $request, int $id, LeverancierService $service)
    {
        $validated = $request->validate([
            'Mobiel' => 'required|string|max:20',
            'Straat' => 'required|string|max:100',
        ]);

        $result = $service->updateContact($id, $validated['Mobiel'], $validated['Straat']);

        // Redirect to details with feedback and client-side 3s redirect
        return redirect()->route('leveranciers.details', $id)
            ->with('feedback_message', $result['message'])
            ->with('feedback_success', $result['success']);
    }

    // (Legacy) Show products delivered by supplier
    public function showProducts($id)
    {
        $leverancier = Leverancier::findOrFail($id);
        
        // Get products with latest delivery date and warehouse quantity
        $products = DB::select(
            "SELECT 
                p.id,
                p.Naam as NaamProduct,
                m.AantalAanwezig as AantalInMagazijn,
                m.VerpakkingsEenheid,
                MAX(ppl.DatumLevering) as LaatsteLevering
            FROM products p
            INNER JOIN product_per_leveranciers ppl ON p.id = ppl.ProductId
            LEFT JOIN magazijns m ON p.id = m.ProductId
            WHERE ppl.LeverancierId = ?
            GROUP BY p.id, p.Naam, m.VerpakkingsEenheid, m.AantalAanwezig
            ORDER BY AantalInMagazijn DESC",
            [$id]
        );

        // Check if no products found (Scenario 2)
        if (empty($products)) {
            return view('leveranciers.geleverde-producten', [
                'leverancier' => $leverancier,
                'products' => [],
                'noProducts' => true
            ]);
        }

        return view('leveranciers.geleverde-producten', [
            'leverancier' => $leverancier,
            'products' => $products,
            'noProducts' => false
        ]);
    }
}
