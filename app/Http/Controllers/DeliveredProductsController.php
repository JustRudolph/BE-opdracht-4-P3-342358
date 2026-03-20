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
     * Display the overview of delivered products within a date range
     * Scenario 01 & 03
     */
    public function index(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $deliveredProducts = [];
        $showResults = false;
        $message = null;
        $itemsPerPage = 4;

        // If both dates are provided, execute the query
        if ($startDate && $endDate) {
            $showResults = true;
            
            // Validate dates
            try {
                $startDate = date('Y-m-d', strtotime($startDate));
                $endDate = date('Y-m-d', strtotime($endDate));
                
                // Call stored procedure
                $deliveredProducts = DB::select(
                    'CALL sp_GetDeliveredProductsByDateRange(?, ?)',
                    [$startDate, $endDate]
                );

                // If no results, set message for Scenario 03
                if (empty($deliveredProducts)) {
                    $message = "Er zijn geen leveringen geweest van producten in deze periode";
                }
            } catch (\Exception $e) {
                return back()->withError('Er is een fout opgetreden: ' . $e->getMessage());
            }
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

        if ($startDate && $endDate) {
            try {
                $startDate = date('Y-m-d', strtotime($startDate));
                $endDate = date('Y-m-d', strtotime($endDate));
                
                // Get product info
                $product = Product::find($productId);
                
                if (!$product) {
                    return back()->withError('Product niet gevonden');
                }

                // Call stored procedure for specifications
                $specifications = DB::select(
                    'CALL sp_GetProductDeliverySpecifications(?, ?, ?)',
                    [$productId, $startDate, $endDate]
                );

                if (empty($specifications)) {
                    $message = "Er zijn geen leveringen voor dit product in deze periode";
                }
            } catch (\Exception $e) {
                return back()->withError('Er is een fout opgetreden: ' . $e->getMessage());
            }
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
