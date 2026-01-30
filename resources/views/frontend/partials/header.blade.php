<header class="sticky-top bg-white shadow-sm">
    <div class="container-fluid px-3 px-lg-4">
        <!-- Top Announcement Bar -->
        <div class="top-bar bg-primary py-2 d-none d-lg-block">
            <div class="row align-items-center">
                <div class="col text-center text-white">
                    <small class="d-flex align-items-center justify-content-center gap-3 flex-wrap">
                        <span><i class="fas fa-truck me-1"></i> Free shipping on orders over $50</span>
                        <span class="d-none d-xl-inline">|</span>
                        <span><i class="fas fa-clock me-1"></i> Same day delivery</span>
                    </small>
                </div>
            </div>
        </div>

        <!-- Main Header -->
        <div class="row align-items-center py-2 py-lg-3">
            <!-- Logo & Mobile Menu -->
            <div class="col-6 col-lg-2">
                <div class="d-flex align-items-center">
                    <!-- Logo -->
                    <a href="{{ url('/') }}" class="logo-link text-decoration-none">
                        <img src="{{ asset('frontend/images/logo.svg') }}" alt="Organic Store" class="img-fluid" style="height: 40px;">
                    </a>

                    <!-- Mobile Menu Toggle -->
                    {{-- <button class="navbar-toggler border-0 ms-3 d-lg-none p-0"
                            type="button"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasNavbar">
                        <i class="fas fa-bars fs-4 text-primary"></i>
                    </button> --}}
                </div>
            </div>

            <!-- Desktop Search -->
            <div class="col-lg-6 d-none d-lg-block">
                <form id="search-form" class="px-lg-4">
                    <div class="input-group border rounded-pill overflow-hidden shadow-sm">
                        <select class="form-select border-0 bg-transparent" style="max-width: 150px;">
                            <option>All Categories</option>
                            <option>Groceries</option>
                            <option>Drinks</option>
                            <option>Chocolates</option>
                        </select>
                        <input type="text"
                               class="form-control border-0 border-start py-2 px-3"
                               placeholder="Search organic products...">
                        <button class="btn btn-primary px-4 border-0" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Action Icons -->
            <div class="col-6 col-lg-4">
                <div class="d-flex justify-content-end align-items-center gap-4">
                    <!-- Mobile Search -->
                    <button class="btn btn-outline-primary btn-sm rounded-circle p-2 d-lg-none"
                            id="mobileSearchToggle">
                        <i class="fas fa-search"></i>
                    </button>

                    <!-- Desktop Categories -->
                    <div class="dropdown d-none d-lg-block">
                        <a href="#"
                           class="text-dark text-decoration-none dropdown-toggle fw-medium"
                           data-bs-toggle="dropdown">
                            Categories
                        </a>
                        <ul class="dropdown-menu border-0 shadow p-3">
                            <li><a class="dropdown-item py-2" href="#"><i class="fas fa-leaf me-2 text-success"></i> Vegetables</a></li>
                            <li><a class="dropdown-item py-2" href="#"><i class="fas fa-apple-alt me-2 text-danger"></i> Fruits</a></li>
                            <li><a class="dropdown-item py-2" href="#"><i class="fas fa-wine-bottle me-2 text-info"></i> Drinks</a></li>
                            <li><a class="dropdown-item py-2" href="#"><i class="fas fa-cookie me-2 text-warning"></i> Snacks</a></li>
                        </ul>
                    </div>

                    <!-- Icons Group -->
                    <div class="d-flex align-items-center gap-3">
                        <!-- Wishlist -->
                        <a href="#" class="position-relative text-decoration-none">
                            <i class="fas fa-heart fs-5 text-danger"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge bg-danger rounded-pill" style="font-size: 0.6rem;">
                                3
                            </span>
                        </a>

                        <!-- Cart -->
                        <a href="{{ route('cart.index') }}" class="position-relative text-decoration-none">
                            <i class="fas fa-shopping-bag fs-5 text-primary"></i>
                            @php
                                $cartCount = 0;
                                $cartItems = session('cart', []);
                                if(is_array($cartItems) && !empty($cartItems)) {
                                    foreach($cartItems as $item) {
                                        $cartCount += $item['quantity'] ?? 0;
                                    }
                                }
                            @endphp
                            <span class="position-absolute top-0 start-100 translate-middle badge bg-primary rounded-pill cart-count"
                                  style="font-size: 0.6rem; min-width: 20px; height: 20px; display: {{ $cartCount > 0 ? 'flex' : 'none' }}; align-items: center; justify-content: center;">
                                {{ $cartCount > 99 ? '99+' : $cartCount }}
                            </span>
                        </a>

                        <!-- User Account -->
                        <div class="user-dropdown">
                            @auth
                                <div class="dropdown">
                                    <a class="d-flex align-items-center text-decoration-none dropdown-toggle p-0"
                                       href="#"
                                       data-bs-toggle="dropdown">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                             style="width: 40px; height: 40px;">
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        </div>
                                        <span class="d-none d-xl-inline ms-2 fw-medium text-dark">
                                            {{ Auth::user()->first_name ?? explode(' ', Auth::user()->name)[0] }}
                                        </span>
                                    </a>

                                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow p-3" style="min-width: 250px;">
                                        <!-- User Info -->
                                        <li class="mb-2">
                                            <div class="d-flex align-items-center p-2">
                                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                                                     style="width: 45px; height: 45px;">
                                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fw-bold">{{ Auth::user()->name }}</h6>
                                                    <small class="text-muted">{{ Auth::user()->email }}</small>
                                                </div>
                                            </div>
                                        </li>

                                        <li><hr class="dropdown-divider"></li>

                                        <!-- Menu Items -->
                                        <li>
                                            <a class="dropdown-item py-2" href="{{ route('home') }}">
                                                <i class="fas fa-home me-2 text-primary"></i>
                                                Dashboard
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item py-2" href="#">
                                                <i class="fas fa-user me-2 text-info"></i>
                                                My Profile
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item py-2" href="#">
                                                <i class="fas fa-shopping-bag me-2 text-success"></i>
                                                My Orders
                                            </a>
                                        </li>

                                        @if (Auth::user()->isAdmin())
                                            <li>
                                                <a class="dropdown-item py-2 text-warning" href="{{ route('admin.dashboard') }}">
                                                    <i class="fas fa-crown me-2"></i>
                                                    Admin Dashboard
                                                </a>
                                            </li>
                                        @endif

                                        <li><hr class="dropdown-divider"></li>

                                        <li>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="dropdown-item py-2 text-danger">
                                                    <i class="fas fa-sign-out-alt me-2"></i>
                                                    Logout
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            @else
                                <div class="d-flex gap-2">
                                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm px-3">
                                        Login
                                    </a>
                                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm px-3">
                                        Sign Up
                                    </a>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Search -->
        <div class="row d-lg-none mt-2" id="mobileSearchBar" style="display: none;">
            <div class="col-12">
                <form class="input-group shadow-sm rounded-pill overflow-hidden">
                    <input type="text" class="form-control border-0 py-2" placeholder="Search products...">
                    <button class="btn btn-primary px-4">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

