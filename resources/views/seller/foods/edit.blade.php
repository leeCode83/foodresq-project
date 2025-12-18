@extends('layouts.app')

@section('title', 'FoodResQ - Edit Food')

@section('content')
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light py-4">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('seller.dashboard') }}">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="#4CAF50" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M2 17L12 22L22 17" stroke="#4CAF50" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M2 12L12 17L22 12" stroke="#4CAF50" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span class="h4 mb-0 fw-bold" style="color: #4CAF50;">FoodResQ Merchant</span>
            </a>
            <div class="d-flex gap-3 align-items-center">
                <a href="{{ route('seller.foods.index') }}" class="text-decoration-none text-secondary fw-semibold">
                    <i class="bi bi-arrow-left me-1"></i> Back to List
                </a>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card border-0 shadow rounded-4 bg-white">
                    <div class="card-body p-4 p-md-5">
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white shadow-sm" 
                                 style="width: 48px; height: 48px; background-color: #4CAF50;">
                                <i class="bi bi-pencil-fill"></i>
                            </div>
                            <h4 class="fw-bold mb-0">Edit Food Item</h4>
                        </div>
                        
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                                <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('seller.foods.update', $food->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold small text-secondary">Food Title</label>
                                <input type="text" name="title" class="form-control bg-light border-0 rounded-3 py-3 px-3"
                                    value="{{ old('title', $food->title) }}" placeholder="e.g. Chicken Rice" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold small text-secondary">Description</label>
                                <textarea name="description" class="form-control bg-light border-0 rounded-3 py-3 px-3" rows="3"
                                    placeholder="Describe your delicious food..." required>{{ old('description', $food->description) }}</textarea>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-secondary">Category</label>
                                    <select name="category" class="form-select bg-light border-0 rounded-3 py-3 px-3" required>
                                        <option value="" disabled>Select...</option>
                                        @foreach(['RESTAURANT', 'BAKERY', 'CAFE', 'GROCERY', 'DESSERT', 'FAST_FOOD', 'OTHER'] as $cat)
                                            <option value="{{ $cat }}" {{ old('category', $food->category) == $cat ? 'selected' : '' }}>
                                                {{ ucfirst(strtolower(str_replace('_', ' ', $cat))) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-secondary">Quantity</label>
                                    <input type="number" name="quantity" class="form-control bg-light border-0 rounded-3 py-3 px-3"
                                        value="{{ old('quantity', $food->quantity) }}" required>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-secondary">Original Price (USD)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0 rounded-start-3 text-secondary">$</span>
                                        <input type="number" step="0.01" name="original_price"
                                            class="form-control bg-light border-0 rounded-end-3 py-3" 
                                            value="{{ old('original_price', $food->original_price) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-secondary">Discounted Price (USD)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0 rounded-start-3 text-secondary">$</span>
                                        <input type="number" step="0.01" name="discounted_price"
                                            class="form-control bg-light border-0 rounded-end-3 py-3" 
                                            value="{{ old('discounted_price', $food->discounted_price) }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold small text-secondary">Image URL</label>
                                <input type="url" name="image_url" class="form-control bg-light border-0 rounded-3 py-3 px-3"
                                    value="{{ old('image_url', $food->image_url) }}" placeholder="https://..." required>
                            </div>
                            
                            <div class="mb-4">
                                <div class="form-check form-switch p-0 d-flex align-items-center gap-2 rounded-3 bg-light px-3 py-3">
                                    <input class="form-check-input m-0" type="checkbox" role="switch" id="isActive" name="is_active" value="1" {{ old('is_active', $food->is_active) ? 'checked' : '' }} style="width: 3em; height: 1.5em;">
                                    <label class="form-check-label fw-bold text-dark ms-2" for="isActive">Available for Sale</label>
                                </div>
                            </div>

                            <!-- Hidden fields -->
                            <input type="hidden" name="discount_percentage" value="{{ $food->discount_percentage }}">
                            <input type="hidden" name="available_quantity" value="{{ $food->available_quantity }}">
                            <input type="hidden" name="pickup_time_start" value="{{ $food->pickup_time_start->format('Y-m-d H:i:s') }}">
                            <input type="hidden" name="pickup_time_end" value="{{ $food->pickup_time_end->format('Y-m-d H:i:s') }}">

                            <div class="d-flex gap-3 pt-2">
                                <a href="{{ route('seller.foods.index') }}"
                                    class="btn btn-light rounded-pill px-4 py-3 fw-bold text-secondary">Cancel</a>
                                <button type="submit"
                                    class="btn text-white rounded-pill px-4 py-3 fw-bold flex-grow-1 shadow-sm"
                                    style="background-color: #4CAF50;">
                                    <i class="bi bi-check-lg me-2"></i>Update Item
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
