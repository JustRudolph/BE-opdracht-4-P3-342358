<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Levering Product - {{ $product->Naam }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            margin-bottom: 10px;
        }
        .info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        input:focus {
            outline: none;
            border-color: #007bff;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-right: 10px;
            border: none;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #5a6268;
        }
        .btn-primary {
            background-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }
        .buttons {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }
    </style>
    @if(isset($error))
    <script>
        setTimeout(function() {
            window.location.href = "{{ route('leveranciers.products', $leverancier->id) }}";
        }, 4000);
    </script>
    @endif
</head>
<body>
    <div class="container">
        <h1>Levering Product</h1>
        
        <div class="info">
            <p><strong>Product:</strong> {{ $product->Naam }}</p>
            <p><strong>Leverancier:</strong> {{ $leverancier->Naam }}</p>
            <p><strong>Contactpersoon:</strong> {{ $leverancier->ContactPersoon }}</p>
        </div>

        @if(isset($error))
        <div class="error-message">
            {{ $error }}
        </div>
        @endif

        <form action="{{ route('producten.levering.store', [$leverancier->id, $product->id]) }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="aantal_producteenheden">Aantal producteenheden</label>
                <input type="number" id="aantal_producteenheden" name="aantal_producteenheden" min="1" required>
            </div>
            
            <div class="form-group">
                <label for="datum_eerstvolgende_levering">Datum eerstvolgende levering</label>
                <input type="date" id="datum_eerstvolgende_levering" name="datum_eerstvolgende_levering" required>
            </div>
            
            <div class="buttons">
                <button type="submit" class="btn btn-primary">Sla op</button>
                <a href="{{ route('leveranciers.products', $leverancier->id) }}" class="btn">Terug</a>
                <a href="{{ url('/') }}" class="btn">Home</a>
            </div>
        </form>
    </div>
</body>
</html>
