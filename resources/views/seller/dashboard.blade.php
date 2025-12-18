@extends('layouts.app')

@section('title', 'FoodResQ - Seller Dashboard')

@section('content')
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light py-4">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="#">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="#4CAF50" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M2 17L12 22L22 17" stroke="#4CAF50" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M2 12L12 17L22 12" stroke="#4CAF50" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span class="h4 mb-0 fw-bold" style="color: #4CAF50;">FoodResQ Merchant</span>
            </a>
            <div class="d-flex align-items-center gap-4">
                <a href="{{ route('seller.foods.index') }}" class="text-decoration-none fw-bold text-secondary">Manage Food</a>
                <a href="{{ route('seller.food_form') }}" class="text-decoration-none fw-bold" style="color: #4CAF50;">+ Add New Food</a>
                <form action="{{ route('seller.logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-link text-decoration-none fw-bold text-secondary p-0">Logout</button>
                </form>
                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center border" style="width: 40px; height: 40px;">
                    <i class="bi bi-person-fill text-secondary fs-5"></i>
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container pb-5">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm border-0 mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm border-0 mb-4" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Stats Row -->
        <div class="row g-4 mb-5">
            <!-- Total Sales -->
            <div class="col-md-3">
                <div class="card border-0 shadow rounded-4 bg-white h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white" 
                                 style="width: 32px; height: 32px; background-color: #4CAF50;">
                                <i class="bi bi-currency-dollar"></i>
                            </div>
                            <h5 class="fw-bold mb-0">Total Sales</h5>
                        </div>
                        <h3 class="fw-bold mb-0">Rp {{ number_format($todaysEarnings * 15000, 2, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
            <!-- Item Sold -->
            <div class="col-md-3">
                <div class="card border-0 shadow rounded-4 bg-white h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white" 
                                 style="width: 32px; height: 32px; background-color: #4CAF50;">
                                <i class="bi bi-basket"></i>
                            </div>
                            <h5 class="fw-bold mb-0">Item Sold</h5>
                        </div>
                        <div class="d-flex align-items-baseline gap-2">
                            <h3 class="fw-bold mb-0">{{ $totalOrders }}</h3>
                            <span class="text-secondary small">Item(s)</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Total Customer -->
            <div class="col-md-3">
                <div class="card border-0 shadow rounded-4 bg-white h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white" 
                                 style="width: 32px; height: 32px; background-color: #4CAF50;">
                                <i class="bi bi-person"></i>
                            </div>
                            <h5 class="fw-bold mb-0">Total Customer</h5>
                        </div>
                        <div class="d-flex align-items-baseline gap-2">
                            <h3 class="fw-bold mb-0">{{ $transactions->unique('buyer_id')->count() }}</h3>
                            <span class="text-secondary small">Person(s)</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Rating -->
            <div class="col-md-3">
                <div class="card border-0 shadow rounded-4 bg-white h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white" 
                                 style="width: 32px; height: 32px; background-color: #4CAF50;">
                                <i class="bi bi-star"></i>
                            </div>
                            <h5 class="fw-bold mb-0">Rating</h5>
                        </div>
                        <h3 class="fw-bold mb-0">4.6/5.0</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="card border-0 shadow rounded-4 overflow-hidden bg-white">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle" style="border-collapse: separate; border-spacing: 0 10px;">
                        <thead>
                            <tr>
                                <th class="border-0 h5 fw-bold ps-0">Order Id</th>
                                <th class="border-0 h5 fw-bold">Customer</th>
                                <th class="border-0 h5 fw-bold">Items</th>
                                <th class="border-0 h5 fw-bold">Total</th>
                                <th class="border-0 h5 fw-bold">Status</th>
                                <th class="border-0 h5 fw-bold text-end pe-0">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $transaction)
                                <tr>
                                    <td class="border-bottom py-3 ps-0 fw-semibold">#ORD-{{ strtoupper(substr($transaction->id, 0, 8)) }}</td>
                                    <td class="border-bottom py-3">{{ $transaction->buyer->name ?? 'Unknown' }}</td>
                                    <td class="border-bottom py-3">{{ $transaction->food->title ?? 'Unknown' }} (x{{ $transaction->quantity }})</td>
                                    <td class="border-bottom py-3 fw-bold">${{ number_format($transaction->total_price, 2) }}</td>
                                    <td class="border-bottom py-3">
                                        @if($transaction->status == 'PENDING')
                                            <span class="badge rounded-pill px-3 py-2 text-dark" style="background-color: #FFD54F;">Pending</span>
                                        @elseif($transaction->status == 'COMPLETED')
                                            <span class="badge rounded-pill px-3 py-2" style="background-color: #98FB98; color: #1B5E20;">Completed</span>
                                        @else
                                            <span class="badge bg-secondary rounded-pill px-3 py-2">{{ $transaction->status }}</span>
                                        @endif
                                    </td>
                                    <td class="border-bottom py-3 text-end pe-0">
                                        @if($transaction->status != 'COMPLETED' && $transaction->status != 'CANCELLED')
                                            <button class="btn btn-sm rounded-pill px-4 fw-bold" 
                                                    style="background-color: #98FB98; color: #1B5E20; border: none;"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#verifyModal">Verify Code</button>
                                        @else
                                            <button class="btn btn-light btn-sm rounded-pill px-4 border" disabled>Verified</button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-secondary">No orders found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Verify Modal -->
    <div class="modal fade" id="verifyModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Verify Pickup Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-secondary mb-3">Ask the customer for their unique pickup code.</p>
                    <form action="{{ route('transaction.verify') }}" method="POST">
                        @csrf
                        <input type="text" name="pickup_code"
                            class="form-control form-control-lg text-center fw-bold letter-spacing-2 mb-4 bg-light border-0"
                            placeholder="XXX-XXX" required>
                        <button type="submit" class="btn w-100 rounded-pill fw-bold py-3 text-white" style="background-color: #4CAF50;">Confirm Pickup</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection