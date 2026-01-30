@extends('frontend.layouts.app')

@section('title', 'Order Confirmation')

@section('content')
    <!-- Success Header -->
    <div class="container-fluid py-5 bg-success bg-opacity-10">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <!-- Success Icon -->
                    <div class="mb-4">
                        <div class="success-icon">
                            <i class="fas fa-check-circle fa-5x text-success"></i>
                        </div>
                    </div>

                    <h1 class="display-5 fw-bold text-success mb-3">
                        Order Placed Successfully!
                    </h1>
                    <p class="lead text-muted mb-4">
        Thank you for your purchase! Your order has been confirmed.
                    </p>

                    <!-- Order Details -->
                    <div class="d-inline-flex flex-wrap align-items-center bg-white rounded-pill px-4 py-3 shadow-sm mb-3 gap-3">
                        <div class="text-center">
                            <span class="text-muted small d-block">Order ID</span>
                            <span class="fw-bold fs-5">{{ $order->order_number }}</span>
                        </div>
                        <div class="vr d-none d-md-block"></div>
                        <div class="text-center">
                            <span class="text-muted small d-block">Order Date</span>
                            <span class="fw-bold">{{ $order->created_at->format('d M Y, h:i A') }}</span>
                        </div>
                        <div class="vr d-none d-md-block"></div>
                        <div class="text-center">
                            <span class="text-muted small d-block">Status</span>
                            <span class="badge bg-success px-3 py-2">{{ ucfirst($order->status) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container py-5">
        <div class="row g-4">
            <!-- Left Column - Order Details -->
            <div class="col-lg-8">
                <!-- Order Status -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-4 border-bottom">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-truck me-2 text-primary"></i>
                            Order Status
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="progress mb-3" style="height: 10px;">
                            <div class="progress-bar bg-success" style="width: 25%;"></div>
                        </div>
                        <div class="row text-center">
                            <div class="col-3">
                                <div class="step completed">
                                    <i class="fas fa-shopping-cart fa-2x mb-2"></i>
                                    <p class="mb-0 small fw-bold">Ordered</p>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="step">
                                    <i class="fas fa-cog fa-2x mb-2 text-muted"></i>
                                    <p class="mb-0 small text-muted">Processing</p>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="step">
                                    <i class="fas fa-shipping-fast fa-2x mb-2 text-muted"></i>
                                    <p class="mb-0 small text-muted">Shipped</p>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="step">
                                    <i class="fas fa-check-double fa-2x mb-2 text-muted"></i>
                                    <p class="mb-0 small text-muted">Delivered</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer & Shipping -->
                <div class="row g-4 mb-4">
                    <!-- Customer Details -->
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white py-3">
                                <h6 class="mb-0 fw-bold">
                                    <i class="fas fa-user me-2 text-primary"></i>
                                    Customer Details
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-2">
                                    <strong>{{ $order->full_name }}</strong>
                                </div>
                                <div class="mb-2">
                                    <i class="fas fa-envelope me-2 text-muted"></i>
                                    {{ $order->email }}
                                </div>
                                <div>
                                    <i class="fas fa-phone me-2 text-muted"></i>
                                    {{ $order->phone }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white py-3">
                                <h6 class="mb-0 fw-bold">
                                    <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                                    Shipping Address
                                </h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">{{ $order->address_full }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-4 border-bottom">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-boxes me-2 text-primary"></i>
                            Order Items
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 ps-4">Product</th>
                                        <th class="border-0 text-center">Price</th>
                                        <th class="border-0 text-center">Quantity</th>
                                        <th class="border-0 text-center pe-4">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                    <tr>
                                        <td class="ps-4">
                                            <strong>{{ $item->product_name }}</strong>
                                        </td>
                                        <td class="text-center">
                                            <span class="fw-bold">₹{{ number_format($item->price, 2) }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                                                {{ $item->quantity }}
                                            </span>
                                        </td>
                                        <td class="text-center pe-4">
                                            <span class="fw-bold text-primary">₹{{ number_format($item->total, 2) }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Order Summary -->
            <div class="col-lg-4">
                <div class="sticky-sidebar">
                    <!-- Order Summary -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-primary text-white py-4">
                            <h5 class="mb-0 fw-bold">
                                <i class="fas fa-receipt me-2"></i>
                                Order Summary
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <!-- Payment Info -->
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3">
                                    <i class="fas fa-credit-card me-2"></i>
                                    Payment Information
                                </h6>
                                <div class="bg-light rounded-3 p-3">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Method:</span>
                                        <span class="fw-bold">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">Status:</span>
                                        <span class="badge bg-success">Paid</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Price Breakdown -->
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3">
                                    <i class="fas fa-calculator me-2"></i>
                                    Price Breakdown
                                </h6>
                                <div class="price-breakdown">
                                    @php
                                        $subtotal = $order->items->sum('total');
                                        $tax = $subtotal * 0.18;
                                        $shipping = $order->shipping_cost ?? 0;
                                    @endphp

                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Subtotal</span>
                                        <span class="fw-bold">₹{{ number_format($subtotal, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Shipping</span>
                                        <span class="fw-bold">
                                            @if($shipping == 0)
                                                <span class="text-success">FREE</span>
                                            @else
                                                ₹{{ number_format($shipping, 2) }}
                                            @endif
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Tax (18%)</span>
                                        <span class="fw-bold">₹{{ number_format($tax, 2) }}</span>
                                    </div>
                                    @if($order->discount > 0)
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Discount</span>
                                        <span class="text-success fw-bold">-₹{{ number_format($order->discount, 2) }}</span>
                                    </div>
                                    @endif
                                    <hr class="my-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="h5 fw-bold">Total Amount</span>
                                        <span class="h4 fw-bold text-primary">₹{{ number_format($order->total, 2) }}</span>
                                    </div>
                                    <div class="text-end mt-1">
                                        <small class="text-muted">Inclusive of all taxes</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Delivery Info -->
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3">
                                    <i class="fas fa-truck me-2"></i>
                                    Delivery Information
                                </h6>
                                <div class="bg-light rounded-3 p-3">
                                    <p class="mb-2">
                                        <i class="fas fa-clock me-2 text-warning"></i>
                                        <strong>Estimated Delivery:</strong>
                                    </p>
                                    <p class="mb-0 text-center">
                                        <span class="fw-bold">{{ now()->addDays(5)->format('d M, Y') }}</span>
                                    </p>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-grid gap-2">
                                <a href="{{ route('home') }}" class="btn btn-primary">
                                    <i class="fas fa-shopping-bag me-2"></i>
                                    Continue Shopping
                                </a>
                                <button onclick="window.print()" class="btn btn-outline-primary">
                                    <i class="fas fa-print me-2"></i>
                                    Print Invoice
                                </button>
                                <a href="{{ url('/') }}" class="btn btn-outline-success">
                                    <i class="fas fa-home me-2"></i>
                                    Back to Home
                                </a>
                            </div>

                            <!-- Help Section -->
                            <div class="mt-4 text-center">
                                <p class="text-muted small mb-2">Need help with your order?</p>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="mailto:support@example.com" class="btn btn-link text-decoration-none p-0">
                                        <i class="fas fa-envelope me-1"></i>
                                        Email
                                    </a>
                                    <span class="text-muted">|</span>
                                    <a href="tel:+911234567890" class="btn btn-link text-decoration-none p-0">
                                        <i class="fas fa-phone me-1"></i>
                                        Call
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Thank You Note -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-3 text-center">
                            <i class="fas fa-heart text-danger fa-2x mb-2"></i>
                            <p class="small text-muted mb-0">
                                Thank you for shopping with us! We appreciate your business.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Banner -->
    <div class="container-fluid py-4 bg-light border-top">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h6 class="fw-bold mb-1">Order confirmation sent to {{ $order->email }}</h6>
                    <p class="text-muted small mb-0">
                        Check your email for order details and tracking information.
                    </p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="{{ route('home') }}" class="btn btn-outline-primary">
                        <i class="fas fa-store me-1"></i>
                        Shop More Products
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    /* Custom Variables */
    :root {
        --primary-color: #6BB252;
        --primary-light: rgba(107, 178, 82, 0.1);
        --success-color: #28a745;
    }

    /* Success Icon */
    .success-icon {
        animation: bounceIn 1s ease;
    }

    @keyframes bounceIn {
        0% {
            transform: scale(0.3);
            opacity: 0;
        }
        50% {
            transform: scale(1.05);
        }
        70% {
            transform: scale(0.9);
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    /* Progress Steps */
    .step {
        position: relative;
    }

    .step.completed i {
        color: var(--primary-color);
    }

    .step:not(.completed) i {
        color: #dee2e6;
    }

    /* Badge */
    .badge.bg-primary.bg-opacity-10 {
        background-color: var(--primary-light) !important;
        color: var(--primary-color) !important;
        border: 1px solid var(--primary-light);
    }

    /* Card Styling */
    .card {
        border-radius: 12px;
        border: none;
    }

    .card-header {
        border-radius: 12px 12px 0 0 !important;
    }

    /* Table Styling */
    .table th {
        font-weight: 600;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6c757d;
    }

    .table td {
        vertical-align: middle;
        padding: 1rem 0.75rem;
    }

    /* Sticky Sidebar */
    @media (min-width: 992px) {
        .sticky-sidebar {
            position: sticky;
            top: 20px;
        }
    }

    /* Responsive Design */
    @media (max-width: 991.98px) {
        .display-5 {
            font-size: 2.5rem !important;
        }

        .d-inline-flex.flex-wrap {
            flex-direction: column;
            gap: 1rem !important;
        }

        .d-inline-flex.flex-wrap .vr {
            display: none !important;
        }
    }

    @media (max-width: 767.98px) {
        .display-5 {
            font-size: 2rem !important;
        }

        .table-responsive {
            font-size: 0.9rem;
        }

        .container-fluid.py-5 {
            padding-top: 2rem !important;
            padding-bottom: 2rem !important;
        }
    }

    @media (max-width: 575.98px) {
        .success-icon i {
            font-size: 4rem !important;
        }

        .step i.fa-2x {
            font-size: 1.5rem !important;
        }

        .row.text-center .col-3 {
            padding: 0 0.25rem;
        }

        .btn {
            padding: 0.75rem 1rem !important;
        }
    }

    /* Print Styles */
    @media print {
        .container-fluid.bg-success,
        .btn,
        .bottom-banner {
            display: none !important;
        }

        .card {
            border: 1px solid #dee2e6 !important;
            box-shadow: none !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Print functionality
        $('.btn-print').click(function() {
            window.print();
        });

        // Add animation to success icon
        setTimeout(function() {
            $('.success-icon').addClass('animated');
        }, 100);

        // Show order details on mobile
        $('.order-details-mobile').click(function() {
            $('.order-details-collapse').slideToggle();
        });
    });
</script>
@endpush
