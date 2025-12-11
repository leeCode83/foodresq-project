@extends('layouts.app')

@section('title', 'FoodResQ - My Orders')

@section('content')
    <!-- Navbar -->
    @include('partials.navbar')

    <!-- Content -->
    <div class="container py-4">
        <h3 class="fw-bold mb-4">My Orders</h3>

        <div class="row g-4">
            @forelse($transactions as $transaction)
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden {{ $transaction->status == 'PENDING' || $transaction->status == 'READY_FOR_PICKUP' ? 'border-start border-5 border-warning' : '' }}">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        @if($transaction->status == 'PENDING')
                                            <span class="badge bg-warning text-dark rounded-pill px-3">Pending</span>
                                        @elseif($transaction->status == 'COMPLETED')
                                            <span class="badge bg-success text-white rounded-pill px-3">Completed</span>
                                        @elseif($transaction->status == 'CANCELLED')
                                            <span class="badge bg-danger text-white rounded-pill px-3">Cancelled</span>
                                        @else
                                            <span class="badge bg-secondary text-white rounded-pill px-3">{{ $transaction->status }}</span>
                                        @endif
                                        <span class="text-secondary small">Order #{{ $transaction->order_number }}</span>
                                    </div>
                                    <h5 class="fw-bold mb-1">{{ $transaction->food->title ?? 'Unknown Item' }}</h5>
                                    <p class="text-secondary mb-3">{{ $transaction->quantity }} Items • ${{ number_format($transaction->total_price, 2) }}</p>
                                    <div class="d-flex gap-2">
                                        <img src="{{ $transaction->food->image_url ?? 'https://placehold.co/60x60/orange/white?text=Food' }}" class="rounded-3"
                                            alt="Item" style="width: 60px; height: 60px; object-fit: cover;">
                                    </div>
                                </div>
                                <div class="col-md-4 text-md-end mt-4 mt-md-0">
                                    @if($transaction->status != 'COMPLETED' && $transaction->status != 'CANCELLED')
                                        <p class="text-secondary small mb-1">Show this code to seller</p>
                                        <h2 class="display-6 fw-bold text-dark letter-spacing-2 mb-0">{{ $transaction->pickup_code }}</h2>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="lead text-secondary">You haven't placed any orders yet.</p>
                    <a href="{{ route('food.index') }}" class="btn btn-primary rounded-pill">Browse Food</a>
                </div>
            @endforelse
        </div>
    </div>
@endsection