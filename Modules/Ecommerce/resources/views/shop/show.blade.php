@extends('layouts.public')

@section('title', $product->name)

@section('content')
    <article class="card" style="max-width: 720px;">
        <h1 style="margin-top:0;">{{ $product->name }}</h1>
        <p class="muted">{{ $product->sku }}</p>
        <p style="line-height:1.6;">{{ $product->description }}</p>
        <div style="display:flex; justify-content:space-between; align-items:center; margin-top:1.5rem;">
            <strong style="font-size:1.5rem;">${{ number_format($product->price(), 2) }}</strong>
            <form method="POST" action="{{ route('shop.cart.add', $product) }}">
                @csrf
                <button class="btn" type="submit">Add to cart</button>
            </form>
        </div>
    </article>
@endsection
