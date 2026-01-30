<section class="section-products">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-header d-flex justify-content-between align-items-center mb-4">
                    <h2 class="section-title">Most Popular Products</h2>
                    <a href="{{ route('products.popular') }}" class="btn btn-outline-primary">View All</a>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach ($popularProducts as $product)
                <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                    <div class="product-card card border-0 shadow-sm h-100">
                        <!-- Product Image -->
                        <div class="product-image position-relative overflow-hidden">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top"
                                    alt="{{ $product->name }}" style="height: 250px; object-fit: cover;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center"
                                    style="height: 250px;">
                                    <i class="fas fa-box fa-3x text-muted"></i>
                                </div>
                            @endif

                            <!-- Popular Badge -->
                            <div class="badge bg-warning text-dark position-absolute top-0 start-0 m-3">
                                <i class="fas fa-fire me-1"></i> POPULAR
                            </div>

                            <!-- Quick Actions -->
                            <div class="product-actions position-absolute top-0 end-0 m-3">
                                <button class="btn btn-sm btn-light rounded-circle mb-2">
                                    <i class="fas fa-heart"></i>
                                </button>
                                <button class="btn btn-sm btn-light rounded-circle">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Product Details -->
                        <div class="card-body">
                            <!-- Category -->
                            @if ($product->category)
                                <a href="#" class="text-muted small d-block mb-2 text-decoration-none">
                                    {{ $product->category->name }}
                                </a>
                            @endif

                            <!-- Product Name -->
                            <h5 class="card-title mb-2">
                                <a href="/products/{{ $product->slug }}" class="text-dark text-decoration-none">
                                    {{ $product->name }}
                                </a>
                            </h5>

                            <!-- Rating -->
                            <div class="product-rating mb-2">
                                @php
                                    $rating = $product->rating ?? 4;
                                    $fullStars = floor($rating);
                                    $hasHalfStar = ($rating - $fullStars) > 0;
                                @endphp

                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $fullStars)
                                        <i class="fas fa-star text-warning" style="font-size: 12px;"></i>
                                    @elseif ($hasHalfStar && $i == $fullStars + 1)
                                        <i class="fas fa-star-half-alt text-warning" style="font-size: 12px;"></i>
                                    @else
                                        <i class="far fa-star text-muted" style="font-size: 12px;"></i>
                                    @endif
                                @endfor
                                <span class="text-muted small ms-1">({{ $product->reviews_count ?? 0 }})</span>
                            </div>

                            <!-- Price -->
                            <div class="product-price mb-3">
                                @if ($product->is_on_sale)
                                    <span class="h5 text-danger">₹{{ $product->discount_price }}</span>
                                    <del class="text-muted ms-2">₹{{ $product->price }}</del>
                                    <span class="badge bg-danger ms-2">
                                        {{ $product->discount_percentage }}% OFF
                                    </span>
                                @else
                                    <span class="h5 text-dark">₹{{ $product->price }}</span>
                                @endif
                            </div>

                            <!-- Stock Status -->
                            <div class="product-stock mb-3">
                                @if ($product->stock_quantity > 10)
                                    <span class="text-success">
                                        <i class="fas fa-check-circle"></i> In Stock
                                    </span>
                                @elseif($product->stock_quantity > 0)
                                    <span class="text-warning">
                                        <i class="fas fa-exclamation-circle"></i> Only {{ $product->stock_quantity }}
                                        left
                                    </span>
                                @else
                                    <span class="text-danger">
                                        <i class="fas fa-times-circle"></i> Out of Stock
                                    </span>
                                @endif
                            </div>

                            <!-- Add to Cart Button -->
                            <div class="d-grid">
                                @if ($product->stock_quantity > 0)
                                    <button class="btn btn-primary add-to-cart" data-product-id="{{ $product->id }}">
                                        <i class="fas fa-shopping-cart me-2"></i> Add to Cart
                                    </button>
                                @else
                                    <button class="btn btn-secondary" disabled>
                                        <i class="fas fa-ban me-2"></i> Out of Stock
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            @if ($popularProducts->isEmpty())
                <div class="col-12 text-center py-5">
                    <i class="fas fa-fire fa-3x text-muted mb-3"></i>
                    <h4>No Popular Products</h4>
                    <p class="text-muted">No popular products available at the moment.</p>
                </div>
            @endif
        </div>
    </div>
</section>
