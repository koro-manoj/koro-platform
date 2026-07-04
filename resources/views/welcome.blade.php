@extends('layouts.public')

@section('title', config('app.name').' — Modular Platform')

@section('content')
    <section style="padding: 3rem 0 4rem;">
        <p class="muted" style="text-transform: uppercase; letter-spacing: .12em; font-size: .8rem;">Laravel 11 · Modular · Production-ready</p>
        <h1 style="font-size: clamp(2.2rem, 5vw, 3.5rem); line-height: 1.05; margin: .75rem 0 1rem; max-width: 14ch;">One platform. Seven focused modules.</h1>
        <p style="max-width: 52ch; font-size: 1.1rem; opacity: .85; margin-bottom: 2rem;">
            Koro is a showcase modular monolith — Core auth & encrypted integrations, Payments, Ecommerce storefront, CRM, CMS, ERP, and a Sanctum REST API.
        </p>
        <div style="display:flex; gap:.75rem; flex-wrap:wrap;">
            <a class="btn" href="{{ route('shop.index') }}">Browse shop</a>
            <a class="btn btn-secondary" href="{{ url('/admin/core') }}">Open admin</a>
        </div>
    </section>

    <section class="grid grid-3" style="margin-bottom: 3rem;">
        @foreach([
            ['Core', 'Settings & encrypted API keys', '/admin/core'],
            ['Payments', 'Invoices & webhooks', '/admin/payments'],
            ['Ecommerce', 'Products & cart', '/shop'],
            ['CRM', 'Contacts & pipeline', '/admin/crm'],
            ['CMS', 'Pages & media', '/admin/cms'],
            ['ERP', 'Inventory & orders', '/admin/erp'],
            ['API', 'Sanctum REST', '/api/v1/products'],
        ] as [$name, $desc, $link])
            <a href="{{ url($link) }}" class="card" style="text-decoration:none; color:inherit;">
                <strong>{{ $name }}</strong>
                <p class="muted" style="margin:.5rem 0 0;">{{ $desc }}</p>
            </a>
        @endforeach
    </section>
@endsection
