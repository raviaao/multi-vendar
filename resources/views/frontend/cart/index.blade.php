@extends('frontend.layouts.app')

@section('title', 'Shopping Cart')

@section('content')
    <!-- Page Header -->
    <div class="container-fluid py-4 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">
                                <i class="fas fa-home me-1"></i> Home
                            </a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <i class="fas fa-shopping-cart me-1"></i> Shopping Cart
                            </li>
                        </ol>
                    </nav>
                    <h1 class="h2 fw-bold mb-0">Your Shopping Cart</h1>
                    <p class="text-muted mb-0">Review your items before checkout</p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <div class="d-inline-flex align-items-center bg-white rounded-pill px-3 py-2 shadow-sm">
                        <i class="fas fa-box text-primary me-2"></i>
                        <span class="fw-medium me-2">Items:</span>
                        <span class="badge bg-primary rounded-pill" id="cart-item-count">
                            {{ count($cart) ?? 0 }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container py-4">
        @if (!empty($cart) && count($cart) > 0)
            <div class="row">
                <!-- Cart Items -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="border-0" width="100">Product</th>
                                            <th class="border-0">Details</th>
                                            <th class="border-0 text-center" width="120">Price</th>
                                            <th class="border-0 text-center" width="140">Quantity</th>
                                            <th class="border-0 text-center" width="120">Total</th>
                                            <th class="border-0 text-center" width="60">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="cart-items">
                                        @php
                                            $subtotal = 0;
                                        @endphp

                                        @foreach ($cart as $id => $item)
                                            @php
                                                $itemTotal = $item['price'] * $item['quantity'];
                                                $subtotal += $itemTotal;
                                            @endphp
                                            <tr id="cart-row-{{ $id }}">
                                                <td class="py-3">
                                                    @if ($item['image'])
                                                        <img src="{{ asset('storage/' . $item['image']) }}"
                                                             class="img-fluid rounded"
                                                             style="width: 80px; height: 80px; object-fit: cover;"
                                                             alt="{{ $item['name'] }}">
                                                    @else
                                                        <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                             style="width: 80px; height: 80px;">
                                                            <i class="fas fa-image text-muted"></i>
                                                        </div>
                                                    @endif
                                                </td>

                                                <td class="py-3">
                                                    <h6 class="fw-bold mb-1">{{ $item['name'] }}</h6>
                                                    @if(isset($item['category']))
                                                        <small class="text-muted d-block">
                                                            <i class="fas fa-tag me-1"></i>{{ $item['category'] }}
                                                        </small>
                                                    @endif
                                                    @if(isset($item['stock']) && $item['stock'] > 0)
                                                        <small class="text-success">
                                                            <i class="fas fa-check-circle me-1"></i> In Stock
                                                        </small>
                                                    @endif
                                                </td>

                                                <td class="py-3 text-center">
                                                    <span class="fw-bold item-price" data-price="{{ $item['price'] }}">
                                                        ₹{{ number_format($item['price'], 2) }}
                                                    </span>
                                                </td>

                                                <td class="py-3 text-center">
                                                    <div class="d-flex justify-content-center">
                                                        <div class="input-group" style="width: 130px;">
                                                            <button class="btn btn-outline-secondary btn-sm decrease-qty"
                                                                    type="button"
                                                                    data-product-id="{{ $id }}">
                                                                <i class="fas fa-minus"></i>
                                                            </button>
                                                            <input type="number"
                                                                   class="form-control text-center quantity-input"
                                                                   value="{{ $item['quantity'] }}"
                                                                   min="1"
                                                                   max="10"
                                                                   data-product-id="{{ $id }}"
                                                                   readonly>
                                                            <button class="btn btn-outline-secondary btn-sm increase-qty"
                                                                    type="button"
                                                                    data-product-id="{{ $id }}">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class="py-3 text-center">
                                                    <span class="fw-bold text-primary item-total" id="item-total-{{ $id }}">
                                                        ₹{{ number_format($itemTotal, 2) }}
                                                    </span>
                                                </td>

                                                <td class="py-3 text-center">
                                                    <button class="btn btn-outline-danger btn-sm remove-item"
                                                            data-product-id="{{ $id }}"
                                                            title="Remove item">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-footer bg-white border-top">
                            <div class="row">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <div class="input-group">
                                        <input type="text"
                                               class="form-control"
                                               placeholder="Promo code"
                                               id="promo-code">
                                        <button class="btn btn-outline-primary" id="apply-promo">
                                            Apply
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <button class="btn btn-outline-danger me-2" id="clear-cart-btn">
                                        <i class="fas fa-trash me-1"></i> Clear Cart
                                    </button>
                                    <a href="{{ route('products.index') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-1"></i> Add More Items
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Info -->
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <i class="fas fa-truck fa-2x text-primary"></i>
                                    </div>
                                    <h6 class="fw-bold">Free Shipping</h6>
                                    <p class="small text-muted mb-0">On orders over ₹1000</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <i class="fas fa-undo fa-2x text-success"></i>
                                    </div>
                                    <h6 class="fw-bold">Easy Returns</h6>
                                    <p class="small text-muted mb-0">30-day return policy</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <i class="fas fa-shield-alt fa-2x text-warning"></i>
                                    </div>
                                    <h6 class="fw-bold">Secure Payment</h6>
                                    <p class="small text-muted mb-0">100% secure payment</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">
                                <i class="fas fa-receipt me-2 text-primary"></i>
                                Order Summary
                            </h5>
                        </div>

                        <div class="card-body">
                            <!-- Price Breakdown -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Subtotal</span>
                                    <span class="fw-bold" id="cart-subtotal">
                                        ₹{{ number_format($subtotal, 2) }}
                                    </span>
                                </div>

                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Shipping</span>
                                    <span class="fw-bold" id="cart-shipping">
                                        @if($subtotal >= 1000)
                                            <span class="text-success">FREE</span>
                                        @else
                                            ₹{{ number_format($shipping ?? 50, 2) }}
                                        @endif
                                    </span>
                                </div>

                                @php
                                    $tax = $subtotal * 0.18;
                                    $shippingCost = $subtotal >= 1000 ? 0 : ($shipping ?? 50);
                                    $total = $subtotal + $shippingCost + $tax;
                                @endphp

                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Tax (18%)</span>
                                    <span class="fw-bold" id="cart-tax">
                                        ₹{{ number_format($tax, 2) }}
                                    </span>
                                </div>

                                <div class="d-flex justify-content-between mb-3">
                                    <span class="text-muted">Discount</span>
                                    <span class="text-success fw-bold" id="cart-discount">
                                        -₹0.00
                                    </span>
                                </div>

                                <hr>

                                <div class="d-flex justify-content-between">
                                    <span class="h5 fw-bold">Total Amount</span>
                                    <span class="h4 fw-bold text-primary" id="cart-total">
                                        ₹{{ number_format($total, 2) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Checkout Button -->
                            <div class="d-grid mb-3">
                                <a href="{{ route('checkout') }}" class="btn btn-primary btn-lg">
                                    <i class="fas fa-lock me-2"></i>
                                    Proceed to Checkout
                                </a>
                            </div>

                            <!-- Payment Methods -->
                            <div class="text-center mb-3">
                                <p class="text-muted small mb-2">We accept:</p>
                                <div class="d-flex justify-content-center gap-2">
                                    <i class="fab fa-cc-visa fa-2x text-primary"></i>
                                    <i class="fab fa-cc-mastercard fa-2x text-danger"></i>
                                    <i class="fab fa-cc-paypal fa-2x text-info"></i>
                                </div>
                            </div>

                            <!-- Continue Shopping -->
                            <div class="text-center">
                                <a href="{{ route('home') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Continue Shopping
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty Cart -->
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-shopping-cart fa-4x text-muted"></i>
                </div>
                <h3 class="mb-3">Your cart is empty</h3>
                <p class="text-muted mb-4">Looks like you haven't added any products to your cart yet.</p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        <i class="fas fa-home me-2"></i> Go to Homepage
                    </a>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-store me-2"></i> Browse Products
                    </a>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('styles')
    <style>
        .quantity-input {
            -moz-appearance: textfield;
        }

        .quantity-input::-webkit-inner-spin-button,
        .quantity-input::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .input-group {
            width: 130px;
        }

        .input-group .btn {
            width: 40px;
        }

        .card {
            border-radius: 10px;
        }

        .table th {
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table td {
            vertical-align: middle;
        }

        @media (max-width: 768px) {
            .table-responsive {
                font-size: 0.9rem;
            }

            .input-group {
                width: 120px;
            }

            .table th,
            .table td {
                padding: 0.75rem 0.5rem;
            }
        }
    </style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Debug: Log cart routes
    console.log('Cart update route:', '{{ route("cart.update") }}');
    console.log('Cart remove route:', '{{ route("cart.remove") }}');
    console.log('Cart clear route:', '{{ route("cart.clear") }}');

    // Increase quantity
    $('.increase-qty').click(function() {
        const productId = $(this).data('product-id');
        const input = $(`.quantity-input[data-product-id="${productId}"]`);
        let quantity = parseInt(input.val());
        const max = parseInt(input.attr('max'));

        if (quantity < max) {
            quantity++;
            input.val(quantity);
            updateCart(productId, quantity);
        }
    });

    // Decrease quantity
    $('.decrease-qty').click(function() {
        const productId = $(this).data('product-id');
        const input = $(`.quantity-input[data-product-id="${productId}"]`);
        let quantity = parseInt(input.val());
        const min = parseInt(input.attr('min'));

        if (quantity > min) {
            quantity--;
            input.val(quantity);
            updateCart(productId, quantity);
        }
    });

    // Remove item
    $('.remove-item').click(function() {
        const productId = $(this).data('product-id');
        const productName = $(this).closest('tr').find('h6').text().trim();

        if (confirm(`Remove "${productName}" from cart?`)) {
            removeFromCart(productId);
        }
    });

    // Clear cart
    $('#clear-cart-btn').click(function() {
        if (confirm('Are you sure you want to clear your cart?')) {
            clearCart();
        }
    });

    // Apply promo code
    $('#apply-promo').click(function() {
        const promoCode = $('#promo-code').val().trim();
        if (!promoCode) {
            alert('Please enter a promo code');
            return;
        }

        // Demo promo codes
        if (promoCode === 'SAVE10') {
            applyDiscount(10);
            alert('Promo code applied! 10% discount added.');
        } else if (promoCode === 'SAVE20') {
            applyDiscount(20);
            alert('Promo code applied! 20% discount added.');
        } else {
            alert('Invalid promo code');
        }
    });

    // Cart functions
    function updateCart(productId, quantity) {
        console.log('Updating cart:', { productId, quantity });

        $.ajax({
            url: '{{ route("cart.update") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                product_id: productId,
                quantity: quantity
            },
            success: function(response) {
                console.log('Update success:', response);
                if (response.success) {
                    // Update item total
                    const price = parseFloat($(`#cart-row-${productId} .item-price`).data('price'));
                    const itemTotal = price * quantity;
                    $(`#item-total-${productId}`).text('₹' + itemTotal.toFixed(2));

                    // Update cart totals
                    updateCartTotals(response);

                    // Update cart count
                    updateCartCount(response.cart_count);
                } else {
                    alert(response.message || 'Error updating cart');
                }
            },
            error: function(xhr, status, error) {
                console.error('Update error:', xhr.responseText);

                // Fallback: Update locally if AJAX fails
                const price = parseFloat($(`#cart-row-${productId} .item-price`).data('price'));
                const itemTotal = price * quantity;
                $(`#item-total-${productId}`).text('₹' + itemTotal.toFixed(2));

                // Recalculate totals locally
                recalculateTotals();

                alert('Note: Cart updated locally. Please refresh page for server sync.');
            }
        });
    }

    function removeFromCart(productId) {
        console.log('Removing from cart:', productId);

        $.ajax({
            url: '{{ route("cart.remove") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                product_id: productId
            },
            success: function(response) {
                console.log('Remove success:', response);
                if (response.success) {
                    // Remove row
                    $(`#cart-row-${productId}`).fadeOut(300, function() {
                        $(this).remove();

                        // Update totals
                        updateCartTotals(response);

                        // Update cart count
                        updateCartCount(response.cart_count);

                        // Reload if cart is empty
                        if (response.cart_count === 0) {
                            location.reload();
                        }
                    });
                } else {
                    alert(response.message || 'Error removing item');
                }
            },
            error: function(xhr, status, error) {
                console.error('Remove error:', xhr.responseText);
                alert('Error removing item. Please try again.');
            }
        });
    }

    function clearCart() {
        console.log('Clearing cart');

        $.ajax({
            url: '{{ route("cart.clear") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log('Clear success:', response);
                if (response.success) {
                    location.reload();
                } else {
                    alert(response.message || 'Error clearing cart');
                }
            },
            error: function(xhr, status, error) {
                console.error('Clear error:', xhr.responseText);
                alert('Error clearing cart. Please try again.');
            }
        });
    }

    function applyDiscount(percentage) {
        const subtotal = parseFloat($('#cart-subtotal').text().replace('₹', '').replace(',', ''));
        const discount = (subtotal * percentage) / 100;

        // Update discount display
        $('#cart-discount').text('-₹' + discount.toFixed(2));

        // Calculate new total
        const shipping = $('#cart-shipping').text().includes('FREE') ? 0 :
                       parseFloat($('#cart-shipping').text().replace('₹', '').replace(',', ''));
        const tax = parseFloat($('#cart-tax').text().replace('₹', '').replace(',', ''));
        const newTotal = subtotal + shipping + tax - discount;

        // Update total
        $('#cart-total').text('₹' + newTotal.toFixed(2));
    }

    function updateCartTotals(response) {
        $('#cart-subtotal').text('₹' + response.subtotal.toFixed(2));

        if (response.shipping === 0) {
            $('#cart-shipping').html('<span class="text-success">FREE</span>');
        } else {
            $('#cart-shipping').text('₹' + response.shipping.toFixed(2));
        }

        $('#cart-tax').text('₹' + response.tax.toFixed(2));
        $('#cart-total').text('₹' + response.total.toFixed(2));
    }

    function recalculateTotals() {
        let subtotal = 0;

        // Calculate subtotal from all items
        $('.item-total').each(function() {
            const total = parseFloat($(this).text().replace('₹', '').replace(',', ''));
            subtotal += total;
        });

        // Update subtotal
        $('#cart-subtotal').text('₹' + subtotal.toFixed(2));

        // Calculate shipping
        const shipping = subtotal >= 1000 ? 0 : 50;
        if (shipping === 0) {
            $('#cart-shipping').html('<span class="text-success">FREE</span>');
        } else {
            $('#cart-shipping').text('₹' + shipping.toFixed(2));
        }

        // Calculate tax (18%)
        const tax = subtotal * 0.18;
        $('#cart-tax').text('₹' + tax.toFixed(2));

        // Calculate total
        const total = subtotal + shipping + tax;
        $('#cart-total').text('₹' + total.toFixed(2));
    }

    function updateCartCount(count) {
        // Update cart count badge
        $('#cart-item-count').text(count);
        $('.cart-count-badge, .cart-count').text(count);
        if (count === 0) {
            $('.cart-count').hide();
        } else {
            $('.cart-count').show();
        }
    }
});
</script>
@endpush
