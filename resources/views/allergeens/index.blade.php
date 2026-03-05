<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overzicht Allergenen</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .header {
            margin-bottom: 30px;
        }
        h1 {
            color: #2d3748;
            margin-bottom: 10px;
            font-size: 2em;
        }
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }
        .back-link:hover {
            color: #5568d3;
        }
        .filter-section {
            background: #f9f9f9;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 30px;
            border: 1px solid #e0e0e0;
        }
        .filter-group {
            display: flex;
            gap: 15px;
            align-items: flex-end;
            flex-wrap: wrap;
        }
        label {
            display: block;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 5px;
            font-size: 0.95em;
        }
        select {
            padding: 10px 15px;
            border: 1px solid #cbd5e0;
            border-radius: 4px;
            font-size: 1em;
            background-color: white;
            cursor: pointer;
            min-width: 250px;
        }
        select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        button {
            padding: 10px 30px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 4px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 1em;
        }
        button:hover {
            background: #5568d3;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
        .table-container {
            overflow-x: auto;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.95em;
        }
        thead {
            background: #667eea;
            color: white;
        }
        th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            border: 1px solid #667eea;
        }
        td {
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            border-right: 1px solid #e0e0e0;
        }
        tbody tr:nth-child(even) {
            background: #f9f9f9;
        }
        tbody tr:hover {
            background: #f0f0f0;
        }
        .info-link {
            display: inline-block;
            width: 24px;
            height: 24px;
            background: #667eea;
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 24px;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 0.9em;
        }
        .info-link:hover {
            background: #5568d3;
            transform: scale(1.1);
        }
        .no-results {
            text-align: center;
            padding: 40px;
            color: #718096;
            background: #f9f9f9;
            border-radius: 8px;
            margin: 20px 0;
        }
        .pagination {
            display: flex;
            justify-content: center;
            gap: 5px;
            margin-top: 20px;
            flex-wrap: wrap;
        }
        .pagination a,
        .pagination span {
            padding: 8px 12px;
            border: 1px solid #cbd5e0;
            border-radius: 4px;
            text-decoration: none;
            color: #667eea;
            transition: all 0.3s;
        }
        .pagination a:hover {
            background: #667eea;
            color: white;
        }
        .pagination span.active {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }
        .pagination span:not(a) {
            color: #cbd5e0;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="/" class="back-link">← Terug naar home</a>
        
        <div class="header">
            <h1>Overzicht Allergenen</h1>
            <p style="color: #718096; margin-top: 5px;">Bekijk producten met allergenen en contactgegevens van leveranciers</p>
        </div>

        <div class="filter-section">
            <form method="GET" action="{{ route('allergeens.index') }}" style="display: contents;">
                <div class="filter-group">
                    <div>
                        <label for="allergen_id">Allergeen:</label>
                        <select name="allergen_id" id="allergen_id">
                            <option value="">-- Alle allergenen --</option>
                            @foreach($allergeens as $allergeen)
                                <option value="{{ $allergeen->id }}" 
                                    {{ $selectedAllergeenId == $allergeen->id ? 'selected' : '' }}>
                                    {{ $allergeen->Naam }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit">Maak selectie</button>
                </div>
            </form>
        </div>

        @if($products->count() > 0)
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Naam Product</th>
                            <th>Naam Allergeen</th>
                            <th>Omschrijving</th>
                            <th>Aantal Aanwezis</th>
                            <th>Info</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            @foreach($product->allergeens as $allergeen)
                                <tr>
                                    <td>{{ $product->Naam }}</td>
                                    <td>{{ $allergeen->Naam }}</td>
                                    <td>{{ $allergeen->Omschrijving ?? '-' }}</td>
                                    <td>
                                        @php
                                            $magazijn = $product->magazijn;
                                        @endphp
                                        {{ $magazijn ? $magazijn->AantalAanwezig : 'N/A' }}
                                    </td>
                                    <td>
                                        <a href="{{ route('allergeens.supplier-details', $product->id) }}" 
                                           class="info-link" 
                                           title="Leverancier informatie">?</a>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                {{ $products->links() }}
            </div>
        @else
            <div class="no-results">
                <p>Geen producten met allergenen gevonden.</p>
            </div>
        @endif
    </div>
</body>
</html>
