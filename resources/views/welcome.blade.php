@extends('layouts.public')

@section('title', config('app.name').' — Modular Platform')

@section('content')
    <section class="pb-12 pt-4 sm:pb-16 sm:pt-8">
        <div class="koro-stagger">
            <p class="koro-eyebrow">Laravel 11 · Modular · Production-ready</p>
            <h1 class="koro-heading-xl mt-4 max-w-[14ch]">One platform.<br>Seven focused modules.</h1>
            <p class="koro-lead mt-5 mb-8">
                Koro is a showcase modular monolith — Core auth and encrypted integrations, Payments, Ecommerce storefront, CRM, CMS, ERP, and a Sanctum REST API.
            </p>
            <div class="flex flex-wrap gap-3">
                <a class="koro-btn" href="{{ route('shop.index') }}">Browse shop</a>
                <a class="koro-btn koro-btn-secondary" href="{{ url('/admin/core') }}">Open admin</a>
            </div>
        </div>
    </section>

    <div class="koro-divider"></div>

    <section class="pb-16">
        <div class="mb-8 flex items-end justify-between gap-4">
            <div>
                <p class="koro-eyebrow">Architecture</p>
                <h2 class="koro-heading-lg mt-2">Module map</h2>
            </div>
            <span class="koro-badge hidden sm:inline-flex">nWidart modules</span>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 koro-stagger">
            @foreach([
                ['Core', 'Settings & encrypted API keys', '/admin/core', '⚙'],
                ['Payments', 'Invoices & webhooks', '/admin/payments', '◈'],
                ['Ecommerce', 'Products & cart', '/shop', '▣'],
                ['CRM', 'Contacts & pipeline', '/admin/crm', '◎'],
                ['CMS', 'Pages & media', '/admin/cms', '▤'],
                ['ERP', 'Inventory & orders', '/admin/erp', '▥'],
                ['API', 'Sanctum REST', '/api/v1/products', '⬡'],
            ] as [$name, $desc, $link, $icon])
                <a href="{{ url($link) }}" class="koro-card-interactive group">
                    <div class="koro-module-icon">{{ $icon }}</div>
                    <strong class="font-display text-lg text-white group-hover:text-koro-copper transition">{{ $name }}</strong>
                    <p class="koro-muted mt-1.5 text-sm">{{ $desc }}</p>
                </a>
            @endforeach
        </div>
    </section>

    <section class="koro-card mb-8 bg-gradient-to-br from-koro-panel to-koro-slate/50">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="koro-eyebrow">Security model</p>
                <h2 class="mt-2 font-display text-xl font-bold text-white">API keys live in the database</h2>
                <p class="koro-muted mt-2 max-w-xl text-sm leading-relaxed">
                    Integration credentials are encrypted with Laravel's cast and stored via the Core module. Only <code class="rounded bg-white/5 px-1.5 py-0.5 text-koro-teal">APP_KEY</code> and database connection settings belong in <code class="rounded bg-white/5 px-1.5 py-0.5 text-koro-teal">.env</code>.
                </p>
            </div>
            <a href="{{ route('cms.page', 'about') }}" class="koro-btn koro-btn-secondary shrink-0">Read about Koro</a>
        </div>
    </section>
@endsection
