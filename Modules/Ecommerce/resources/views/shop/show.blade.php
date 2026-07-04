@extends('layouts.public')

@section('title', $product->name.' — Shop')

@section('content')
    <nav class="koro-breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('shop.index') }}">Shop</a>
        <span aria-hidden="true">/</span>
        <span class="text-white">{{ $product->name }}</span>
    </nav>

    <article class="koro-card max-w-3xl animate-fade-up">
        <div class="mb-6 flex h-48 items-center justify-center rounded-2xl bg-gradient-to-br from-koro-copper/15 via-koro-panel to-koro-teal/10">
            <span class="font-display text-6xl font-bold text-koro-copper/30">{{ strtoupper(substr($product->name, 0, 1)) }}</span>
        </div>

        <p class="koro-eyebrow">SKU {{ $product->sku }}</p>
        <h1 class="koro-heading-lg mt-2">{{ $product->name }}</h1>

        @if($product->description)
            <p class="koro-muted mt-4 leading-relaxed">{{ $product->description }}</p>
        @endif

        <div class="mt-8 flex flex-col gap-4 border-t border-koro-border pt-6 sm:flex-row sm:items-center sm:justify-between">
            <span class="koro-price text-3xl">${{ number_format($product->price(), 2) }}</span>
            <form method="POST" action="{{ route('shop.cart.add', $product) }}">
                @csrf
                <button class="koro-btn" type="submit">Add to cart</button>
            </form>
        </div>
    </article>
@endsection
