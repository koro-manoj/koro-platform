@extends('layouts.public')

@section('title', 'Shop — '.config('app.name'))

@section('content')
    <div class="koro-stagger">
        <p class="koro-eyebrow">Storefront</p>
        <div class="mt-2 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <h1 class="koro-heading-lg">Shop</h1>
            <a href="{{ route('shop.cart') }}" class="koro-btn koro-btn-secondary koro-btn-sm">View cart</a>
        </div>
    </div>

    <div class="koro-product-grid mt-8">
        @forelse($products as $product)
            <article class="koro-card flex flex-col">
                <div class="mb-4 overflow-hidden rounded-xl bg-koro-slate">
                    @if($product->image_url)
                        <img src="{{ $product->image_url }}" alt="" class="h-40 w-full object-cover">
                    @else
                        <div class="flex h-40 items-center justify-center bg-gradient-to-br from-koro-copper/10 to-koro-teal/5">
                            <span class="font-display text-3xl font-bold text-koro-copper/40">{{ strtoupper(substr($product->name, 0, 1)) }}</span>
                        </div>
                    @endif
                </div>
                @if($product->badge)
                    <span class="mb-2 inline-block rounded-full bg-koro-copper/15 px-2.5 py-0.5 text-xs font-semibold text-koro-copper">{{ $product->badge }}</span>
                @endif
                <h3 class="font-display text-lg font-semibold text-white">{{ $product->name }}</h3>
                @if($product->description)
                    <p class="koro-muted mt-1.5 flex-1 text-sm leading-relaxed">{{ \Illuminate\Support\Str::limit($product->description, 90) }}</p>
                @endif
                <div class="mt-4 flex items-center justify-between gap-3 border-t border-koro-border pt-4">
                    <span class="koro-price">${{ number_format($product->price(), 2) }}</span>
                    <div class="flex gap-2">
                        <a class="koro-btn koro-btn-secondary koro-btn-sm" href="{{ route('shop.show', $product) }}">View</a>
                        <form method="POST" action="{{ route('shop.cart.add', $product) }}">
                            @csrf
                            <button class="koro-btn koro-btn-sm" type="submit">Add</button>
                        </form>
                    </div>
                </div>
            </article>
        @empty
            <div class="koro-card col-span-full text-center sm:col-span-2 lg:col-span-4">
                <p class="koro-muted">No products yet. Seed the database or add products in the Ecommerce admin.</p>
                <a href="{{ url('/admin/ecommerce') }}" class="koro-btn koro-btn-sm mt-4 inline-flex">Open Ecommerce admin</a>
            </div>
        @endforelse
    </div>

    @if($products->hasPages())
        <div class="mt-8 text-koro-mist [&_a]:text-koro-copper [&_span]:text-koro-mist">
            {{ $products->links() }}
        </div>
    @endif
@endsection
