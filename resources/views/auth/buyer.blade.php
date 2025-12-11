@extends('layouts.app')

@section('title', 'FoodResQ - Buyer Auth')

@section('content')
    <!-- Navbar -->
    <nav class="navbar navbar-light bg-white shadow-sm py-3 mb-5">
        <div class="container">
            <a class="navbar-brand fw-bold text-success d-flex align-items-center gap-2"
                href="{{ route('landing.index') }}">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                FoodResQ
            </a>
            <span class="text-secondary fw-semibold">Buyer Area</span>
        </div>
    </nav>

    <!-- Auth Container -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                        <ul class="nav nav-tabs card-header-tabs border-0" id="authTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button
                                    class="nav-link active fw-bold text-success border-0 border-bottom border-success border-3 bg-transparent"
                                    id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button"
                                    role="tab">Login</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-semibold text-secondary border-0 bg-transparent"
                                    id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button"
                                    role="tab">Register</button>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body p-4">
                        <div class="tab-content" id="authTabsContent">

                            <!-- Login Form -->
                            <div class="tab-pane fade show active" id="login" role="tabpanel">
                                <form action="{{ route('buyer.login.submit') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold text-secondary small">Email Address</label>
                                        <input type="email" name="email" class="form-control bg-light border-0 py-2"
                                            placeholder="name@example.com" required>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label fw-semibold text-secondary small">Password</label>
                                        <input type="password" name="password" class="form-control bg-light border-0 py-2"
                                            placeholder="••••••••" required>
                                        <a href="{{ route('landing.index') }}"
                                            class="text-decoration-none text-secondary small fw-semibold">← Back to Home</a>
                                    </div>
                                    <button type="submit"
                                        class="btn btn-success w-100 rounded-pill py-2 fw-bold shadow-sm">Login</button>
                                </form>
                            </div>

                            <!-- Register Form -->
                            <div class="tab-pane fade" id="register" role="tabpanel">
                                <form action="{{ route('buyer.register.submit') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold text-secondary small">Full Name</label>
                                        <input type="text" name="name" class="form-control bg-light border-0 py-2"
                                            placeholder="John Doe" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold text-secondary small">Email Address</label>
                                        <input type="email" name="email" class="form-control bg-light border-0 py-2"
                                            placeholder="name@example.com" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold text-secondary small">Password</label>
                                        <input type="password" name="password" class="form-control bg-light border-0 py-2"
                                            placeholder="••••••••" required>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label fw-semibold text-secondary small">Phone Number</label>
                                        <input type="tel" name="phone" class="form-control bg-light border-0 py-2"
                                            placeholder="0812..." required>
                                    </div>
                                    <button type="submit"
                                        class="btn btn-warning text-white w-100 rounded-pill py-2 fw-bold shadow-sm">Register</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const loginTab = document.getElementById('login-tab');
            const registerTab = document.getElementById('register-tab');

            const activeClasses = ['fw-bold', 'text-success', 'border-bottom', 'border-success', 'border-3'];
            const inactiveClasses = ['fw-semibold', 'text-secondary'];

            function updateTabs(activeTab, inactiveTab) {
                activeTab.classList.add(...activeClasses);
                activeTab.classList.remove(...inactiveClasses);

                inactiveTab.classList.remove(...activeClasses);
                inactiveTab.classList.add(...inactiveClasses);
            }

            loginTab.addEventListener('shown.bs.tab', () => updateTabs(loginTab, registerTab));
            registerTab.addEventListener('shown.bs.tab', () => updateTabs(registerTab, loginTab));
        });
    </script>
@endpush