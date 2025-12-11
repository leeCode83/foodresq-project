@extends('layouts.app')

@section('title', 'FoodResQ - Browse Food')

@section('content')
    <!-- Navbar -->
    @include('partials.navbar')

    <!-- Categories -->
    <div class="container mt-4 mb-5">
        <div class="d-flex gap-3 overflow-auto pb-2 justify-content-lg-center">
            <a href="{{ route('food.index') }}"
                class="btn {{ request()->routeIs('food.index') ? 'btn-dark text-white' : 'btn-light bg-white text-dark' }} shadow-sm rounded-pill px-4 py-2 fw-semibold border-0">All</a>

            @foreach(['Bakery', 'Restaurant', 'Cafe', 'Grocery'] as $cat)
                <a href="{{ route('food.category', ['category' => strtoupper($cat)]) }}"
                    class="btn {{ request('category') == strtoupper($cat) ? 'btn-dark text-white' : 'btn-light text-secondary' }} rounded-pill px-4 py-2 fw-semibold border-0">
                    {{ $cat }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Menu Grid -->
    <div class="container mb-5">
        <div class="row g-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(empty($foods))
                <span>No foods available</span>
            @endif
            @foreach ($foods as $food)
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-4 p-3">
                        <img src="{{ $food->image_url ?? 'https://placehold.co/400x400/orange/white?text=Food' }}"
                            class="card-img-top rounded-circle shadow-sm mb-3" alt="{{ $food->title }}"
                            style="height: 250px; object-fit: cover;">
                        <div class="card-body p-0 d-flex flex-column">
                            <h5 class="card-title fw-bold mb-1">
                                <a href="{{ route('food.detail', $food->id) }}"
                                    class="text-decoration-none text-dark stretched-link">
                                    {{ $food->title }}
                                </a>
                            </h5>
                            <p class="card-text text-secondary small mb-3">{{ Str::limit($food->description, 50) }}</p>
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <div>
                                    @if($food->discount_percentage > 0)
                                        <small
                                            class="text-decoration-line-through text-muted">${{ number_format($food->original_price, 2) }}</small>
                                    @endif
                                    <span class="fw-bold fs-5 d-block">${{ number_format($food->discounted_price, 2) }}</span>
                                </div>
                                <a href="{{ route('cart.add', ['id' => $food->id]) }}"
                                    class="btn btn-warning rounded-pill px-3 py-1 fw-semibold d-flex align-items-center gap-1 position-relative z-2">
                                    <span>+</span> Add
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection