<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Koro Platform — modular Laravel monolith with Core, Payments, Ecommerce, CRM, CMS, ERP, and REST API.">
    <title>@yield('title', config('app.name'))</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=syne:600,700,800|dm-sans:400,500,600,700" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="koro-shell">
        <div class="koro-container">
            <header class="koro-nav animate-fade-in">
                <a href="{{ url('/') }}" class="koro-brand">
                    Koro<span>.</span>
                </a>
                <nav class="koro-nav-links" aria-label="Main">
                    <a href="{{ url('/') }}" @class(['koro-nav-link', 'is-active' => request()->is('/')])>Home</a>
                    <a href="{{ route('shop.index') }}" @class(['koro-nav-link', 'is-active' => request()->is('shop*')])>Shop</a>
                    <a href="{{ route('shop.cart') }}" @class(['koro-nav-link', 'is-active' => request()->routeIs('shop.cart')])>Cart</a>
                    <a href="{{ route('cms.page', 'about') }}" @class(['koro-nav-link', 'is-active' => request()->is('pages/*')])>About</a>
                    <a href="{{ url('/admin/core') }}" class="koro-btn koro-btn-sm ml-1 hidden sm:inline-flex">Admin</a>
                </nav>
            </header>

            @if(session('success'))
                <div class="koro-flash" role="status">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="koro-flash koro-flash-error" role="alert">{{ session('error') }}</div>
            @endif

            @if($errors->any())
                <div class="koro-flash koro-flash-error" role="alert">{{ $errors->first() }}</div>
            @endif

            <main>
                @yield('content')
            </main>

            <footer class="koro-footer">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Modular Laravel showcase.</p>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ url('/admin/core') }}" class="transition hover:text-koro-copper">Core</a>
                        <a href="{{ url('/admin/payments') }}" class="transition hover:text-koro-copper">Payments</a>
                        <a href="{{ url('/admin/ecommerce') }}" class="transition hover:text-koro-copper">Ecommerce</a>
                        <a href="{{ url('/admin/crm') }}" class="transition hover:text-koro-copper">CRM</a>
                        <a href="{{ url('/admin/cms') }}" class="transition hover:text-koro-copper">CMS</a>
                        <a href="{{ url('/admin/erp') }}" class="transition hover:text-koro-copper">ERP</a>
                        <a href="{{ url('/api/v1/products') }}" class="transition hover:text-koro-copper">API</a>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</body>
</html>
