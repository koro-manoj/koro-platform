@extends('layouts.public')

@section('title', 'Shop — '.config('app.name'))

@section('content')
    <h1 style="margin-bottom: 1rem;">Shop</h1>
    <div class="grid grid-4">
        @forelse($products as $product)
            <article class="card">
                <h3 style="margin:0 0 .5rem;">{{ $product->name }}</h3>
                <p class="muted" style="margin:0 0 1rem;">{{ $product->description ? \Illuminate\Support\Str::limit($product->description, 80) : '' }}</p>
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <strong>${{ number_format($product->price(), 2) }}</strong>
                    <div style="display:flex; gap:.5rem;">
                        <a class="btn btn-secondary" href="{{ route('shop.show', $product) }}">View</a>
                        <form method="POST" action="{{ route('shop.cart.add', $product) }}">
                            @csrf
                            <button class="btn" type="submit">Add</button>
                        </form>
                    </div>
                </div>
            </article>
        @empty
            <p class="muted">No products yet. Seed the database or add products in the Ecommerce admin.</p>
        @endforelse
    </div>
    <div style="margin-top: 1.5rem;">{{ $products->links() }}</div>
@endsection
