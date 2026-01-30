<div class="order-summary-items p-3 p-md-4">
    <!-- Order Items -->
    <h6 class="fw-bold mb-3 text-dark-green">
        <i class="fas fa-boxes me-2"></i>Order Items ({{ count($cart) }})
    </h6>
    @foreach ($cart as $item)
        <div class="order-item">
            <div class="d-flex align-items-center">
                @if ($item['image'])
                    <img src="{{ asset('storage/' . $item['image']) }}"
                         class="order-item-img me-3"
                         style="width: 60px; height: 60px; object-fit: cover;"
                         alt="{{ $item['name'] }}">
                @else
                    <div class="order-item-img bg-light rounded d-flex align-items-center justify-content-center me-3"
                         style="width: 60px; height: 60px;">
                        <i class="fas fa-image text-muted fa-lg"></i>
                    </div>
                @endif
                <div class="flex-grow-1">
                    <h6 class="fw-bold mb-1 small">{{ Str::limit($item['name'], 30) }}</h6>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">Qty: {{ $item['quantity'] }}</small>
                            <small class="text-muted ms-2">@ ₹{{ number_format($item['price'], 2) }}</small>
                        </div>
                        <span class="fw-bold text-primary">₹{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="border-top p-3 p-md-4">
    <!-- Price Breakdown -->
    <h6 class="fw-bold mb-3 text-dark-green">
        <i class="fas fa-calculator me-2"></i>Price Breakdown
    </h6>
    <div class="price-breakdown">
        <div class="d-flex justify-content-between mb-2">
            <span class="text-muted">Subtotal</span>
            <span class="fw-bold">₹{{ number_format($subtotal, 2) }}</span>
        </div>
        <div class="d-flex justify-content-between mb-2">
            <span class="text-muted">Shipping</span>
            <span class="fw-bold">
                @if($shipping == 0)
                    <span class="badge bg-success">FREE</span>
                @else
                    ₹{{ number_format($shipping, 2) }}
                @endif
            </span>
        </div>
        <div class="d-flex justify-content-between mb-2">
            <span class="text-muted">Tax (18%)</span>
            <span class="fw-bold">₹{{ number_format($subtotal * 0.18, 2) }}</span>
        </div>
        @php
            $discount = 0; // Add discount logic if you have
        @endphp
        @if($discount > 0)
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Discount</span>
                <span class="text-success fw-bold">-₹{{ number_format($discount, 2) }}</span>
            </div>
        @endif
        <hr class="my-3">
        <div class="d-flex justify-content-between align-items-center">
            <span class="h5 fw-bold text-dark-green">Total Amount</span>
            <span class="h4 fw-bold text-primary">₹{{ number_format($total, 2) }}</span>
        </div>
        <div class="text-end mt-1">
            <small class="text-muted">Inclusive of all taxes</small>
        </div>
    </div>
</div>

<div class="border-top p-3 p-md-4">
    <!-- Security Info -->
    <div class="bg-light rounded-3 p-3 mb-3">
        <div class="d-flex align-items-center mb-2">
            <i class="fas fa-shield-alt text-success me-2"></i>
            <span class="fw-bold small">Secure Payment</span>
        </div>
        <p class="small text-muted mb-0">
            Your payment information is encrypted and secure. We never store your card details.
        </p>
    </div>

    <!-- Terms Agreement -->
    <div class="form-check mb-4">
        <input class="form-check-input"
               type="checkbox"
               id="terms"
               style="width: 18px; height: 18px;">
        <label class="form-check-label small ms-2" for="terms">
            I agree to the
            <a href="#" class="text-primary text-decoration-none">Terms & Conditions</a>
            and
            <a href="#" class="text-primary text-decoration-none">Privacy Policy</a>
        </label>
    </div>

    <!-- Place Order Button -->
    <button type="button"
            class="btn btn-primary btn-pulse btn-place-order w-100 py-3 fw-bold">
        <span class="button-text">Place Order & Pay</span>
    </button>

    <!-- Back to Cart -->
    <div class="text-center mt-3">
        <a href="{{ route('cart.index') }}" class="btn btn-outline-primary btn-sm">
            <i class="fas fa-arrow-left me-2"></i>
            Back to Cart
        </a>
    </div>
</div>
