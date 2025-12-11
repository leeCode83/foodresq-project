@extends('layouts.app')

@section('title', 'FoodResQ - Landing Page')

@section('content')
    <style>
        .landing-hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background-image: url('landing_bg.png');
            background-size: cover;
            background-position: center bottom;
            z-index: -1;
        }

        .landing-hero-bg::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 30%;
            background: linear-gradient(to top, rgba(255, 255, 255, 1) 0%, rgba(255, 255, 255, 0) 100%);
            pointer-events: none;
        }
    </style>

    <!-- Navbar -->
    @include('partials.navbar')

    <!-- Background Layer -->
    <div class="landing-hero-bg"></div>

    <!-- Hero Section -->
    <div class="container min-vh-75 d-flex align-items-center py-5 position-relative z-1">
        <div class="row align-items-center w-100">
            <!-- Left Content -->
            <div class="col-lg-6 mb-5 mb-lg-0">
                <h1 class="display-3 fw-bold text-dark mb-4 lh-sm">
                    Ramah <br>
                    Lingkungan Anti <br>
                    Food Waste
                </h1>
                <p class="lead text-secondary mb-5" style="max-width: 500px;">
                    Beli secukupnya, bantu sesamanya, makanan sehat bergizi untuk semua kalangan usia dan lingkungan
                </p>
                <div class="d-flex gap-3">
                    <a href="{{ route('food.index') }}"
                        class="btn btn-warning text-white rounded-pill px-4 py-2 fw-bold shadow-sm">Cari Makanan</a>
                    <a href="{{ route('auth.seller') }}"
                        class="btn btn-light rounded-pill px-4 py-2 fw-bold shadow-sm border">Daftar Restoran</a>
                </div>
            </div>

            <!-- Right Image -->
        </div>
    </div>
@endsection