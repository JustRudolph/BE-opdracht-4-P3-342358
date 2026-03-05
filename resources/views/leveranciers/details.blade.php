<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leverancier Details</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            padding: 30px 20px;
            min-height: 100vh;
        }
        .container { 
            max-width: 700px;
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
            font-size: 0.95em;
        }
        .btn-nav:hover {
            background: #e2e8f0;
            border-color: #666;
        }
        h1 { 
            color: #2d3748;
            margin-bottom: 30px;
            font-size: 1.8em;
            font-weight: 700;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th {
            padding: 14px;
            text-align: left;
            background: #f7fafc;
            border-bottom: 2px solid #e2e8f0;
            font-weight: 700;
            color: #2d3748;
            width: 35%;
        }
        td {
            padding: 14px;
            border-bottom: 1px solid #e2e8f0;
            color: #4a5568;
        }
        tbody tr:hover {
            background: #f7fafc;
        }
        .feedback {
            margin-bottom: 20px;
            padding: 16px;
            border-radius: 8px;
            font-weight: 600;
            animation: slideIn 0.3s ease;
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .success { 
            background: #c6f6d5;
            color: #22543d;
            border: 2px solid #9ae6b4;
        }
        .error { 
            background: #fed7d7;
            color: #742a2a;
            border: 2px solid #fc8181;
        }
        .action-buttons {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
        .btn {
            display: inline-block;
            padding: 14px 28px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            font-size: 1em;
            text-align: center;
            flex: 1;
            min-width: 160px;
        }
        .btn-primary {
            background: #4a90e2;
            color: white;
            box-shadow: 0 4px 15px rgba(74, 144, 226, 0.4);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(74, 144, 226, 0.6);
        }
        .btn-secondary {
            background: #f0f2f5;
            color: #2d3748;
            border: 2px solid #e2e8f0;
        }
        .btn-secondary:hover {
            background: #e2e8f0;
            border-color: #333;
        }
    </style>
    @if(session('feedback_message'))
    <script>
        setTimeout(function(){
            window.location.href = "{{ route('leveranciers.details', request()->route('id')) }}";
        }, 3000);
    </script>
    @endif
</head>
<body>
    <div class="container">
        <div class="nav-buttons">
            <a href="{{ route('leveranciers.index') }}" class="btn-nav">← Terug</a>
            <a href="{{ url('/') }}" class="btn-nav">Home</a>
        </div>

        <h1>👤 Leverancier Details</h1>

        @if(session('feedback_message'))
            <div class="feedback {{ session('feedback_success') ? 'success' : 'error' }}">
                {{ session('feedback_message') }}
            </div>
        @endif

        <table>
            <tbody>
                <tr><th>Naam</th><td>{{ $details->Naam }}</td></tr>
                <tr><th>Contactpersoon</th><td>{{ $details->ContactPersoon }}</td></tr>
                <tr><th>Leveranciernummer</th><td>{{ $details->LeverancierNummer }}</td></tr>
                <tr><th>Mobiel</th><td>{{ $details->Mobiel }}</td></tr>
                <tr><th>Straatnaam</th><td>{{ $details->Straat }}</td></tr>
                <tr><th>Huisnummer</th><td>{{ $details->Huisnummer }}</td></tr>
                <tr><th>Postcode</th><td>{{ $details->Postcode }}</td></tr>
                <tr><th>Stad</th><td>{{ $details->Stad }}</td></tr>
            </tbody>
        </table>

        <div class="action-buttons">
            <a href="{{ route('leveranciers.edit', request()->route('id')) }}" class="btn btn-primary">✏️ Wijzig</a>
            <a href="{{ route('leveranciers.products', request()->route('id')) }}" class="btn btn-secondary">📦 Producten</a>
        </div>
    </div>
</body>
</html>
