<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Geleverde Producten - {{ $leverancier->Naam }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            padding: 30px 20px;
            min-height: 100vh;
        }
        .container {
            max-width: 1100px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .nav-buttons {
            display: flex;
            gap: 12px;
            margin-bottom: 30px;
        }
        .btn-nav {
            display: inline-block;
            padding: 12px 24px;
            background: #f0f2f5;
            color: #2d3748;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s;
            font-weight: 600;
            border: 2px solid transparent;
        }
        .btn-nav:hover {
            background: #e2e8f0;
            border-color: #666;
        }
        h1 { color: #2d3748; margin-bottom: 10px; font-size: 1.8em; font-weight: 700; }
        .supplier-info {
            background: #f5f5f5;
            padding: 24px;
            border-radius: 8px;
            margin-bottom: 30px;
            border-left: 4px solid #999;
        }}}
        .supplier-info p {
            margin: 8px 0;
            color: #4a5568;
            font-weight: 500;
        }
        .supplier-info strong { color: #2d3748; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        thead {
            background: #4a90e2;
            color: white;
        }
        th {
            padding: 18px;
            text-align: left;
            font-weight: 600;
            font-size: 0.95em;
        }
        td {
            padding: 16px 18px;
            border-bottom: 1px solid #e2e8f0;
            color: #4a5568;
        }
        tbody tr:hover {
            background: #f7fafc;
        }
        .icon-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 24px;
            padding: 8px;
            transition: transform 0.2s;
        }
        .icon-btn:hover {
            transform: scale(1.3);
        }
        .no-products {
            background: #fffaed;
            color: #5a5a2e;
            padding: 30px;
            border-radius: 8px;
            text-align: center;
            font-size: 1.1em;
            font-weight: 600;
            border-left: 4px solid #999;
        }
        .success-message {
            background: linear-gradient(135deg, #c6f6d5 0%, #e6fffa 100%);
            color: #22543d;
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #48bb78;
            font-weight: 600;
        }
    </style>
    @if($noProducts)
    <script>
        setTimeout(function() {
            window.location.href = "{{ route('leveranciers.index') }}";
        }, 3000);
    </script>
    @endif
</head>
<body>
    <div class="container">
        <div class="nav-buttons">
            <a href="{{ route('leveranciers.details', $leverancier->id) }}" class="btn-nav">← Terug</a>
            <a href="{{ route('leveranciers.index') }}" class="btn-nav">Overzicht</a>
            <a href="{{ url('/') }}" class="btn-nav">Home</a>
        </div>
        
        <h1>📦 Geleverde Producten</h1>
        
        <div class="supplier-info">
            <p><strong>Naam leverancier:</strong> {{ $leverancier->Naam }}</p>
            <p><strong>Contactpersoon:</strong> {{ $leverancier->ContactPersoon }}</p>
            <p><strong>Leveranciernummer:</strong> {{ $leverancier->LeverancierNummer }}</p>
            <p><strong>Mobiel:</strong> {{ $leverancier->Mobiel }}</p>
        </div>

        @if(session('success'))
        <div class="success-message">
            ✓ {{ session('success') }}
        </div>
        @endif

        @if($noProducts)
        <div class="no-products">
            ⚠️ Dit bedrijf heeft tot nu toe geen producten geleverd aan Jamin
        </div>
        @else
        <table>
            <thead>
                <tr>
                    <th>Naam Product</th>
                    <th>Aantal in Magazijn</th>
                    <th>Verpakkingseenheid</th>
                    <th>Laatste Levering</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td><strong>{{ $product->NaamProduct }}</strong></td>
                    <td><span style="background: #f0f2f5; padding: 4px 12px; border-radius: 20px; font-weight: 600;">{{ $product->AantalInMagazijn }}</span></td>
                    <td>{{ $product->VerpakkingsEenheid }} kg</td>
                    <td>{{ \Carbon\Carbon::parse($product->LaatsteLevering)->format('d-m-Y') }}</td>
                    <td>
                        <a href="{{ route('producten.levering.form', [$leverancier->id, $product->id]) }}">
                            <button class="icon-btn" title="Nieuwe levering">➕</button>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</body>
</html>
