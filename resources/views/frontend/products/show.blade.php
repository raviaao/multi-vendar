@extends('frontend.layouts.app')

@section('title', $product->name)

@section('content')
    <div class="container py-5">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                @if ($product->category)
                    <li class="breadcrumb-item"><a href="#">{{ $product->category->name }}</a></li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="row">
            <!-- Product Images -->
            <div class="col-lg-6">
                <!-- Main Image -->
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body p-0">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded"
                                alt="{{ $product->name }}" id="mainImage">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 400px;">
                                <i class="fas fa-box fa-4x text-muted"></i>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Thumbnail Images -->
                @if ($product->images && count(json_decode($product->images)) > 0)
                    <div class="row g-2">
                        @foreach (json_decode($product->images) as $index => $image)
                            <div class="col-3">
                                <div class="border rounded p-1 cursor-pointer"
                                    onclick="changeMainImage('{{ asset('storage/' . $image) }}')">
                                    <img src="{{ asset('storage/' . $image) }}" class="img-fluid"
                                        alt="Thumbnail {{ $index + 1 }}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Product Details -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <!-- Category -->
                        @if ($product->category)
                            <a href="#" class="badge bg-info text-decoration-none mb-3">
                                {{ $product->category->name }}
                            </a>
                        @endif

                        <!-- Product Name -->
                        <h1 class="h2 mb-3">{{ $product->name }}</h1>

                        <!-- SKU -->
                        @if ($product->sku)
                            <p class="text-muted mb-3">SKU: {{ $product->sku }}</p>
                        @endif

                        <!-- Price -->
                        <div class="mb-4">
                            @if ($product->is_on_sale)
                                <h2 class="text-danger">₹{{ $product->discount_price }}</h2>
                                <del class="text-muted h5">₹{{ $product->price }}</del>
                                <span class="badge bg-danger ms-2">
                                    {{ $product->discount_percentage }}% OFF
                                </span>
                            @else
                                <h2>₹{{ $product->price }}</h2>
                            @endif
                        </div>

                        <!-- Stock Status -->
                        <div class="mb-4">
                            @if ($product->stock_quantity > 10)
                                <span class="text-success">
                                    <i class="fas fa-check-circle"></i> In Stock
                                </span>
                            @elseif($product->stock_quantity > 0)
                                <span class="text-warning">
                                    <i class="fas fa-exclamation-circle"></i>
                                    Only {{ $product->stock_quantity }} left in stock
                                </span>
                            @else
                                <span class="text-danger">
                                    <i class="fas fa-times-circle"></i> Out of Stock
                                </span>
                            @endif
                        </div>

                        <!-- Description -->
                        @if ($product->description)
                            <div class="mb-4">
                                <h5>Description</h5>
                                <p>{{ $product->description }}</p>
                            </div>
                        @endif

                        <!-- Add to Cart -->
                        @if ($product->stock_quantity > 0)
                            <div class="row mb-4">
                                <div class="col-md-4 mb-3">
                                    <div class="input-group">
                                        <button class="btn btn-outline-secondary" type="button" id="decreaseQty">-</button>
                                        <input type="number" class="form-control text-center" value="1" min="1"
                                            max="{{ $product->stock_quantity }}" id="quantity">
                                        <button class="btn btn-outline-secondary" type="button" id="increaseQty">+</button>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <button class="btn btn-primary btn-lg w-100 mb-4" id="addToCartBtn"
                                        data-product-id="{{ $product->id }}">
                                        <i class="fas fa-shopping-cart me-2"></i> Add to Cart
                                    </button>
                                </div>
                            </div>
                        @else
                            <button class="btn btn-secondary btn-lg w-100 mb-4" disabled>
                                <i class="fas fa-ban me-2"></i> Out of Stock
                            </button>
                        @endif

                        <!-- Features -->
                        <div class="row mb-4">
                            <div class="col-6">
                                <div class="text-center p-3 border rounded">
                                    <i class="fas fa-shipping-fast fa-2x text-primary mb-2"></i>
                                    <p class="mb-0 small">Free Shipping</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center p-3 border rounded">
                                    <i class="fas fa-undo fa-2x text-primary mb-2"></i>
                                    <p class="mb-0 small">30-Day Return</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if ($relatedProducts->count() > 0)
            <div class="row mt-5">
                <div class="col-12">
                    <h3 class="mb-4">Related Products</h3>
                </div>
                @foreach ($relatedProducts as $related)
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                        <div class="card border-0 shadow-sm h-100">
                            @if ($related->image)
                                <img src="{{ asset('storage/' . $related->image) }}" class="card-img-top"
                                    alt="{{ $related->name }}" style="height: 200px; object-fit: cover;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center"
                                    style="height: 200px;">
                                    <i class="fas fa-box fa-3x text-muted"></i>
                                </div>
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="{{ route('product.show', $related->slug) }}"
                                        class="text-dark text-decoration-none">
                                        {{ $related->name }}
                                    </a>
                                </h5>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="h5 text-primary">₹{{ $related->price }}</span>
                                    <a href="{{ route('product.show', $related->slug) }}"
                                        class="btn btn-sm btn-outline-primary">View</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            $('#addToCartBtn').click(function() {
                const productId = $(this).data('product-id');
                const quantity = $('#quantity').val();

                $.ajax({
                    url: '{{ route('cart.add') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        product_id: productId,
                        quantity: quantity
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Product added to cart!');
                            // Update cart count in header
                            $('.cart-count-badge').text(response.cart_count);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            alert(xhr.responseJSON.message);
                        } else {
                            alert('Error adding to cart');
                        }
                    }
                });
            });
        });
    </script>
@endpush
