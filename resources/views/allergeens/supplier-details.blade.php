<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overzicht Leverancier Gegevens</title>
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
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
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
        h1 {
            color: #2d3748;
            margin-bottom: 10px;
            font-size: 2em;
        }
        .subtitle {
            color: #718096;
            margin-bottom: 30px;
            font-size: 0.95em;
        }
        .info-section {
            margin-bottom: 30px;
        }
        h2 {
            color: #2d3748;
            font-size: 1.3em;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #667eea;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        .info-item {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 4px;
            border-left: 4px solid #667eea;
        }
        .info-label {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 5px;
            font-size: 0.9em;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .info-value {
            color: #4a5568;
            font-size: 1.05em;
        }
        .warning-box {
            background: #fff5f5;
            border: 2px solid #fc8181;
            border-radius: 6px;
            padding: 20px;
            margin-top: 20px;
            color: #c53030;
        }
        .warning-icon {
            font-weight: bold;
            margin-right: 10px;
        }
        .full-width {
            grid-column: 1 / -1;
        }
        .allergen-info {
            background: #edf2f7;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .allergen-tags {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 10px;
        }
        .allergen-tag {
            background: #667eea;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 500;
        }
        .product-info {
            background: #f0fff4;
            border-left: 4px solid #48bb78;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('allergeens.index') }}" class="back-link">← Terug naar Overzicht</a>
        
        <h1>Overzicht Leverancier Gegevens</h1>
        <p class="subtitle">Gegevens van de leverancier voor product: <strong>{{ $product->Naam }}</strong></p>

        <!-- Product Info -->
        <div class="product-info">
            <strong>Product:</strong> {{ $product->Naam }} 
            (Barcode: {{ $product->Barcode }})
        </div>

        <!-- Allergen Info -->
        @if($product->allergeens->count() > 0)
            <div class="allergen-info">
                <strong>Bevat allergenen:</strong>
                <div class="allergen-tags">
                    @foreach($product->allergeens as $allergeen)
                        <span class="allergen-tag">{{ $allergeen->Naam }}</span>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Supplier Information Section -->
        <div class="info-section">
            <h2>Leverancier Gegevens</h2>
            
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Naam Leverancier</div>
                    <div class="info-value">{{ $supplier->Naam }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Contactpersoon</div>
                    <div class="info-value">{{ $supplier->ContactPersoon ?? '-' }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Mobiel</div>
                    <div class="info-value">{{ $supplier->Mobiel ?? '-' }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Leverancier Nummer</div>
                    <div class="info-value">{{ $supplier->LeverancierNummer }}</div>
                </div>
            </div>
        </div>

        <!-- Address Section -->
        @if($hasContactInfo && $supplier->contact)
            <div class="info-section">
                <h2>Adresgegevens</h2>
                
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Straat</div>
                        <div class="info-value">{{ $supplier->contact->Straat }}</div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Huisnummer</div>
                        <div class="info-value">{{ $supplier->contact->Huisnummer }}</div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Postcode</div>
                        <div class="info-value">{{ $supplier->contact->Postcode }}</div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Stad</div>
                        <div class="info-value">{{ $supplier->contact->Stad }}</div>
                    </div>
                </div>
            </div>
        @else
            <!-- Scenario 03: No address information -->
            <div class="warning-box">
                <span class="warning-icon">⚠️</span>
                <strong>Er zijn geen adresgegevens bekend</strong>
            </div>
        @endif
    </div>
</body>
</html>
