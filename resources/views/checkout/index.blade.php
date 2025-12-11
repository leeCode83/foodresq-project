@extends('layouts.app')

@section('title', 'FoodResQ - Checkout')

@section('content')
    <!-- Navbar -->
    @include('partials.navbar')

    <!-- Content -->
    <div class="container py-4">
        @if(session('cart') && count(session('cart')) > 0)
            <div class="row g-5">
                <!-- Order Summary -->
                <div class="col-lg-8">
                    <h4 class="fw-bold mb-4">Order Summary</h4>
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body p-4">
                            @php $total = 0; @endphp
                            @foreach(session('cart') as $id => $details)
                                @php $total += $details['price'] * $details['quantity']; @endphp
                                <div class="d-flex align-items-center gap-3 mb-4">
                                    <img src="{{ $details['image'] ?? 'https://placehold.co/100x100/orange/white?text=Food' }}"
                                        class="rounded-3" alt="Item" style="width: 100px; height: 100px; object-fit: cover;">
                                    <div class="flex-grow-1">
                                        <h6 class="fw-bold mb-1">{{ $details['title'] }}</h6>
                                        <p class="text-secondary small mb-0">Seller ID: {{ $details['seller_id'] }}</p>
                                    </div>
                                    <div class="text-end">
                                        <p class="fw-bold mb-0">${{ number_format($details['price'], 2) }}</p>
                                        <p class="text-secondary small mb-0">x{{ $details['quantity'] }}</p>
                                        <form action="{{ route('cart.remove') }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="id" value="{{ $id }}">
                                            <button type="submit"
                                                class="btn btn-link text-danger p-0 small text-decoration-none">Remove</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <h4 class="fw-bold mb-4">Payment Method</h4>
                    <form action="{{ route('transaction.store') }}" method="POST">
                        @csrf
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-body p-4">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="payment_method" id="paymentWallet"
                                        value="E_WALLET" checked>
                                    <label class="form-check-label fw-semibold" for="paymentWallet">
                                        E-Wallet (GoPay/OVO/Dana)
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="payment_method" id="paymentTransfer"
                                        value="TRANSFER">
                                    <label class="form-check-label fw-semibold" for="paymentTransfer">
                                        Bank Transfer
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" id="paymentCash"
                                        value="CASH">
                                    <label class="form-check-label fw-semibold" for="paymentCash">
                                        Cash on Pickup
                                    </label>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success w-100 rounded-pill py-3 fw-bold shadow-sm fs-5">Pay
                            ${{ number_format($total, 2) }}</button>
                    </form>
                </div>

                <!-- Total Sidebar -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">Total Details</h5>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-secondary">Subtotal</span>
                                <span class="fw-semibold">${{ number_format($total, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-4">
                                <span class="text-secondary">Platform Fee</span>
                                <span class="fw-semibold">$0.00</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-0">
                                <span class="fw-bold fs-5">Total</span>
                                <span class="fw-bold fs-5 text-success">${{ number_format($total, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <h3>Your cart is empty</h3>
                <a href="{{ route('food.index') }}" class="btn btn-primary mt-3">Browse Food</a>
            </div>
        @endif
    </div>
@endsection