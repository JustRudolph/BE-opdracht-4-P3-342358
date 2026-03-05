<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overzicht Leveranciers - Jamin</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            padding: 30px 20px;
            min-height: 100vh;
        }
        .container {
            max-width: 1200px;
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
        h1 {
            color: #2d3748;
            margin-bottom: 30px;
            font-size: 2em;
            font-weight: 700;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
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
        tbody tr {
            transition: background-color 0.2s;
        }
        tbody tr:hover {
            background-color: #f7fafc;
        }
        .icon-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 24px;
            padding: 8px;
            transition: transform 0.2s;
            display: inline-block;
        }
        .icon-btn:hover {
            transform: scale(1.3);
        }
        .pagination {
            display: flex;
            gap: 8px;
            justify-content: center;
            margin-top: 30px;
            flex-wrap: wrap;
            align-items: center;
        }
        .pagination a, .pagination span {
            padding: 10px 14px;
            border-radius: 6px;
            text-decoration: none;
            color: #333;
            background: #f0f2f5;
            border: 1px solid #e2e8f0;
            transition: all 0.3s;
            font-weight: 600;
            white-space: nowrap;
            text-align: center;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .pagination .disabled {
            opacity: 0.5;
            cursor: not-allowed;
            background: #e2e8f0;
        }

        .pagination .active span {
            background: #4a90e2;
            color: white;
            border-color: #4a90e2;
        }
        .pagination a:hover {
            background: #4a90e2;
            color: white;
            border-color: #4a90e2;
        }
        .pagination span.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="nav-buttons">
            <a href="{{ url('/') }}" class="btn-nav">← Home</a>
        </div>
        
        <h1>📦 Overzicht Leveranciers</h1>
        
        <table>
            <thead>
                <tr>
                    <th>Naam</th>
                    <th>Contactpersoon</th>
                    <th>Leveranciernummer</th>
                    <th>Mobiel</th>
                    <th>Producten</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                @foreach($leveranciers as $leverancier)
                <tr>
                    <td><strong>{{ $leverancier->Naam }}</strong></td>
                    <td>{{ $leverancier->ContactPersoon }}</td>
                    <td>{{ $leverancier->LeverancierNummer }}</td>
                    <td>{{ $leverancier->Mobiel }}</td>
                    <td><span style="background: #f0f2f5; padding: 4px 12px; border-radius: 20px; font-weight: 600; color: #667eea;">{{ $leverancier->AantalVerschillendeProducten }}</span></td>
                    <td>
                        <a href="{{ route('leveranciers.details', $leverancier->id) }}">
                            <button class="icon-btn" title="Details">✏️</button>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pagination">
            {{ $leveranciers->links() }}
        </div>
    </div>
</body>
</html>
