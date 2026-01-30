<section class="section-products py-5">
    <div class="container">
        <!-- Section Header -->
        <div class="row align-items-center mb-5">
            <div class="col-md-8">
                <div class="section-header">
                    <span class="badge bg-info mb-2 px-3 py-2 rounded-pill">
                        <i class="fas fa-clock me-1"></i> Just Arrived
                    </span>
                    <h2 class="section-title fw-bold mb-3">New Products</h2>
                    <p class="text-muted mb-0">Check out our latest arrivals</p>
                </div>
            </div>
            <div class="col-md-4 text-md-end">
                {{-- <a href="{{ url('/latest-products') }}" class="btn btn-outline-primary">
                    View All New Products
                    <i class="fas fa-arrow-right ms-2"></i>
                </a> --}}
            </div>
        </div>

        <!-- Products Grid - Show only 4 products -->
        <div class="row">
            @php
                $latestProducts = $latestProducts->take(4); // Show only 4 products
            @endphp

            @foreach ($latestProducts as $product)
                <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                    <div class="product-card card border-0 shadow-sm h-100">
                        <!-- Product Image -->
                        <div class="product-image position-relative overflow-hidden">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}"
                                     class="card-img-top"
                                     alt="{{ $product->name }}"
                                     style="height: 200px; object-fit: cover;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center"
                                     style="height: 200px;">
                                    <i class="fas fa-box fa-3x text-muted"></i>
                                </div>
                            @endif

                            <!-- New Badge -->
                            <div class="badge bg-info text-white position-absolute top-0 start-0 m-2">
                                NEW
                            </div>
                        </div>

                        <!-- Product Details -->
                        <div class="card-body">
                            <!-- Product Name -->
                            <h6 class="card-title mb-2">
                                <a href="{{ url('/products/' . $product->slug) }}"
                                   class="text-dark text-decoration-none">
                                    {{ Str::limit($product->name, 50) }}
                                </a>
                            </h6>

                            <!-- Price -->
                            <div class="product-price mb-3">
                                @if ($product->is_on_sale)
                                    <span class="h6 text-danger">₹{{ $product->discount_price }}</span>
                                    <del class="text-muted ms-2 small">₹{{ $product->price }}</del>
                                @else
                                    <span class="h6 text-dark">₹{{ $product->price }}</span>
                                @endif
                            </div>

                            <!-- Add to Cart Button -->
                            <div class="d-grid">
                                @if ($product->stock_quantity > 0)
                                    <button class="btn btn-primary btn-sm add-to-cart"
                                            data-product-id="{{ $product->id }}">
                                        <i class="fas fa-shopping-cart me-1"></i> Add to Cart
                                    </button>
                                @else
                                    <button class="btn btn-secondary btn-sm" disabled>
                                        <i class="fas fa-ban me-1"></i> Out of Stock
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            @if ($latestProducts->isEmpty())
                <div class="col-12 text-center py-5">
                    <i class="fas fa-clock fa-3x text-muted mb-3"></i>
                    <h4>No New Products</h4>
                    <p class="text-muted">Check back soon for new arrivals.</p>
                </div>
            @endif
        </div>

        <!-- View More Button for Mobile -->
        <div class="text-center mt-4 d-md-none">
            <a href="{{ url('/latest-products') }}" class="btn btn-primary px-4">
                View All New Products
                <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>
