@extends('layouts.app')

@section('title', 'FoodResQ - My Foods')

@section('content')
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light py-4">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('seller.dashboard') }}">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="#4CAF50" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M2 17L12 22L22 17" stroke="#4CAF50" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M2 12L12 17L22 12" stroke="#4CAF50" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                <span class="h4 mb-0 fw-bold" style="color: #4CAF50;">FoodResQ Merchant</span>
            </a>
            <div class="d-flex gap-3 align-items-center">
                <a href="{{ route('seller.dashboard') }}"
                    class="text-decoration-none text-secondary fw-semibold">Dashboard</a>
                <a href="{{ route('seller.food_form') }}" class="btn text-white rounded-pill px-4 fw-bold shadow-sm"
                    style="background-color: #4CAF50;">
                    <i class="bi bi-plus-lg me-2"></i>Add New Food
                </a>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">My Food Items</h2>
                <p class="text-secondary mb-0">Manage your listed food items</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card border-0 shadow rounded-4 overflow-hidden bg-white">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle"
                        style="border-collapse: separate; border-spacing: 0 10px;">
                        <thead>
                            <tr>
                                <th class="border-0 h6 fw-bold ps-4 text-secondary">Item Details</th>
                                <th class="border-0 h6 fw-bold text-secondary">Category</th>
                                <th class="border-0 h6 fw-bold text-secondary">Price</th>
                                <th class="border-0 h6 fw-bold text-secondary">Stock</th>
                                <th class="border-0 h6 fw-bold text-secondary">Status</th>
                                <th class="border-0 h6 fw-bold text-end pe-4 text-secondary">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($foods as $food)
                                <tr>
                                    <td class="border-bottom py-3 ps-4">
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="{{ $food->image_url ?? 'https://placehold.co/100x100' }}"
                                                class="rounded-4 object-fit-cover shadow-sm" width="60" height="60"
                                                alt="{{ $food->title }}">
                                            <div>
                                                <h6 class="mb-1 fw-bold text-dark">{{ $food->title }}</h6>
                                                <small class="text-muted text-truncate d-block" style="max-width: 200px;">
                                                    {{ $food->description }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="border-bottom py-3">
                                        <span class="badge bg-light text-dark border rounded-pill px-3 py-2 fw-semibold">
                                            {{ ucfirst(strtolower(str_replace('_', ' ', $food->category))) }}
                                        </span>
                                    </td>
                                    <td class="border-bottom py-3">
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-success">Rp
                                                {{ number_format($food->discounted_price * 15000, 0, ',', '.') }}</span>
                                            <small class="text-decoration-line-through text-muted" style="font-size: 0.8rem;">
                                                Rp {{ number_format($food->original_price * 15000, 0, ',', '.') }}
                                            </small>
                                        </div>
                                    </td>
                                    <td class="border-bottom py-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="progress" style="height: 6px; width: 60px;">
                                                <div class="progress-bar {{ $food->available_quantity < 5 ? 'bg-danger' : 'bg-success' }}"
                                                    role="progressbar"
                                                    style="width: {{ ($food->available_quantity / max($food->quantity, 1)) * 100 }}%">
                                                </div>
                                            </div>
                                            <span
                                                class="fw-semibold small {{ $food->available_quantity < 5 ? 'text-danger' : 'text-dark' }}">
                                                {{ $food->available_quantity }}/{{ $food->quantity }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="border-bottom py-3">
                                        @if($food->available_quantity > 0)
                                            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">Active</span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-2">Sold
                                                Out</span>
                                        @endif
                                    </td>
                                    <td class="border-bottom py-3 text-end pe-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('seller.foods.edit', $food->id) }}"
                                                class="btn btn-light text-primary rounded-circle p-2" data-bs-toggle="tooltip"
                                                title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="{{ route('seller.foods.destroy', $food->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this item?');"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-light text-danger rounded-circle p-2"
                                                    data-bs-toggle="tooltip" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="d-flex flex-column align-items-center justify-content-center py-5">
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mb-3"
                                                style="width: 80px; height: 80px;">
                                                <i class="bi bi-basket3 text-secondary fs-1"></i>
                                            </div>
                                            <h5 class="fw-bold text-secondary mb-2">No items found</h5>
                                            <p class="text-muted mb-4">You haven't listed any food items yet.</p>
                                            <a href="{{ route('seller.food_form') }}"
                                                class="btn btn-warning rounded-pill px-4 fw-bold shadow-sm">
                                                Add Your First Item
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($foods->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    {{ $foods->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection