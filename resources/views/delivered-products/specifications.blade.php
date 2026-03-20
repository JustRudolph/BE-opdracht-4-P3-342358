@extends('layouts.app')

@section('title', 'Specificatie Geleverde Producten')

@section('content')
<div class="container mt-5">
    <a href="{{ route('delivered-products.index') }}?start_date={{ $startDate }}&end_date={{ $endDate }}" class="btn btn-secondary mb-3">
        &larr; Terug naar Overzicht
    </a>

    @if($product)
        <h1 class="mb-4">Specificatie Geleverde Producten</h1>
        
        <div class="card mb-4">
            <div class="card-header">
                <h5>Product Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Product Naam:</strong> {{ $product->Naam }}</p>
                        <p><strong>Barcode:</strong> {{ $product->Barcode }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Periode:</strong> {{ $startDate }} tot {{ $endDate }}</p>
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
                    <h5>Leveringsgegevens</h5>
                </div>
                <div class="card-body">
                    @if(count($specifications) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Leverancier</th>
                                        <th>Contactpersoon</th>
                                        <th>Leveringsdatum</th>
                                        <th>Aantal Geleverd</th>
                                        <th>Volgende Levering Datum</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($specifications as $spec)
                                        <tr>
                                            <td>{{ $spec->LeverancierNaam }}</td>
                                            <td>{{ $spec->ContactPersoon }}</td>
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
                                            <a class="page-link" href="{{ route('delivered-products.specifications', ['productId' => $product->id]) }}?start_date={{ $startDate }}&end_date={{ $endDate }}&page=1">
                                                Eerste
                                            </a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="{{ route('delivered-products.specifications', ['productId' => $product->id]) }}?start_date={{ $startDate }}&end_date={{ $endDate }}&page={{ $currentPage - 1 }}">
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
                                                <a class="page-link" href="{{ route('delivered-products.specifications', ['productId' => $product->id]) }}?start_date={{ $startDate }}&end_date={{ $endDate }}&page={{ $i }}">
                                                    {{ $i }}
                                                </a>
                                            </li>
                                        @endif
                                    @endfor

                                    @if($currentPage < $totalPages)
                                        <li class="page-item">
                                            <a class="page-link" href="{{ route('delivered-products.specifications', ['productId' => $product->id]) }}?start_date={{ $startDate }}&end_date={{ $endDate }}&page={{ $currentPage + 1 }}">
                                                Volgende
                                            </a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="{{ route('delivered-products.specifications', ['productId' => $product->id]) }}?start_date={{ $startDate }}&end_date={{ $endDate }}&page={{ $totalPages }}">
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
@endsection
