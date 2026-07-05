@extends('layouts.public')

@section('title', 'Checkout — '.config('app.name'))

@section('content')
    <div class="koro-stagger">
        <p class="koro-eyebrow">Storefront</p>
        <h1 class="koro-heading-lg mt-2">Checkout</h1>
        <p class="koro-muted mt-2">Secure payment via Stripe. Keys are managed in Core → Integrations.</p>
    </div>

    <div class="mt-8 grid gap-8 lg:grid-cols-5">
        <form method="POST" action="{{ route('shop.checkout') }}" class="koro-card lg:col-span-3 space-y-5">
            @csrf
            <div>
                <label for="customer_name" class="mb-2 block text-sm font-medium text-white">Full name</label>
                <input id="customer_name" name="customer_name" type="text" required value="{{ $customerName }}"
                    class="w-full rounded-lg border border-white/10 bg-white/5 px-4 py-3 text-white placeholder:text-white/30 focus:border-koro-copper focus:outline-none">
                @error('customer_name')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="customer_email" class="mb-2 block text-sm font-medium text-white">Email</label>
                <input id="customer_email" name="customer_email" type="email" required value="{{ $customerEmail }}"
                    class="w-full rounded-lg border border-white/10 bg-white/5 px-4 py-3 text-white placeholder:text-white/30 focus:border-koro-copper focus:outline-none">
                @error('customer_email')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
            </div>
            <button type="submit" class="koro-btn w-full">Pay with Stripe</button>
        </form>

        <div class="koro-card lg:col-span-2">
            <h2 class="font-display text-lg font-semibold text-white">Order summary</h2>
            <ul class="mt-4 space-y-3">
                @foreach($cart->items as $item)
                    <li class="flex justify-between gap-3 text-sm">
                        <span class="text-white/80">{{ $item->product->name }} × {{ $item->quantity }}</span>
                        <span class="text-white">${{ number_format($item->quantity * $item->unit_price_cents / 100, 2) }}</span>
                    </li>
                @endforeach
            </ul>
            <div class="mt-4 border-t border-white/10 pt-4 flex justify-between">
                <span class="font-medium text-white">Total</span>
                <span class="koro-price">${{ number_format($cart->subtotalCents() / 100, 2) }}</span>
            </div>
        </div>
    </div>
@endsection
