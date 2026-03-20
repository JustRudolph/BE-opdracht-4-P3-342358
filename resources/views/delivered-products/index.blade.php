<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overzicht Geleverde Producten</title>
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
        .btn-info {
            background-color: #0dcaf0;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        .btn-info:hover {
            background-color: #0dbbdd;
        }
    </style>
</head>
<body>
@php
    $baseQuery = [];
    if (!empty($startDate)) {
        $baseQuery['start_date'] = $startDate;
    }
    if (!empty($endDate)) {
        $baseQuery['end_date'] = $endDate;
    }
@endphp
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Overzicht Geleverde Producten</h1>
        <a href="{{ url('/') }}" class="btn btn-secondary">← Home</a>
    </div>
    
    <!-- Date Range Filter Form -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Filter op Periode (Optioneel)</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('delivered-products.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="start_date" class="form-label">Startdatum</label>
                    <input 
                        type="date" 
                        class="form-control" 
                        id="start_date" 
                        name="start_date" 
                        value="{{ $startDate ?? '' }}"
                    >
                </div>
                <div class="col-md-4">
                    <label for="end_date" class="form-label">Einddatum</label>
                    <input 
                        type="date" 
                        class="form-control" 
                        id="end_date" 
                        name="end_date" 
                        value="{{ $endDate ?? '' }}"
                    >
                </div>
                <div class="col-md-4 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1">Filter</button>
                    <a href="{{ route('delivered-products.index') }}" class="btn btn-secondary">Wissen</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Section -->
    @if($message)
        <!-- No deliveries found message -->
        <div class="alert alert-info">
            {{ $message }}
        </div>
    @else
        <!-- Display delivered products -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    Geleverde Producten ({{ $totalProducts }} totaal)
                    @if($startDate && $endDate)
                        <small class="text-muted">van {{ $startDate }} tot {{ $endDate }}</small>
                    @else
                        <small class="text-muted">alle beschikbare productgegevens</small>
                    @endif
                </h5>
            </div>
            <div class="card-body">
                @if(count($deliveredProducts) > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Naam Leverancier</th>
                                    <th>Contact person</th>
                                    <th>Product naam</th>
                                    <th>Totaal geleverd</th>
                                    <th>Specificatie</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($deliveredProducts as $product)
                                    <tr>
                                        <td>{{ $product->LeverancierNaam }}</td>
                                        <td>{{ $product->ContactPersoon }}</td>
                                        <td>{{ $product->ProductNaam }}</td>
                                        <td>{{ $product->TotalAantalGeleverd }}</td>
                                        <td>
                                            <a href="{{ route('delivered-products.specifications', array_merge(['productId' => $product->ProductId], $baseQuery)) }}"
                                               class="btn btn-info btn-sm" 
                                               title="Details">
                                                ?
                                            </a>
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
                                        <a class="page-link" href="{{ route('delivered-products.index', array_merge($baseQuery, ['page' => 1])) }}">
                                            Eerste
                                        </a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="{{ route('delivered-products.index', array_merge($baseQuery, ['page' => $currentPage - 1])) }}">
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
                                            <a class="page-link" href="{{ route('delivered-products.index', array_merge($baseQuery, ['page' => $i])) }}">
                                                {{ $i }}
                                            </a>
                                        </li>
                                    @endif
                                @endfor

                                @if($currentPage < $totalPages)
                                    <li class="page-item">
                                        <a class="page-link" href="{{ route('delivered-products.index', array_merge($baseQuery, ['page' => $currentPage + 1])) }}">
                                            Volgende
                                        </a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="{{ route('delivered-products.index', array_merge($baseQuery, ['page' => $totalPages])) }}">
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
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
