<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wijzig Leveranciergegevens</title>
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
        .form-group {
            margin-bottom: 24px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2d3748;
            font-size: 0.95em;
        }
        input[type=text] {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1em;
            transition: all 0.3s;
            font-family: inherit;
        }
        input[type=text]:focus {
            outline: none;
            border-color: #4a90e2;
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
        }
        input[type=text]:disabled {
            background: #f7fafc;
            color: #718096;
            cursor: not-allowed;
        }
        .error {
            color: #e53e3e;
            font-size: 0.85em;
            margin-top: 6px;
            font-weight: 600;
        }
        .action-buttons {
            display: flex;
            gap: 12px;
            margin-top: 32px;
        }
        button {
            flex: 1;
            padding: 14px 28px;
            border-radius: 8px;
            font-size: 1em;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
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
        form { margin-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="nav-buttons">
            <a href="{{ route('leveranciers.details', request()->route('id')) }}" class="btn-nav">← Terug</a>
            <a href="{{ url('/') }}" class="btn-nav">Home</a>
        </div>
        
        <h1>✏️ Wijzig Leveranciergegevens</h1>
        
        <form method="POST" action="{{ route('leveranciers.update', request()->route('id')) }}">
            @csrf
            
            <div class="form-group">
                <label>Naam:</label>
                <input type="text" value="{{ $details->Naam }}" disabled>
            </div>
            
            <div class="form-group">
                <label>Contactpersoon:</label>
                <input type="text" value="{{ $details->ContactPersoon }}" disabled>
            </div>
            
            <div class="form-group">
                <label>Leveranciernummer:</label>
                <input type="text" value="{{ $details->LeverancierNummer }}" disabled>
            </div>
            
            <div class="form-group">
                <label for="mobiel">Mobiel: <span style="color: #e53e3e;">*</span></label>
                <input type="text" id="mobiel" name="Mobiel" value="{{ old('Mobiel', $details->Mobiel) }}" required>
                @error('Mobiel')<div class="error">{{ $message }}</div>@enderror
            </div>
            
            <div class="form-group">
                <label for="straat">Straatnaam: <span style="color: #e53e3e;">*</span></label>
                <input type="text" id="straat" name="Straat" value="{{ old('Straat', $details->Straat) }}" required>
                @error('Straat')<div class="error">{{ $message }}</div>@enderror
            </div>
            
            <div class="form-group">
                <label>Huisnummer:</label>
                <input type="text" value="{{ $details->Huisnummer }}" disabled>
            </div>
            
            <div class="form-group">
                <label>Postcode:</label>
                <input type="text" value="{{ $details->Postcode }}" disabled>
            </div>
            
            <div class="form-group">
                <label>Stad:</label>
                <input type="text" value="{{ $details->Stad }}" disabled>
            </div>
            
            <div class="action-buttons">
                <button type="submit" class="btn-primary">💾 Sla Op</button>
            </div>
        </form>
    </div>
</body>
</html>
