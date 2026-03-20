<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jamin - Home</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            background: white;
            padding: 50px 40px;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 600px;
            width: 100%;
        }
        h1 {
            color: #2d3748;
            margin-bottom: 40px;
            text-align: center;
            font-size: 2.5em;
            font-weight: 700;
        }
        .links {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        a {
            display: block;
            padding: 16px 28px;
            background: #888888;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            text-align: center;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            border: none;
            cursor: pointer;
            font-size: 1.1em;
        }
        a:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🏢 Jamin Manager</h1>
        <div class="links">
            <a href="{{ route('delivered-products.index') }}">Overzicht Geleverde Producten</a>
            <a href="{{ route('allergeens.index') }}">Overzicht Allergenen</a>
            <a href="{{ route('leveranciers.index') }}">Wijzigen Leveranciers</a>
        </div>
    </div>
</body>
</html>
