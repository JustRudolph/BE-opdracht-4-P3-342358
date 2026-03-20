<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Specificatie Geleverde Producten</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
            padding: 20px 0;
        }
        .container {
            background-color: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #007bff;
            color: white;
            border: none;
        }
    </style>
</head>
<body>
@php
    $baseQuery = [];
    if (!empty($startDate) && !empty($endDate)) {
        $baseQuery = ['start_date' => $startDate, 'end_date' => $endDate];
    }
@endphp
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Specificatie Geleverde Producten</h1>
        <a href="{{ route('delivered-products.index', $baseQuery) }}" class="btn btn-secondary">
            &larr; Terug
        </a>
    </div>

    @if($product)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Product Informatie</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Product Naam:</strong> {{ $product->Naam }}</p>
                        <p><strong>Barcode:</strong> {{ $product->Barcode }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Periode:</strong> 
                            @if($startDate && $endDate)
                                {{ $startDate }} tot {{ $endDate }}
                            @else
                                Alle beschikbare gegevens
                            @endif
                        </p>
                        <p><strong>Totaal Leveringen:</strong> {{ $totalSpecifications }}</p>
                    </div>
                </div>
            </div>
        </div>

        @if($message)
            <!-- No deliveries found for this product in the date range -->
            <div class="alert alert-info">
                {{ $message }}
            </div>
        @else
            <!-- Scenario 02: Display delivery specifications -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Leveringsgegevens</h5>
                </div>
                <div class="card-body">
                    @if(count($specifications) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Leverancier</th>
                                        <th>Adres</th>
                                        <th>Leveringsdatum</th>
                                        <th>Aantal Geleverd</th>
                                        <th>Volgende Levering</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($specifications as $spec)
                                        <tr>
                                            <td>{{ $spec->LeverancierNaam }}</td>
                                            <td>
                                                @if($spec->Straat)
                                                    {{ $spec->Straat }} {{ $spec->Huisnummer }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>{{ date('d-m-Y', strtotime($spec->DatumLevering)) }}</td>
                                            <td>{{ $spec->Aantal }}</td>
                                            <td>
                                                @if($spec->DatumEerstVolgendeLevering)
                                                    {{ date('d-m-Y', strtotime($spec->DatumEerstVolgendeLevering)) }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($totalPages > 1)
                            <nav aria-label="Page navigation" class="mt-4">
                                <ul class="pagination justify-content-center">
                                    @if($currentPage > 1)
                                        <li class="page-item">
                                            <a class="page-link" href="{{ route('delivered-products.specifications', array_merge(['productId' => $product->id, 'page' => 1], $baseQuery)) }}">
                                                Eerste
                                            </a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="{{ route('delivered-products.specifications', array_merge(['productId' => $product->id, 'page' => $currentPage - 1], $baseQuery)) }}">
                                                Vorige
                                            </a>
                                        </li>
                                    @endif

                                    @for($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++)
                                        @if($i == $currentPage)
                                            <li class="page-item active">
                                                <span class="page-link">{{ $i }}</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ route('delivered-products.specifications', array_merge(['productId' => $product->id, 'page' => $i], $baseQuery)) }}">
                                                    {{ $i }}
                                                </a>
                                            </li>
                                        @endif
                                    @endfor

                                    @if($currentPage < $totalPages)
                                        <li class="page-item">
                                            <a class="page-link" href="{{ route('delivered-products.specifications', array_merge(['productId' => $product->id, 'page' => $currentPage + 1], $baseQuery)) }}">
                                                Volgende
                                            </a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="{{ route('delivered-products.specifications', array_merge(['productId' => $product->id, 'page' => $totalPages], $baseQuery)) }}">
                                                Laatste
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        @endif
                    @else
                        <p class="text-center text-muted">Geen gegevens beschikbaar</p>
                    @endif
                </div>
            </div>
        @endif
    @else
        <div class="alert alert-danger">
            Product niet gevonden.
        </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
