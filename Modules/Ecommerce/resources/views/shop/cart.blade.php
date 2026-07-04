@extends('layouts.public')

@section('title', 'Cart')

@section('content')
    <h1>Your cart</h1>
    @if($cart->items->isEmpty())
        <p class="muted">Cart is empty. <a href="{{ route('shop.index') }}">Continue shopping</a></p>
    @else
        <div class="grid" style="gap:.75rem; margin: 1rem 0;">
            @foreach($cart->items as $item)
                <div class="card" style="display:flex; justify-content:space-between;">
                    <div>
                        <strong>{{ $item->product->name }}</strong>
                        <p class="muted">Qty {{ $item->quantity }}</p>
                    </div>
                    <div>${{ number_format(($item->quantity * $item->unit_price_cents) / 100, 2) }}</div>
                </div>
            @endforeach
        </div>
        <p><strong>Subtotal:</strong> ${{ number_format($cart->subtotalCents() / 100, 2) }}</p>
        <form method="POST" action="{{ route('shop.checkout') }}" style="margin-top:1rem;">
            @csrf
            <button class="btn" type="submit">Checkout (demo)</button>
        </form>
    @endif
@endsection
