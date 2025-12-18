@extends('layouts.app')

@section('title', 'FoodResQ - Buyer Auth')

@section('content')
    <div class="container-fluid min-vh-100 d-flex align-items-center p-0 overflow-hidden bg-white">
        <div class="row w-100 m-0 min-vh-100">
            <!-- Left Side: Form -->
            <div class="col-lg-6 d-flex flex-column justify-content-center px-5 py-5 position-relative">
                <!-- Back Button -->
                <a href="{{ route('landing.index') }}"
                    class="position-absolute top-0 start-0 m-4 text-dark text-decoration-none">
                    <div class="border border-dark rounded-2 d-flex align-items-center justify-content-center"
                        style="width: 40px; height: 40px;">
                        <i class="bi bi-chevron-left fs-5"></i>
                    </div>
                </a>

                <div class="w-100 mx-auto" style="max-width: 500px;">
                    <!-- Tabs -->
                    <ul class="nav nav-pills mb-4 gap-3" id="authTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active rounded-pill px-4 fw-bold" id="login-tab" data-bs-toggle="tab"
                                data-bs-target="#login" type="button" role="tab"
                                style="background-color: #FFC107; color: #000;">Login</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link rounded-pill px-4 fw-bold text-secondary bg-light" id="register-tab"
                                data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab">Register</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="authTabsContent">
                        <!-- Login Form -->
                        <div class="tab-pane fade show active" id="login" role="tabpanel">
                            <h1 class="fw-bold mb-4 display-5">Welcome Back</h1>
                            <form action="{{ route('buyer.login.submit') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="form-label fw-bold small">Email Address</label>
                                    <input type="email" name="email"
                                        class="form-control bg-light border-0 rounded-3 py-3 px-3"
                                        placeholder="name@example.com" required>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label fw-bold small">Password</label>
                                    <input type="password" name="password"
                                        class="form-control bg-light border-0 rounded-3 py-3 px-3" placeholder="••••••••"
                                        required>
                                </div>
                                <button type="submit" class="btn w-100 rounded-3 py-3 fw-bold shadow-sm"
                                    style="background-color: #FFC107; color: #000;">Login</button>
                            </form>
                        </div>

                        <!-- Register Form -->
                        <div class="tab-pane fade" id="register" role="tabpanel">
                            <h1 class="fw-bold mb-4 display-5">Create Account</h1>
                            <form action="{{ route('buyer.register.submit') }}" method="POST">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold small">Full Name</label>
                                        <input type="text" name="name"
                                            class="form-control bg-light border-0 rounded-3 py-3 px-3"
                                            placeholder="John Doe" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold small">Email Address</label>
                                        <input type="email" name="email"
                                            class="form-control bg-light border-0 rounded-3 py-3 px-3"
                                            placeholder="name@example.com" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small">Password</label>
                                        <input type="password" name="password"
                                            class="form-control bg-light border-0 rounded-3 py-3 px-3"
                                            placeholder="••••••••" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small">Phone Number</label>
                                        <input type="tel" name="phone"
                                            class="form-control bg-light border-0 rounded-3 py-3 px-3" placeholder="0812..."
                                            required>
                                    </div>
                                </div>
                                <div class="form-check mt-4 mb-4">
                                    <input class="form-check-input" type="checkbox" value="" id="termsCheck" required>
                                    <label class="form-check-label small text-secondary" for="termsCheck">
                                        I've read and agree with the Terms of Service and Privacy Policy
                                    </label>
                                </div>
                                <button type="submit" class="btn w-100 rounded-3 py-3 fw-bold shadow-sm"
                                    style="background-color: #FFC107; color: #000;">Sign up</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Image -->
            <div class="col-lg-6 d-none d-lg-block p-0 position-relative">
                <div class="h-100 w-100"
                    style="background-image: url('{{ asset('landing_bg.png') }}'); background-size: cover; background-position: center;">
                    <div class="position-absolute top-0 start-0 w-100 h-100"
                        style="background: linear-gradient(to right, rgba(255,255,255,1) 0%, rgba(255,255,255,0) 20%);">
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

            function toggleTabs(active, inactive) {
                active.classList.add('active');
                active.style.backgroundColor = '#FFC107';
                active.style.color = '#000';
                active.classList.remove('text-secondary', 'bg-light');

                inactive.classList.remove('active');
                inactive.style.backgroundColor = '';
                inactive.style.color = '';
                inactive.classList.add('text-secondary', 'bg-light');
            }

            loginTab.addEventListener('click', () => toggleTabs(loginTab, registerTab));
            registerTab.addEventListener('click', () => toggleTabs(registerTab, loginTab));
        });
    </script>
@endpush