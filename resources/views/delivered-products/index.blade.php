@extends('layouts.app')

@section('title', 'Overzicht Geleverde Producten')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Overzicht Geleverde Producten</h1>
    
    <!-- Date Range Filter Form -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Selecteer Periode</h5>
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
                        required
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
                        required
                    >
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Maak selectie</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Section -->
    @if($showResults)
        @if($message)
            <!-- Scenario 03: No deliveries found -->
            <div class="alert alert-info">
                {{ $message }}
            </div>
        @else
            <!-- Scenario 01: Display delivered products -->
            <div class="card">
                <div class="card-header">
                    <h5>Geleverde Producten ({{ $totalProducts }} totaal)</h5>
                </div>
                <div class="card-body">
                    @if(count($deliveredProducts) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Leverancier</th>
                                        <th>Product</th>
                                        <th>Barcode</th>
                                        <th>Totaal Geleverd</th>
                                        <th>Aantallevering</th>
                                        <th>Specificatie</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($deliveredProducts as $product)
                                        <tr>
                                            <td>{{ $product->LeverancierNaam }}</td>
                                            <td>{{ $product->ProductNaam }}</td>
                                            <td>{{ $product->Barcode }}</td>
                                            <td>{{ $product->TotalAantalGeleverd }}</td>
                                            <td>{{ $product->AantalLeveringen }}</td>
                                            <td>
                                                <a href="{{ route('delivered-products.specifications', ['productId' => $product->ProductId]) }}?start_date={{ $startDate }}&end_date={{ $endDate }}" 
                                                   class="btn btn-sm btn-info" 
                                                   title="Meer informatie">
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
                                            <a class="page-link" href="{{ route('delivered-products.index') }}?start_date={{ $startDate }}&end_date={{ $endDate }}&page=1">
                                                Eerste
                                            </a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="{{ route('delivered-products.index') }}?start_date={{ $startDate }}&end_date={{ $endDate }}&page={{ $currentPage - 1 }}">
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
                                                <a class="page-link" href="{{ route('delivered-products.index') }}?start_date={{ $startDate }}&end_date={{ $endDate }}&page={{ $i }}">
                                                    {{ $i }}
                                                </a>
                                            </li>
                                        @endif
                                    @endfor

                                    @if($currentPage < $totalPages)
                                        <li class="page-item">
                                            <a class="page-link" href="{{ route('delivered-products.index') }}?start_date={{ $startDate }}&end_date={{ $endDate }}&page={{ $currentPage + 1 }}">
                                                Volgende
                                            </a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="{{ route('delivered-products.index') }}?start_date={{ $startDate }}&end_date={{ $endDate }}&page={{ $totalPages }}">
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
        <div class="alert alert-secondary">
            Selecteer een periode om geleverde producten weer te geven.
        </div>
    @endif
</div>
@endsection
