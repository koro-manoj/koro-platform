@extends('layouts.public')

@section('title', 'Order confirmed — '.config('app.name'))

@section('content')
    <div class="koro-card max-w-xl mx-auto text-center animate-fade-up">
        <p class="koro-eyebrow">Thank you</p>
        <h1 class="koro-heading-lg mt-2">Payment received</h1>
        <p class="koro-muted mt-3">Invoice <strong class="text-white">{{ $invoice->number }}</strong> is marked paid.</p>
        @if($sandbox)
            <p class="mt-2 text-sm text-koro-copper">Sandbox mode — add live Stripe keys in Core → Integrations for real charges.</p>
        @endif
        <p class="mt-4 text-2xl font-display font-bold text-white">${{ number_format($invoice->amount_cents / 100, 2) }}</p>
        <a href="{{ route('shop.index') }}" class="koro-btn koro-btn-sm mt-6 inline-flex">Back to shop</a>
    </div>
@endsection
