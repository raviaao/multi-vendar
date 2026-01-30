<!-- Order Items -->
<h6 class="fw-bold mb-3">Order Items ({{ count($cart) }})</h6>
@foreach ($cart as $item)
    <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
        @if ($item['image'])
            <img src="{{ asset('storage/' . $item['image']) }}" class="img-fluid rounded me-3"
                style="width: 60px; height: 60px; object-fit: cover;" alt="{{ $item['name'] }}">
        @else
            <div class="bg-light rounded d-flex align-items-center justify-content-center me-3"
                style="width: 60px; height: 60px;">
                <i class="fas fa-image text-muted"></i>
            </div>
        @endif
        <div class="flex-grow-1">
            <h6 class="fw-bold mb-1 small">{{ $item['name'] }}</h6>
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">Qty: {{ $item['quantity'] }}</small>
                <span class="fw-bold text-primary">₹{{ $item['price'] * $item['quantity'] }}</span>
            </div>
        </div>
    </div>
@endforeach

<!-- Price Breakdown -->
<h6 class="fw-bold mb-3">Price Breakdown</h6>
<div class="d-flex justify-content-between mb-2">
    <span class="text-muted">Subtotal</span>
    <span class="fw-bold">₹{{ number_format($subtotal, 2) }}</span>
</div>
<div class="d-flex justify-content-between mb-2">
    <span class="text-muted">Shipping</span>
    <span class="fw-bold">
        @if ($shipping == 0)
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
<hr class="my-3">
<div class="d-flex justify-content-between align-items-center mb-4">
    <span class="h5 fw-bold">Total Amount</span>
    <span class="h4 fw-bold text-primary">₹{{ number_format($total, 2) }}</span>
</div>

<!-- Terms Agreement -->
<div class="form-check">
    <input class="form-check-input" type="checkbox" value="" id="terms" required>
    <label class="form-check-label small" for="terms">
        I agree to the <a href="#" class="text-decoration-none">Terms & Conditions</a>
    </label>
</div>

<!-- Place Order Button -->
 <button type="button"
            class="btn btn-primary btn-lg w-100 btn-place-order"
            style="height: 50px;">
        <span class="button-text fw-bold">
            <i class="fas fa-lock me-2"></i>
            Place Order
        </span>
    </button>
