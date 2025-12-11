@extends('layouts.app')

@section('title', 'FoodResQ - Edit Food')

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
            <a href="{{ route('seller.foods.index') }}" class="btn btn-outline-light rounded-pill px-4">Back to List</a>
        </div>
    </nav>

    <!-- Content -->
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h4 class="fw-bold mb-4">Edit Food Item</h4>
                        
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('seller.foods.update', $food->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-secondary small">Food Title</label>
                                <input type="text" name="title" class="form-control bg-light border-0 py-2"
                                    value="{{ old('title', $food->title) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-secondary small">Description</label>
                                <textarea name="description" class="form-control bg-light border-0 py-2" rows="3"
                                    required>{{ old('description', $food->description) }}</textarea>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-secondary small">Category</label>
                                    <select name="category" class="form-select bg-light border-0 py-2" required>
                                        <option value="" disabled>Select...</option>
                                        @foreach(['RESTAURANT', 'BAKERY', 'CAFE', 'GROCERY', 'DESSERT', 'FAST_FOOD', 'OTHER'] as $cat)
                                            <option value="{{ $cat }}" {{ old('category', $food->category) == $cat ? 'selected' : '' }}>
                                                {{ ucfirst(strtolower(str_replace('_', ' ', $cat))) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-secondary small">Quantity</label>
                                    <input type="number" name="quantity" class="form-control bg-light border-0 py-2"
                                        value="{{ old('quantity', $food->quantity) }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-secondary small">Original Price</label>
                                    <input type="number" step="0.01" name="original_price"
                                        class="form-control bg-light border-0 py-2" 
                                        value="{{ old('original_price', $food->original_price) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-secondary small">Discounted Price</label>
                                    <input type="number" step="0.01" name="discounted_price"
                                        class="form-control bg-light border-0 py-2" 
                                        value="{{ old('discounted_price', $food->discounted_price) }}" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold text-secondary small">Image URL</label>
                                <input type="url" name="image_url" class="form-control bg-light border-0 py-2"
                                    value="{{ old('image_url', $food->image_url) }}" required>
                            </div>
                            
                            <div class="mb-4 form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="isActive" name="is_active" value="1" {{ old('is_active', $food->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold text-secondary small" for="isActive">Available for Sale</label>
                            </div>

                            <!-- Hidden fields to maintain structure if not editable here -->
                            <input type="hidden" name="discount_percentage" value="{{ $food->discount_percentage }}">
                            <input type="hidden" name="available_quantity" value="{{ $food->available_quantity }}"> <!-- Should ideally be editable or calculated -->
                            <input type="hidden" name="pickup_time_start" value="{{ $food->pickup_time_start->format('Y-m-d H:i:s') }}">
                            <input type="hidden" name="pickup_time_end" value="{{ $food->pickup_time_end->format('Y-m-d H:i:s') }}">

                            <div class="d-flex gap-3">
                                <a href="{{ route('seller.foods.index') }}"
                                    class="btn btn-light rounded-pill px-4 py-3 fw-bold border">Cancel</a>
                                <button type="submit"
                                    class="btn btn-warning rounded-pill px-4 py-3 fw-bold flex-grow-1 shadow-sm">Update Item</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
