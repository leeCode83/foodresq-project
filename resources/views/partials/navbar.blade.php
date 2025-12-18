<nav class="navbar navbar-expand-lg navbar-light bg-white py-3">
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

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Search -->
            <form action="{{ route('food.search') }}" method="GET" class="mx-auto my-3 my-lg-0"
                style="max-width: 400px; width: 100%;">
                <div class="input-group">
                    <input type="text" name="query" class="form-control rounded-pill bg-secondary-subtle border-0 px-4"
                        placeholder="Search..." value="{{ request('query') }}">
                </div>
            </form>

            <!-- Links -->
            <ul class="navbar-nav align-items-center gap-3">
                <li class="nav-item"><a class="nav-link active text-success fw-semibold"
                        href="{{ route('food.index') }}">Explore</a></li>
                <li class="nav-item"><a class="nav-link text-success fw-semibold"
                        href="{{ route('checkout.index') }}">Cart</a></li>

                @if(Auth::guard('buyer')->check())
                    <li class="nav-item">
                        <a href="{{ route('buyer.orders') }}"
                            class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center"
                            style="width: 40px; height: 40px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="bi bi-person" viewBox="0 0 16 16">
                                <path
                                    d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                            </svg>
                        </a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('buyer.logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="btn btn-outline-danger rounded-pill px-3 py-1 btn-sm">Logout</button>
                        </form>
                    </li>
                @elseif(Auth::guard('seller')->check())
                    <li class="nav-item">
                        <a href="{{ route('seller.dashboard') }}"
                            class="btn btn-warning rounded-pill px-3 py-1 fw-bold text-white">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('seller.logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="btn btn-outline-danger rounded-pill px-3 py-1 btn-sm">Logout</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="{{ route('auth.seller') }}"
                            class="btn btn-outline-warning rounded-pill px-3 py-1 fw-semibold me-2">Login as Seller</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('auth.buyer') }}"
                            class="btn btn-outline-success rounded-pill px-3 py-1 fw-semibold">Login as Buyer</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>