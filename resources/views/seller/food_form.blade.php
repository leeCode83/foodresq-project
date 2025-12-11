@extends('layouts.app')

@section('title', 'FoodResQ - Manage Food')

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
            <a href="{{ route('seller.dashboard') }}" class="btn btn-outline-light rounded-pill px-4">Back to Dashboard</a>
        </div>
    </nav>

    <!-- Content -->
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h4 class="fw-bold mb-4">Add New Food Item</h4>
                        <form action="{{ route('food.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-secondary small">Food Title</label>
                                <input type="text" name="title" class="form-control bg-light border-0 py-2"
                                    placeholder="e.g. Chicken Parm" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-secondary small">Description</label>
                                <textarea name="description" class="form-control bg-light border-0 py-2" rows="3"
                                    placeholder="Describe the food..." required></textarea>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-secondary small">Category</label>
                                    <select name="category" class="form-select bg-light border-0 py-2" required>
                                        <option value="" selected disabled>Select...</option>
                                        <option value="RESTAURANT">Restaurant</option>
                                        <option value="BAKERY">Bakery</option>
                                        <option value="CAFE">Cafe</option>
                                        <option value="GROCERY">Grocery</option>
                                        <option value="DESSERT">Dessert</option>
                                        <option value="FAST_FOOD">Fast Food</option>
                                        <option value="OTHER">Other</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-secondary small">Quantity</label>
                                    <input type="number" name="quantity" class="form-control bg-light border-0 py-2"
                                        placeholder="10" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-secondary small">Original Price</label>
                                    <input type="number" step="0.01" name="original_price"
                                        class="form-control bg-light border-0 py-2" placeholder="15.00" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-secondary small">Discounted Price</label>
                                    <input type="number" step="0.01" name="discounted_price"
                                        class="form-control bg-light border-0 py-2" placeholder="8.99" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold text-secondary small">Image URL</label>
                                <input type="url" name="image_url" class="form-control bg-light border-0 py-2"
                                    placeholder="https://..." required>
                            </div>

                            <!-- Hidden fields for required backend data -->
                            <input type="hidden" name="seller_id" value="{{ Auth::guard('seller')->id() }}">
                            <input type="hidden" name="discount_percentage" value="40">
                            <input type="hidden" name="available_quantity" value="10">
                            <input type="hidden" name="pickup_time_start" value="{{ now()->format('Y-m-d H:i:s') }}">
                            <input type="hidden" name="pickup_time_end"
                                value="{{ now()->addHours(5)->format('Y-m-d H:i:s') }}">

                            <div class="d-flex gap-3">
                                <a href="{{ route('seller.dashboard') }}"
                                    class="btn btn-light rounded-pill px-4 py-3 fw-bold border">Cancel</a>
                                <button type="submit"
                                    class="btn btn-warning rounded-pill px-4 py-3 fw-bold flex-grow-1 shadow-sm">Save
                                    Item</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection