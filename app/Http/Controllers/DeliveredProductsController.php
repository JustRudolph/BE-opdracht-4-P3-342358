<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductPerLeverancier;
use App\Models\Leverancier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveredProductsController extends Controller
{
    /**
     * Display the overview of delivered products within a date range or all products
     * Scenario 01 & 03
     */
    public function index(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $deliveredProducts = [];
        $showResults = true;
        $message = null;
        $itemsPerPage = 4;

        try {
            // If both dates are provided, use date-filtered query
            if ($startDate && $endDate) {
                $startDate = date('Y-m-d', strtotime($startDate));
                $endDate = date('Y-m-d', strtotime($endDate));
                
                // Call stored procedure for date range
                $deliveredProducts = DB::select(
                    'CALL sp_GetDeliveredProductsByDateRange(?, ?)',
                    [$startDate, $endDate]
                );

                // If no results, set message for Scenario 03
                if (empty($deliveredProducts)) {
                    $message = "Er zijn geen leveringen geweest van producten in deze periode";
                }
            } else {
                // Get all delivered products regardless of date
                $deliveredProducts = DB::select('
                    SELECT 
                        l.Naam AS LeverancierNaam,
                        p.Naam AS ProductNaam,
                        p.Barcode,
                        p.id AS ProductId,
                        SUM(ppl.Aantal) AS TotalAantalGeleverd,
                        COUNT(ppl.id) AS AantalLeveringen
                    FROM product_per_leveranciers ppl
                    JOIN leveranciers l ON ppl.LeverancierId = l.id
                    JOIN products p ON ppl.ProductId = p.id
                    WHERE ppl.IsActief = 1 AND l.IsActief = 1 AND p.IsActief = 1
                    GROUP BY ppl.ProductId, l.id
                    ORDER BY l.Naam ASC, p.Naam ASC
                ');
                
                if (empty($deliveredProducts)) {
                    $message = "Er zijn geen geleverde producten beschikbaar";
                }
            }
        } catch (\Exception $e) {
            return back()->withError('Er is een fout opgetreden: ' . $e->getMessage());
        }

        // Paginate results
        $currentPage = $request->input('page', 1);
        $offset = ($currentPage - 1) * $itemsPerPage;
        $paginatedProducts = array_slice($deliveredProducts, $offset, $itemsPerPage);
        $totalItems = count($deliveredProducts);
        $totalPages = ceil($totalItems / $itemsPerPage);

        return view('delivered-products.index', [
            'deliveredProducts' => $paginatedProducts,
            'totalProducts' => $totalItems,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'showResults' => $showResults,
            'message' => $message,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'itemsPerPage' => $itemsPerPage,
        ]);
    }

    /**
     * Display delivery specifications for a specific product
     * Scenario 02
     */
    public function specifications(Request $request, $productId)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $specifications = [];
        $product = null;
        $message = null;
        $itemsPerPage = 4;

        try {
            // Get product info
            $product = Product::find($productId);
            
            if (!$product) {
                return back()->withError('Product niet gevonden');
            }

            // If both dates are provided, use date-filtered query
            if ($startDate && $endDate) {
                $startDate = date('Y-m-d', strtotime($startDate));
                $endDate = date('Y-m-d', strtotime($endDate));
                
                // Call stored procedure for specifications
                $specifications = DB::select(
                    'CALL sp_GetProductDeliverySpecifications(?, ?, ?)',
                    [$productId, $startDate, $endDate]
                );

                if (empty($specifications)) {
                    $message = "Er zijn geen leveringen voor dit product in deze periode";
                }
            } else {
                // Get all delivery specifications for this product
                $specifications = DB::select('
                    SELECT 
                        l.Naam AS LeverancierNaam,
                        c.Straat,
                        c.Huisnummer,
                        ppl.DatumLevering,
                        ppl.Aantal,
                        ppl.DatumEerstVolgendeLevering
                    FROM product_per_leveranciers ppl
                    JOIN leveranciers l ON ppl.LeverancierId = l.id
                    LEFT JOIN contacts c ON l.ContactId = c.id
                    WHERE ppl.ProductId = ? AND ppl.IsActief = 1
                    ORDER BY ppl.DatumLevering DESC
                ', [$productId]);

                if (empty($specifications)) {
                    $message = "Er zijn geen leveringen beschikbaar voor dit product";
                }
            }
        } catch (\Exception $e) {
            return back()->withError('Er is een fout opgetreden: ' . $e->getMessage());
        }

        // Paginate results
        $currentPage = $request->input('page', 1);
        $offset = ($currentPage - 1) * $itemsPerPage;
        $paginatedSpecifications = array_slice($specifications, $offset, $itemsPerPage);
        $totalItems = count($specifications);
        $totalPages = ceil($totalItems / $itemsPerPage);

        return view('delivered-products.specifications', [
            'product' => $product,
            'specifications' => $paginatedSpecifications,
            'totalSpecifications' => $totalItems,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'message' => $message,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'itemsPerPage' => $itemsPerPage,
        ]);
    }
}
