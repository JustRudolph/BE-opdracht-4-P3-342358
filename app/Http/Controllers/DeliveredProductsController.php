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
            if ($startDate) {
                $startDate = date('Y-m-d', strtotime($startDate));
            }
            if ($endDate) {
                $endDate = date('Y-m-d', strtotime($endDate));
            }

            $query = "
                SELECT 
                    l.Naam AS LeverancierNaam,
                    l.ContactPersoon,
                    p.Naam AS ProductNaam,
                    p.id AS ProductId,
                    SUM(ppl.Aantal) AS TotalAantalGeleverd
                FROM product_per_leveranciers ppl
                JOIN leveranciers l ON ppl.LeverancierId = l.id
                JOIN products p ON ppl.ProductId = p.id
                WHERE ppl.IsActief = 1
            ";

            $bindings = [];

            if ($startDate) {
                $query .= ' AND ppl.DatumLevering >= ?';
                $bindings[] = $startDate;
            }

            if ($endDate) {
                $query .= ' AND ppl.DatumLevering <= ?';
                $bindings[] = $endDate;
            }

            $query .= "
                GROUP BY ppl.ProductId, l.id
                ORDER BY l.Naam ASC, p.Naam ASC
            ";

            $deliveredProducts = DB::select($query, $bindings);

            if (empty($deliveredProducts)) {
                if ($startDate || $endDate) {
                    $message = "Er zijn geen leveringen geweest van producten in deze periode";
                } else {
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

            if ($startDate) {
                $startDate = date('Y-m-d', strtotime($startDate));
            }
            if ($endDate) {
                $endDate = date('Y-m-d', strtotime($endDate));
            }

            $query = '
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
            ';

            $bindings = [$productId];

            if ($startDate) {
                $query .= ' AND ppl.DatumLevering >= ?';
                $bindings[] = $startDate;
            }

            if ($endDate) {
                $query .= ' AND ppl.DatumLevering <= ?';
                $bindings[] = $endDate;
            }

            $query .= ' ORDER BY ppl.DatumLevering DESC';

            $specifications = DB::select($query, $bindings);

            if (empty($specifications)) {
                if ($startDate || $endDate) {
                    $message = "Er zijn geen leveringen voor dit product in deze periode";
                } else {
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
