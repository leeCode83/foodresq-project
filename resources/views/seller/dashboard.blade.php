@extends('layouts.app')

@section('title', 'FoodResQ - Seller Dashboard')

@section('content')
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3 mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="#">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="#FFC107" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M2 17L12 22L22 17" stroke="#FFC107" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M2 12L12 17L22 12" stroke="#FFC107" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                <span class="text-white">Seller<span class="text-warning">Panel</span> ({{ $seller->email }})</span>
            </a>
            <div class="d-flex gap-3">
                <a href="{{ route('seller.foods.index') }}" class="btn btn-outline-light rounded-pill px-4">Manage Foods</a>
                <a href="{{ route('seller.food_form') }}" class="btn btn-warning rounded-pill fw-bold text-dark px-4">+ Add
                    New Food</a>
                <form action="{{ route('seller.logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light rounded-pill px-4">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container py-4">
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

        <!-- Stats Row -->
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 bg-white p-3">
                    <div class="card-body">
                        <p class="text-secondary fw-semibold mb-1">Total Orders</p>
                        <h2 class="fw-bold mb-0">{{ $totalOrders }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 bg-white p-3">
                    <div class="card-body">
                        <p class="text-secondary fw-semibold mb-1">Today's Earnings</p>
                        <h2 class="fw-bold text-success mb-0">${{ number_format($todaysEarnings, 2) }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 bg-white p-3">
                    <div class="card-body">
                        <p class="text-secondary fw-semibold mb-1">Pending Pickups</p>
                        <h2 class="fw-bold text-warning mb-0">{{ $pendingPickups }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Table -->
        <h4 class="fw-bold mb-4">Incoming Orders</h4>
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 py-3 ps-4">Order ID</th>
                            <th class="border-0 py-3">Customer</th>
                            <th class="border-0 py-3">Items</th>
                            <th class="border-0 py-3">Total</th>
                            <th class="border-0 py-3">Status</th>
                            <th class="border-0 py-3 pe-4 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                            <tr>
                                <td class="ps-4 fw-semibold">#{{ $transaction->order_number }}</td>
                                <td>{{ $transaction->buyer->name ?? 'Unknown' }}</td>
                                <td>{{ $transaction->food->title ?? 'Unknown' }} (x{{ $transaction->quantity }})</td>
                                <td class="fw-bold">${{ number_format($transaction->total_price, 2) }}</td>
                                <td>
                                    @if($transaction->status == 'PENDING')
                                        <span class="badge bg-warning text-dark rounded-pill px-3">Pending</span>
                                    @elseif($transaction->status == 'COMPLETED')
                                        <span class="badge bg-success text-white rounded-pill px-3">Completed</span>
                                    @else
                                        <span class="badge bg-secondary text-white rounded-pill px-3">{{ $transaction->status }}</span>
                                    @endif
                                </td>
                                <td class="pe-4 text-end">
                                    @if($transaction->status != 'COMPLETED' && $transaction->status != 'CANCELLED')
                                        <button class="btn btn-success btn-sm rounded-pill px-3 fw-bold" data-bs-toggle="modal"
                                            data-bs-target="#verifyModal">Verify Code</button>
                                    @else
                                        <button class="btn btn-light btn-sm rounded-pill px-3 border" disabled>Verified</button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-secondary">No orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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
                        <button type="submit" class="btn btn-success w-100 rounded-pill fw-bold py-3">Confirm
                            Pickup</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection