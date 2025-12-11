@extends('layouts.app')

@section('title', 'FoodResQ - Food Detail')

@section('content')
    <!-- Navbar -->
    @include('partials.navbar')

    <!-- Content -->
    <div class="container py-4">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('food.index') }}"
                        class="text-decoration-none text-success">Browse</a></li>
                <li class="breadcrumb-item"><a href="#"
                        class="text-decoration-none text-success">{{ ucfirst(strtolower($food->category)) }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $food->title }}</li>
            </ol>
        </nav>

        <div class="row g-5">
            <!-- Image Column -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <img src="{{ $food->image_url ?? 'https://placehold.co/800x600/orange/white?text=Food' }}"
                        class="img-fluid w-100" alt="{{ $food->title }}" style="height: 400px; object-fit: cover;">
                </div>
            </div>

            <!-- Info Column -->
            <div class="col-lg-6 d-flex flex-column justify-content-center">
                <div class="mb-2">
                    <span
                        class="badge bg-warning text-dark rounded-pill px-3 py-1 fw-bold mb-2">{{ str_replace('_', ' ', $food->category) }}</span>
                    <h1 class="display-5 fw-bold text-dark mb-1">{{ $food->title }}</h1>
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <p class="text-success fw-semibold mb-0">by <a href="#"
                                class="text-decoration-none text-success">{{ $food->seller->business_name ?? 'Seller #' . $food->seller_id }}</a>
                        </p>
                        <span class="text-secondary">•</span>
                        <span class="text-secondary">{{ $food->quantity - $food->available_quantity }} sold</span>
                    </div>
                </div>

                <div class="mb-4">
                    @if($food->discount_percentage > 0)
                        <span
                            class="text-decoration-line-through text-muted fs-4 me-2">${{ number_format($food->original_price, 2) }}</span>
                    @endif
                    <span class="display-6 fw-bold text-dark">${{ number_format($food->discounted_price, 2) }}</span>
                </div>

                <p class="lead text-secondary mb-5">
                    {{ $food->description }}
                </p>

                <div class="d-flex gap-3 mt-auto">
                    <a href="{{ route('cart.add', ['id' => $food->id]) }}"
                        class="btn btn-warning text-dark fw-bold rounded-pill px-5 py-3 flex-grow-1 shadow-sm">Add to
                        Order</a>
                </div>
            </div>
        </div>
    </div>
@endsection