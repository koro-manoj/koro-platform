@extends('layouts.public')

@section('title', 'Checkout cancelled — '.config('app.name'))

@section('content')
    <div class="koro-card max-w-xl mx-auto text-center animate-fade-up">
        <p class="koro-eyebrow">Checkout</p>
        <h1 class="koro-heading-lg mt-2">Payment cancelled</h1>
        <p class="koro-muted mt-3">Invoice <strong class="text-white">{{ $invoice->number }}</strong> was not completed.</p>
        <a href="{{ route('shop.cart') }}" class="koro-btn koro-btn-sm mt-6 inline-flex">Return to cart</a>
    </div>
@endsection