<!-- JavaScript for mobile search toggle -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileSearchToggle = document.getElementById('mobileSearchToggle');
    const mobileSearchBar = document.getElementById('mobileSearchBar');

    if (mobileSearchToggle && mobileSearchBar) {
        mobileSearchToggle.addEventListener('click', function() {
            if (mobileSearchBar.style.display === 'none' || mobileSearchBar.style.display === '') {
                mobileSearchBar.style.display = 'flex';
                mobileSearchBar.classList.add('animate__animated', 'animate__fadeInDown');
            } else {
                mobileSearchBar.style.display = 'none';
            }
        });
    }

    // Update cart count dynamically (if using AJAX)
    function updateCartCount(count) {
        const cartBadge = document.querySelector('.cart-count');
        if (cartBadge) {
            if (count > 0) {
                cartBadge.textContent = count > 99 ? '99+' : count;
                cartBadge.style.display = 'flex';
            } else {
                cartBadge.style.display = 'none';
            }
        }
    }

    // Listen for cart updates (custom event)
    document.addEventListener('cartUpdated', function(e) {
        updateCartCount(e.detail.count);
    });
});
</script>

<style>
/* Custom styles for better appearance */
.top-bar {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.icon-wrapper {
    transition: transform 0.2s;
}

.icon-wrapper:hover {
    transform: translateY(-2px);
}

.dropdown-menu {
    border-radius: 12px;
}

.cart-count {
    transition: all 0.3s;
}

.badge {
    padding: 0.25em 0.5em;
    line-height: 1;
}

.rounded-circle {
    font-weight: 600;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
}

.btn-outline-primary {
    border-color: #667eea;
    color: #667eea;
}

.btn-outline-primary:hover {
    background: #667eea;
    border-color: #667eea;
}

.dropdown-item {
    border-radius: 8px;
    transition: all 0.2s;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
    transform: translateX(2px);
}

#mobileSearchBar {
    transition: all 0.3s ease;
}

@media (max-width: 992px) {
    .container-fluid {
        padding-left: 15px;
        padding-right: 15px;
    }

    .gap-3 {
        gap: 1rem !important;
    }
}

@media (max-width: 576px) {
    .user-dropdown .btn {
        padding-left: 1rem !important;
        padding-right: 1rem !important;
        font-size: 0.875rem;
    }
}
</style>
