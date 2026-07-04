<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root { --koro-bg: #0b1020; --koro-card: #121933; --koro-accent: #7c6cff; --koro-text: #eef2ff; }
        body { font-family: 'Instrument Sans', system-ui, sans-serif; background: radial-gradient(circle at top, #1a2454, var(--koro-bg)); color: var(--koro-text); min-height: 100vh; }
        .container { max-width: 1120px; margin: 0 auto; padding: 1.5rem; }
        .nav { display: flex; justify-content: space-between; align-items: center; padding: 1rem 0 2rem; }
        .nav a { color: var(--koro-text); text-decoration: none; opacity: .85; margin-left: 1rem; }
        .nav a:hover { opacity: 1; color: #fff; }
        .brand { font-weight: 700; font-size: 1.25rem; letter-spacing: -.02em; }
        .card { background: color-mix(in srgb, var(--koro-card) 90%, white 5%); border: 1px solid rgba(255,255,255,.08); border-radius: 1rem; padding: 1.25rem; }
        .btn { display: inline-flex; align-items: center; gap: .5rem; background: var(--koro-accent); color: white; border: 0; border-radius: .75rem; padding: .75rem 1rem; font-weight: 600; text-decoration: none; cursor: pointer; }
        .btn-secondary { background: transparent; border: 1px solid rgba(255,255,255,.2); }
        .grid { display: grid; gap: 1rem; }
        @media (min-width: 768px) { .grid-3 { grid-template-columns: repeat(3, 1fr); } .grid-4 { grid-template-columns: repeat(4, 1fr); } }
        .muted { opacity: .7; }
        .flash { background: #163d2f; border: 1px solid #2f855a; padding: .75rem 1rem; border-radius: .75rem; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <div class="container">
        <header class="nav">
            <div class="brand">{{ config('app.name') }}</div>
            <nav>
                <a href="{{ url('/') }}">Home</a>
                <a href="{{ route('shop.index') }}">Shop</a>
                <a href="{{ route('shop.cart') }}">Cart</a>
                <a href="{{ url('/admin/core') }}">Admin</a>
            </nav>
        </header>
        @if(session('success'))
            <div class="flash">{{ session('success') }}</div>
        @endif
        @yield('content')
    </div>
</body>
</html>
