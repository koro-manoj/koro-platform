@extends('layouts.public')

@section('title', 'Cart — '.config('app.name'))

@section('content')
    <div class="koro-stagger">
        <p class="koro-eyebrow">Ecommerce module</p>
        <h1 class="koro-heading-lg mt-2">Your cart</h1>
    </div>

    @if($cart->items->isEmpty())
        <div class="koro-card mt-8 text-center animate-fade-up">
            <p class="koro-muted">Your cart is empty.</p>
            <a href="{{ route('shop.index') }}" class="koro-btn koro-btn-sm mt-4 inline-flex">Continue shopping</a>
        </div>
    @else
        <div class="mt-8 space-y-3">
            @foreach($cart->items as $item)
                <div class="koro-cart-row">
                    <div>
                        <strong class="font-display text-white">{{ $item->product->name }}</strong>
                        <p class="koro-muted mt-1 text-sm">Qty {{ $item->quantity }} · ${{ number_format($item->unit_price_cents / 100, 2) }} each</p>
                    </div>
                    <span class="koro-price">${{ number_format(($item->quantity * $item->unit_price_cents) / 100, 2) }}</span>
                </div>
            @endforeach
        </div>

        <div class="koro-card mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="koro-muted text-sm">Subtotal</p>
                <p class="font-display text-2xl font-bold text-white">${{ number_format($cart->subtotalCents() / 100, 2) }}</p>
            </div>
            <form method="POST" action="{{ route('shop.checkout') }}">
                @csrf
                <button class="koro-btn" type="submit">Checkout (demo)</button>
            </form>
        </div>
    @endif
@endsection
