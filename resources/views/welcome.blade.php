<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>TSG</title>

        <style>
            body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #3D91C8, #573E82);
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            }
            .logo {
                max-width: 320px;
                margin-bottom: 10px;
                filter: brightness(0) invert(1);
            }
            .btn-container {
                display: flex;
                gap: 2px;
            }
            .btn {
                padding: 12px 24px;
                border: none;
                border-radius: none;
                font-size: 16px;
                cursor: pointer;
                background-color: #3949ab;
                color: white;
                text-decoration: none;
                transition: background 0.3s;
            }
            .btn:hover {
                background-color: #573E82;
            }
        </style>
    </head>
    <body>

        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">

        <div class="btn-container">
            <a href="https://tsgroup.com.ar" class="btn">website</a>
            <a href="{{ url('/api/documentation') }}" class="btn">documentation</a>
        </div>

    </body>
</html>
