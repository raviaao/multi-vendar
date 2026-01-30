@extends('frontend.layouts.app')

@section('title', $category->name . ' - Products')

@section('content')
    <!-- Page Header -->
    <div class="container-fluid py-4 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ url('/') }}" class="text-decoration-none text-dark">
                                    <i class="fas fa-home me-1"></i> Home
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ url('/categories') }}" class="text-decoration-none text-dark">
                                    <i class="fas fa-tags me-1"></i> Categories
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ $category->name }}
                            </li>
                        </ol>
                    </nav>
                    <h1 class="h2 fw-bold mt-2 mb-0">{{ $category->name }}</h1>
                    <p class="text-muted mb-0">
                        {{ $category->products_count ?? 0 }} products found
                    </p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}"
                             alt="{{ $category->name }}"
                             class="img-fluid rounded"
                             style="max-height: 100px;">
                    @else
                        <div class="bg-primary bg-opacity-10 rounded p-3 d-inline-block">
                            <i class="fas fa-tag fa-2x text-primary"></i>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Category Description -->
    @if($category->description)
        <div class="container py-3">
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-info mb-0">
                        <p class="mb-0">{{ $category->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Products Grid -->
    <div class="container py-5">
        @if($products->count() > 0)
            <div class="row mb-4">
                <div class="col-md-6">
                    <p class="mb-0">
                        Showing {{ $products->firstItem() }} - {{ $products->lastItem() }} of {{ $products->total() }} products
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                            Sort by
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Latest</a></li>
                            <li><a class="dropdown-item" href="#">Price: Low to High</a></li>
                            <li><a class="dropdown-item" href="#">Price: High to Low</a></li>
                            <li><a class="dropdown-item" href="#">Most Popular</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                @foreach($products as $product)
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="product-card card border-0 shadow-sm h-100">
                            <!-- Product Image -->
                            <div class="product-image position-relative overflow-hidden">
                                @if($product->image)
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

                                <!-- Sale Badge -->
                                @if($product->is_on_sale)
                                    <div class="badge bg-danger position-absolute top-0 start-0 m-3">
                                        SALE
                                    </div>
                                @endif
                            </div>

                            <!-- Product Details -->
                            <div class="card-body">
                                <!-- Product Name -->
                                <h5 class="card-title mb-2">
                                    <a href="{{ url('/products/' . $product->slug) }}"
                                       class="text-dark text-decoration-none">
                                        {{ $product->name }}
                                    </a>
                                </h5>

                                <!-- Price -->
                                <div class="product-price mb-3">
                                    @if($product->is_on_sale)
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
                                    @if($product->stock_quantity > 10)
                                        <span class="text-success">
                                            <i class="fas fa-check-circle"></i> In Stock
                                        </span>
                                    @elseif($product->stock_quantity > 0)
                                        <span class="text-warning">
                                            <i class="fas fa-exclamation-circle"></i>
                                            Only {{ $product->stock_quantity }} left
                                        </span>
                                    @else
                                        <span class="text-danger">
                                            <i class="fas fa-times-circle"></i> Out of Stock
                                        </span>
                                    @endif
                                </div>

                                <!-- Add to Cart Button -->
                                <div class="d-grid">
                                    @if($product->stock_quantity > 0)
                                        <button class="btn btn-primary add-to-cart"
                                                data-product-id="{{ $product->id }}">
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
            </div>

            <!-- Pagination -->
            <div class="row mt-5">
                <div class="col-12">
                    {{ $products->links() }}
                </div>
            </div>
        @else
            <!-- No Products Found -->
            <div class="row">
                <div class="col-12 text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                        <h4 class="mb-2">No Products Found</h4>
                        <p class="text-muted mb-4">No products available in this category yet.</p>
                        <a href="{{ url('/categories') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left me-2"></i> Back to Categories
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('styles')
<style>
    .product-card {
        transition: all 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .product-image {
        border-radius: 8px 8px 0 0;
    }

    .empty-state {
        padding: 60px 20px;
    }

    .breadcrumb {
        background: transparent;
        padding: 0;
    }

    .bg-light {
        background-color: #f8f9fa !important;
    }
</style>
@endpush
