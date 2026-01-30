<section class="py-5 bg-light">
    <div class="container">
        <!-- Section Header -->
        <div class="section-header mb-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <span class="section-subtitle text-primary fw-bold d-flex align-items-center gap-2">
                        <i class="fas fa-tags"></i> BROWSE BY
                    </span>
                    <h2 class="section-title fw-bold mb-2">Shop by Category</h2>
                    <p class="text-muted mb-0">Explore our fresh organic products by category</p>
                </div>
                <!-- Simple URL use करें -->
                <a href="{{ url('/categories') }}" class="btn btn-outline-primary d-none d-md-flex align-items-center gap-2">
                    View All <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Categories Grid -->
        <div class="row g-3 g-md-4">
            @foreach($categories as $category)
                <div class="col-6 col-md-4 col-lg-2">
                    <!-- Simple URL use करें -->
                    <a href="{{ url('/category/' . $category->slug) }}" class="category-card text-decoration-none">
                        <div class="category-inner text-center">
                            <!-- Category Image -->
                            <div class="category-image position-relative mb-3">
                                @if($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}"
                                         alt="{{ $category->name }}"
                                         class="img-fluid rounded-circle">
                                @else
                                    <div class="placeholder-image rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center mx-auto"
                                         style="width: 120px; height: 120px;">
                                        <i class="fas fa-tag fa-3x text-primary"></i>
                                    </div>
                                @endif

                                <!-- Product Count Badge -->
                                @if($category->products_count > 0)
                                    <span class="product-count-badge position-absolute top-0 start-0 badge bg-danger rounded-pill">
                                        {{ $category->products_count }}
                                    </span>
                                @endif
                            </div>

                            <!-- Category Info -->
                            <div class="category-info">
                                <h6 class="category-title mb-1 fw-bold text-dark">{{ $category->name }}</h6>
                                @if($category->products_count > 0)
                                    <p class="category-count text-muted small mb-0">
                                        {{ $category->products_count }} {{ Str::plural('item', $category->products_count) }}
                                    </p>
                                @else
                                    {{-- <p class="category-count text-muted small mb-0">Coming soon</p> --}}
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach

            @if(isset($categories) && $categories->isEmpty())
                <div class="col-12 text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                        <h4 class="mb-2">No Categories Found</h4>
                        <p class="text-muted mb-0">Categories will be added soon</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Mobile View All Button -->
        <div class="text-center mt-5 d-md-none">
            <!-- Simple URL use करें -->
            <a href="{{ url('/categories') }}" class="btn btn-primary px-5">
                View All Categories <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>
