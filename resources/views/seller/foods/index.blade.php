@extends('layouts.app')

@section('title', 'FoodResQ - My Foods')

@section('content')
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3 mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('seller.dashboard') }}">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="#FFC107" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M2 17L12 22L22 17" stroke="#FFC107" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M2 12L12 17L22 12" stroke="#FFC107" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                <span class="text-white">Seller<span class="text-warning">Panel</span></span>
            </a>
            <div class="d-flex gap-3">
                <a href="{{ route('seller.food_form') }}" class="btn btn-warning rounded-pill px-4 fw-bold">Add New Food</a>
                <a href="{{ route('seller.dashboard') }}" class="btn btn-outline-light rounded-pill px-4">Back to
                    Dashboard</a>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark">My Food Items</h2>
        </div>

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

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 py-3 ps-4">Item</th>
                            <th class="border-0 py-3">Category</th>
                            <th class="border-0 py-3">Price</th>
                            <th class="border-0 py-3">Qty</th>
                            <th class="border-0 py-3">Status</th>
                            <th class="border-0 py-3 text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($foods as $food)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ $food->image_url ?? 'https://placehold.co/100x100' }}"
                                            class="rounded-3 object-fit-cover" width="50" height="50" alt="{{ $food->title }}">
                                        <div>
                                            <h6 class="mb-0 fw-bold">{{ $food->title }}</h6>
                                            <small class="text-muted text-truncate d-block"
                                                style="max-width: 200px;">{{ $food->description }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-light text-secondary border">{{ $food->category }}</span></td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span
                                            class="fw-bold text-success">${{ number_format($food->discounted_price, 2) }}</span>
                                        <small
                                            class="text-decoration-line-through text-muted">${{ number_format($food->original_price, 2) }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-semibold {{ $food->available_quantity < 5 ? 'text-danger' : 'text-dark' }}">
                                        {{ $food->available_quantity }} / {{ $food->quantity }}
                                    </span>
                                </td>
                                <td>
                                    @if($food->available_quantity > 0)
                                        <span class="badge bg-success-subtle text-success rounded-pill px-3">Active</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3">Sold Out</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('seller.foods.edit', $food->id) }}"
                                            class="btn btn-sm btn-outline-primary rounded-pill px-3">Edit</a>
                                        <form action="{{ route('seller.foods.destroy', $food->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this item?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <div class="d-flex flex-column align-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                            class="bi bi-basket3 mb-3 opacity-25" viewBox="0 0 16 16">
                                            <path
                                                d="M5.757 1.071a.5.5 0 0 1 .172.686L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15.5a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H.5a.5.5 0 0 1-.5-.5v-1A.5.5 0 0 1 .5 6h1.717L5.07 1.243a.5.5 0 0 1 .686-.172zM3.394 15l-1.48-6h-.97l1.525 6.426a.75.75 0 0 0 .729.574h9.606a.75.75 0 0 0 .73-.574L15.056 9h-.972l-1.479 6h-9.21z" />
                                        </svg>
                                        <p class="mb-0">No food items listed yet.</p>
                                        <a href="{{ route('seller.food_form') }}"
                                            class="btn btn-link text-warning text-decoration-none fw-bold">Add your first
                                            item</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($foods->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    {{ $foods->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection