<section class="hero-section position-relative overflow-hidden"
         style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.3)),
                url('{{ asset('frontend/images/banner-1.jpg') }}');
                background-repeat: no-repeat;
                background-size: cover;
                background-position: center;">

    <!-- Animated Background Elements -->
    <div class="position-absolute top-0 start-0 w-100 h-100">
        <div class="floating-element" style="top: 20%; left: 10%;"></div>
        <div class="floating-element" style="top: 60%; right: 15%;"></div>
        <div class="floating-element" style="bottom: 30%; left: 20%;"></div>
    </div>

    <div class="container-lg position-relative z-1">
        <div class="row align-items-center min-vh-80 py-5">
            <!-- Left Content -->
            <div class="col-lg-7 col-md-8 py-5 my-lg-5">
                <div class="hero-content text-white">
                    <!-- Badge -->
                    <span class="badge bg-primary bg-opacity-25 text-primary border border-primary px-4 py-2 rounded-pill mb-4 d-inline-flex align-items-center">
                        <i class="fas fa-leaf me-2"></i> 100% Organic & Natural
                    </span>

                    <!-- Main Heading -->
                    <h1 class="display-2 fw-bold mb-3 hero-title">
                        <span class="text-gradient-primary">Organic</span> Foods Delivered
                        <span class="d-block">To Your <span class="text-gradient-success">Doorstep</span></span>
                    </h1>

                    <!-- Subtitle -->
                    <p class="lead fs-3 mb-4 opacity-75">
                        Farm-fresh organic produce delivered directly to your home.
                        Experience the taste of nature.
                    </p>

                    <!-- CTA Buttons -->
                    <div class="d-flex flex-wrap gap-3 mb-5">
                        <a href="#"
                           class="btn btn-primary btn-lg px-5 py-3 rounded-pill shadow-lg hover-lift">
                            <i class="fas fa-shopping-cart me-2"></i> Start Shopping
                        </a>
                        <a href="{{ route('register') }}"
                           class="btn btn-outline-light btn-lg px-5 py-3 rounded-pill border-2 hover-lift">
                            <i class="fas fa-user-plus me-2"></i> Join Now
                        </a>
                    </div>

                    <!-- Stats -->
                    <div class="row g-4 mt-5 pt-4">
                        <div class="col-md-4">
                            <div class="stat-card text-center p-3">
                                <div class="stat-number display-6 fw-bold text-white mb-2">14k+</div>
                                <div class="stat-label text-uppercase opacity-75">Product Varieties</div>
                                <div class="stat-underline mt-2 mx-auto" style="width: 40px; height: 3px; background: linear-gradient(90deg, #4CAF50, #2196F3);"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-card text-center p-3">
                                <div class="stat-number display-6 fw-bold text-white mb-2">50k+</div>
                                <div class="stat-label text-uppercase opacity-75">Happy Customers</div>
                                <div class="stat-underline mt-2 mx-auto" style="width: 40px; height: 3px; background: linear-gradient(90deg, #FF9800, #FF5722);"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-card text-center p-3">
                                <div class="stat-number display-6 fw-bold text-white mb-2">10+</div>
                                <div class="stat-label text-uppercase opacity-75">Store Locations</div>
                                <div class="stat-underline mt-2 mx-auto" style="width: 40px; height: 3px; background: linear-gradient(90deg, #9C27B0, #E91E63);"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Image/Illustration -->
            <div class="col-lg-5 col-md-4 d-none d-md-block">
                <div class="hero-image-wrapper position-relative">
                    <div class="hero-image-float position-relative">
                        <img src="{{ asset('frontend/images/organic-vector.png') }}"
                             alt="Organic Food"
                             class="img-fluid floating-animation"
                             style="filter: drop-shadow(0 20px 40px rgba(0,0,0,0.3));">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Cards -->
    <div class="container-lg mt-5 pt-lg-5 position-relative z-1">
        <div class="row g-4 justify-content-center">
            <div class="col-lg-4 col-md-6">
                <div class="feature-card bg-white rounded-4 p-4 shadow-lg hover-lift">
                    <div class="row align-items-center">
                        <div class="col-3 text-center">
                            <div class="feature-icon-wrapper bg-primary bg-opacity-10 rounded-circle p-3">
                                <svg width="40" height="40" class="text-primary">
                                    <use xlink:href="#fresh"></use>
                                </svg>
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="feature-content">
                                <h5 class="fw-bold mb-2">Fresh from Farm</h5>
                                <p class="text-muted mb-0">Harvested daily and delivered fresh to preserve nutrients.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="feature-card bg-white rounded-4 p-4 shadow-lg hover-lift">
                    <div class="row align-items-center">
                        <div class="col-3 text-center">
                            <div class="feature-icon-wrapper bg-success bg-opacity-10 rounded-circle p-3">
                                <svg width="40" height="40" class="text-success">
                                    <use xlink:href="#organic"></use>
                                </svg>
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="feature-content">
                                <h5 class="fw-bold mb-2">100% Organic</h5>
                                <p class="text-muted mb-0">Certified organic produce free from chemicals & pesticides.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="feature-card bg-white rounded-4 p-4 shadow-lg hover-lift">
                    <div class="row align-items-center">
                        <div class="col-3 text-center">
                            <div class="feature-icon-wrapper bg-danger bg-opacity-10 rounded-circle p-3">
                                <svg width="40" height="40" class="text-danger">
                                    <use xlink:href="#delivery"></use>
                                </svg>
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="feature-content">
                                <h5 class="fw-bold mb-2">Free Delivery</h5>
                                <p class="text-muted mb-0">Free doorstep delivery on all orders above ₹500.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="scroll-indicator position-absolute bottom-0 start-50 translate-middle-x mb-4">
        <a href="#next-section" class="text-white text-decoration-none">
            <div class="d-flex flex-column align-items-center">
                <span class="mb-2 opacity-75">Scroll to explore</span>
                <div class="mouse">
                    <div class="wheel"></div>
                </div>
            </div>
        </a>
    </div>
</section>

<!-- Add these SVG symbols in your layout -->
<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="fresh" viewBox="0 0 24 24">
        <path d="M12 2L4 5v6.09c0 5.05 3.41 9.76 8 10.91 4.59-1.15 8-5.86 8-10.91V5l-8-3z"/>
    </symbol>
    <symbol id="organic" viewBox="0 0 24 24">
        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 010-5 2.5 2.5 0 010 5z"/>
    </symbol>
    <symbol id="delivery" viewBox="0 0 24 24">
        <path d="M19 7h-.73l-8-5.27L2.27 7H1v12h18V7zm-9 10H5V9h5v8zm7 0h-5V9h5v8z"/>
    </symbol>
</svg>
