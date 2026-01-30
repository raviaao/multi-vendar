@extends('frontend.layouts.app')

@section('title', 'Checkout')

@section('content')
    <!-- Page Header -->
    <div class="container-fluid py-4 bg-light-green">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-dark">
                                <i class="fas fa-home me-1"></i> Home
                            </a></li>
                            <li class="breadcrumb-item"><a href="{{ route('cart.index') }}" class="text-decoration-none text-dark">
                                <i class="fas fa-shopping-cart me-1"></i> Cart
                            </a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <i class="fas fa-check-circle me-1"></i> Checkout
                            </li>
                        </ol>
                    </nav>
                    <h1 class="h2 fw-bold mt-2 text-dark-green mb-0">Secure Checkout</h1>
                    <p class="text-muted">Complete your purchase in a few simple steps</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="d-inline-flex align-items-center bg-white rounded-pill px-3 py-2 shadow-sm">
                        <i class="fas fa-shield-alt text-success me-2"></i>
                        <span class="fw-medium me-2">Secure</span>
                        <span class="badge bg-success rounded-pill">
                            <i class="fas fa-lock me-1"></i> SSL
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Steps -->
    {{-- <div class="container-fluid bg-white border-bottom py-3 d-none d-md-block">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="steps">
                        <div class="step completed">
                            <div class="step-icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <span class="step-label">Cart</span>
                        </div>
                        <div class="step active">
                            <div class="step-icon">
                                <i class="fas fa-user-edit"></i>
                            </div>
                            <span class="step-label">Details</span>
                        </div>
                        <div class="step">
                            <div class="step-icon">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <span class="step-label">Payment</span>
                        </div>
                        <div class="step">
                            <div class="step-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <span class="step-label">Complete</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Main Content -->
    <div class="container py-4">
        <div class="row g-4">
            <!-- Left Column - Form -->
            <div class="col-lg-8">
                <!-- Mobile Progress Steps -->
                <div class="card border-0 shadow-sm mb-4 d-block d-md-none">
                    <div class="card-body p-3">
                        <div class="steps-mobile">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-center">
                                    <div class="step-mobile-icon completed">
                                        <i class="fas fa-shopping-cart"></i>
                                    </div>
                                    <small class="step-mobile-label">Cart</small>
                                </div>
                                <div class="step-line"></div>
                                <div class="text-center">
                                    <div class="step-mobile-icon active">
                                        <i class="fas fa-user-edit"></i>
                                    </div>
                                    <small class="step-mobile-label">Details</small>
                                </div>
                                <div class="step-line"></div>
                                <div class="text-center">
                                    <div class="step-mobile-icon">
                                        <i class="fas fa-credit-card"></i>
                                    </div>
                                    <small class="step-mobile-label">Payment</small>
                                </div>
                                <div class="step-line"></div>
                                <div class="text-center">
                                    <div class="step-mobile-icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <small class="step-mobile-label">Complete</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ✅ FORM START --}}
                <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
                    @csrf

                    <!-- Billing Details -->
                    <div class="card border-0 shadow-sm rounded-3 mb-4">
                        <div class="card-header bg-primary text-white py-3">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-user-circle fa-lg"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0 fw-bold">Billing Information</h5>
                                    <small class="opacity-75">Enter your contact and shipping details</small>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-3 p-md-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">
                                        <i class="fas fa-user me-1 text-primary"></i>First Name *
                                    </label>
                                    <input type="text"
                                           name="first_name"
                                           class="form-control border-2"
                                           value="{{ old('first_name', explode(' ', $user->name)[0] ?? '') }}"
                                           placeholder="Enter first name"
                                           required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">
                                        <i class="fas fa-user me-1 text-primary"></i>Last Name *
                                    </label>
                                    <input type="text"
                                           name="last_name"
                                           class="form-control border-2"
                                           value="{{ old('last_name', explode(' ', $user->name)[1] ?? '') }}"
                                           placeholder="Enter last name"
                                           required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">
                                        <i class="fas fa-envelope me-1 text-primary"></i>Email Address *
                                    </label>
                                    <input type="email"
                                           name="email"
                                           class="form-control border-2"
                                           value="{{ old('email', $user->email) }}"
                                           placeholder="Enter email"
                                           required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">
                                        <i class="fas fa-phone me-1 text-primary"></i>Phone Number *
                                    </label>
                                    <input type="tel"
                                           name="phone"
                                           class="form-control border-2"
                                           value="{{ old('phone', $user->phone ?? '') }}"
                                           placeholder="Enter phone number"
                                           required>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-medium">
                                        <i class="fas fa-map-marker-alt me-1 text-primary"></i>Complete Address *
                                    </label>
                                    <textarea name="address"
                                              class="form-control border-2"
                                              placeholder="Enter your complete address"
                                              rows="3"
                                              required>{{ old('address') }}</textarea>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-medium">
                                        <i class="fas fa-city me-1 text-primary"></i>City *
                                    </label>
                                    <input type="text"
                                           name="city"
                                           class="form-control border-2"
                                           value="{{ old('city') }}"
                                           placeholder="Enter city"
                                           required>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-medium">
                                        <i class="fas fa-landmark me-1 text-primary"></i>State *
                                    </label>
                                    <input type="text"
                                           name="state"
                                           class="form-control border-2"
                                           value="{{ old('state') }}"
                                           placeholder="Enter state"
                                           required>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-medium">
                                        <i class="fas fa-mail-bulk me-1 text-primary"></i>ZIP Code *
                                    </label>
                                    <input type="text"
                                           name="zip_code"
                                           class="form-control border-2"
                                           value="{{ old('zip_code') }}"
                                           placeholder="Enter ZIP code"
                                           required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="card border-0 shadow-sm rounded-3 mb-4">
                        <div class="card-header bg-primary text-white py-3">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-credit-card fa-lg"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0 fw-bold">Payment Method</h5>
                                    <small class="opacity-75">Choose how you want to pay</small>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-3 p-md-4">
                            <div class="row g-3">
                                <!-- Cash on Delivery -->
                                <div class="col-md-6">
                                    <div class="payment-option-card">
                                        <input class="form-check-input d-none"
                                               type="radio"
                                               name="payment_method"
                                               value="cod"
                                               id="cod"
                                               checked>
                                        <label class="payment-label w-100 m-0" for="cod">
                                            <div class="d-flex align-items-center p-3 border rounded-3 h-100">
                                                <div class="me-3">
                                                    <div class="payment-icon bg-primary bg-opacity-10 text-primary rounded-2">
                                                        <i class="fas fa-money-bill-wave"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="fw-bold mb-1">Cash on Delivery</h6>
                                                    <p class="small text-muted mb-0">Pay when you receive your order</p>
                                                </div>
                                                <div class="ms-2">
                                                    <i class="fas fa-check-circle text-primary"></i>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <!-- Online Payment -->
                                <div class="col-md-6">
                                    <div class="payment-option-card">
                                        <input class="form-check-input d-none"
                                               type="radio"
                                               name="payment_method"
                                               value="razorpay"
                                               id="razorpay">
                                        <label class="payment-label w-100 m-0" for="razorpay">
                                            <div class="d-flex align-items-center p-3 border rounded-3 h-100">
                                                <div class="me-3">
                                                    <div class="payment-icon bg-success bg-opacity-10 text-success rounded-2">
                                                        <i class="fas fa-globe"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="fw-bold mb-1">Online Payment</h6>
                                                    <p class="small text-muted mb-0">Pay securely with UPI / Card</p>
                                                </div>
                                                <div class="ms-2">
                                                    <i class="fas fa-check-circle text-muted"></i>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <!-- Payment Methods Icons -->
                                <div class="col-12 mt-3">
                                    <div class="border-top pt-3">
                                        <p class="text-muted small mb-2">We accept:</p>
                                        <div class="d-flex flex-wrap gap-3">
                                            <div class="text-center">
                                                <i class="fab fa-cc-visa fa-2x text-primary"></i>
                                                <div class="mt-1">
                                                    <span class="badge bg-primary bg-opacity-10 text-primary small">Visa</span>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <i class="fab fa-cc-mastercard fa-2x text-danger"></i>
                                                <div class="mt-1">
                                                    <span class="badge bg-danger bg-opacity-10 text-danger small">Mastercard</span>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <i class="fab fa-cc-amex fa-2x text-info"></i>
                                                <div class="mt-1">
                                                    <span class="badge bg-info bg-opacity-10 text-info small">Amex</span>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <i class="fab fa-cc-paypal fa-2x text-primary"></i>
                                                <div class="mt-1">
                                                    <span class="badge bg-primary bg-opacity-10 text-primary small">PayPal</span>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <i class="fas fa-university fa-2x text-success"></i>
                                                <div class="mt-1">
                                                    <span class="badge bg-success bg-opacity-10 text-success small">Net Banking</span>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <i class="fas fa-mobile-alt fa-2x text-warning"></i>
                                                <div class="mt-1">
                                                    <span class="badge bg-warning bg-opacity-10 text-warning small">UPI</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Notes -->
                    <div class="card border-0 shadow-sm rounded-3 mb-4">
                        <div class="card-header bg-primary text-white py-3">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-sticky-note fa-lg"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0 fw-bold">Additional Instructions</h5>
                                    <small class="opacity-75">Add notes about your order (optional)</small>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-3 p-md-4">
                            <label class="form-label fw-medium">
                                <i class="fas fa-edit me-1 text-primary"></i>Special instructions for delivery
                            </label>
                            <textarea name="notes"
                                      class="form-control border-2"
                                      placeholder="E.g., Delivery timing preferences, doorbell instructions, etc."
                                      rows="3">{{ old('notes') }}</textarea>
                            <div class="mt-2">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Optional: Add any special delivery instructions
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden Razorpay Fields -->
                    <input type="hidden" id="razorpay_payment_id" name="razorpay_payment_id">
                    <input type="hidden" id="razorpay_order_id" name="razorpay_order_id">
                    <input type="hidden" id="razorpay_signature" name="razorpay_signature">
                </form>
                {{-- ✅ FORM END --}}
            </div>

            <!-- Right Column - Order Summary -->
            <div class="col-lg-4">
                <!-- Mobile Order Summary -->
                <div class="card border-0 shadow-sm mb-4 d-block d-lg-none">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-receipt me-2"></i>
                            Order Summary
                        </h5>
                    </div>
                    <div class="card-body">
                        @include('frontend.checkout.partials.order-summary-mobile')
                    </div>
                </div>

                <!-- Desktop Order Summary -->
                <div class="d-none d-lg-block">
                    <div class="order-summary-sidebar">
                        <div class="card border-0 shadow-sm rounded-3">
                            <div class="card-header bg-primary text-white py-3">
                                <h5 class="mb-0 fw-bold">
                                    <i class="fas fa-receipt me-2"></i>
                                    Order Summary
                                </h5>
                            </div>
                            <div class="card-body p-0">
                                @include('frontend.checkout.partials.order-summary-desktop')
                            </div>
                        </div>
                    </div>
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
        --primary-dark: #5a9e44;
        --dark-green: #364127;
        --light-green: #F8FFF5;
        --border-radius: 12px;
    }

    /* Background Colors */
    .bg-light-green {
        background-color: var(--light-green) !important;
    }

    .text-dark-green {
        color: var(--dark-green) !important;
    }

    /* Progress Steps - Desktop */
    .steps {
        display: flex;
        justify-content: space-between;
        position: relative;
        padding: 0 20px;
    }

    .steps::before {
        content: '';
        position: absolute;
        top: 25px;
        left: 20px;
        right: 20px;
        height: 3px;
        background: #e9ecef;
        z-index: 1;
    }

    .step {
        position: relative;
        z-index: 2;
        text-align: center;
        flex: 1;
    }

    .step-icon {
        width: 50px;
        height: 50px;
        background: #e9ecef;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 10px;
        font-size: 1.25rem;
        color: #6c757d;
        border: 3px solid white;
    }

    .step.completed .step-icon {
        background: var(--primary-color);
        color: white;
    }

    .step.active .step-icon {
        background: var(--primary-color);
        color: white;
        box-shadow: 0 0 0 5px var(--primary-light);
    }

    .step-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #6c757d;
        display: block;
    }

    .step.completed .step-label,
    .step.active .step-label {
        color: var(--primary-color);
    }

    /* Progress Steps - Mobile */
    .steps-mobile {
        padding: 10px 0;
    }

    .step-mobile-icon {
        width: 40px;
        height: 40px;
        background: #e9ecef;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 5px;
        font-size: 1rem;
        color: #6c757d;
    }

    .step-mobile-icon.completed {
        background: var(--primary-color);
        color: white;
    }

    .step-mobile-icon.active {
        background: var(--primary-color);
        color: white;
        box-shadow: 0 0 0 3px var(--primary-light);
    }

    .step-mobile-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #6c757d;
    }

    .step-line {
        flex: 1;
        height: 2px;
        background: #e9ecef;
        margin: 0 5px;
        align-self: flex-start;
        margin-top: 20px;
    }

    /* Form Styling */
    .form-control.border-2 {
        border-width: 2px !important;
        border-color: #dee2e6;
    }

    .form-control:focus {
        border-color: var(--primary-color) !important;
        box-shadow: 0 0 0 0.25rem rgba(107, 178, 82, 0.25) !important;
    }

    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    /* Payment Options */
    .payment-option-card {
        position: relative;
    }

    .payment-label {
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .payment-label:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .payment-option-card input:checked + .payment-label > div {
        border-color: var(--primary-color) !important;
        background-color: var(--primary-light);
        border-width: 2px;
    }

    .payment-option-card input:checked + .payment-label .fa-check-circle.text-muted {
        color: var(--primary-color) !important;
    }

    .payment-icon {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    /* Card Styling */
    .card {
        border: none;
    }

    .rounded-3 {
        border-radius: var(--border-radius) !important;
    }

    .card-header {
        border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
    }

    /* Order Summary Sidebar - Fixed for Desktop */
    @media (min-width: 992px) {
        .order-summary-sidebar {
            position: sticky;
            top: 100px; /* Leaves space for header */
            z-index: 100;
        }

        .order-summary-sidebar .card {
            max-height: calc(100vh - 120px);
            overflow-y: auto;
        }

        .order-summary-sidebar .card::-webkit-scrollbar {
            width: 6px;
        }

        .order-summary-sidebar .card::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .order-summary-sidebar .card::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 10px;
        }
    }

    /* Order Items */
    .order-item {
        border-bottom: 1px solid #eee;
        padding: 1rem 0;
    }

    .order-item:last-child {
        border-bottom: none;
    }

   .order-summary-img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
    flex-shrink: 0;
}


    .order-summary-items {
        max-height: 300px;
        overflow-y: auto;
        padding-right: 10px;
    }

    /* Price Breakdown */
    .price-breakdown .badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }

    /* Place Order Button */
    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        border: none;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, var(--primary-dark), var(--primary-color));
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(107, 178, 82, 0.3);
    }

    /* Loading Animation */
    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(107, 178, 82, 0.7);
        }
        70% {
            box-shadow: 0 0 0 10px rgba(107, 178, 82, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(107, 178, 82, 0);
        }
    }

    .btn-pulse {
        animation: pulse 2s infinite;
    }

    /* Responsive Design */
    @media (max-width: 1199.98px) {
        .steps {
            padding: 0 10px;
        }

        .steps::before {
            left: 10px;
            right: 10px;
        }

        .step-icon {
            width: 45px;
            height: 45px;
            font-size: 1.1rem;
        }
    }

    @media (max-width: 991.98px) {
        .steps {
            padding: 0;
        }

        .steps::before {
            display: none;
        }

        .step {
            flex: none;
            width: 25%;
        }

        .step-icon {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }

        .step-label {
            font-size: 0.75rem;
        }

        .payment-icon {
            width: 45px;
            height: 45px;
            font-size: 1.1rem;
        }
    }

    @media (max-width: 767.98px) {
        .container-fluid.py-4 {
            padding-top: 1.5rem !important;
            padding-bottom: 1.5rem !important;
        }

        .h2 {
            font-size: 1.75rem !important;
        }

        .card-body {
            padding: 1rem !important;
        }

        .payment-option-card {
            margin-bottom: 1rem;
        }

        .payment-option-card:last-child {
            margin-bottom: 0;
        }

        .step-mobile-icon {
            width: 35px;
            height: 35px;
            font-size: 0.9rem;
        }

        .step-mobile-label {
            font-size: 0.7rem;
        }

        .step-line {
            margin-top: 17.5px;
        }
    }

    @media (max-width: 575.98px) {
        .h2 {
            font-size: 1.5rem !important;
        }

        .card-header {
            padding: 0.75rem 1rem !important;
        }

        .card-header h5 {
            font-size: 1.1rem !important;
        }

        .payment-option-card .d-flex {
            flex-direction: column;
            text-align: center;
        }

        .payment-option-card .me-3 {
            margin-right: 0 !important;
            margin-bottom: 0.5rem;
        }

        .payment-option-card .ms-2 {
            margin-left: 0 !important;
            margin-top: 0.5rem;
        }

        .payment-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto;
        }

        .btn-lg {
            padding: 0.75rem 1.5rem !important;
            font-size: 1rem !important;
        }

        .order-summary-sidebar {
            margin-top: 1rem;
        }
    }

    /* Loading State */
    .btn-loading {
        position: relative;
        color: transparent !important;
    }

    .btn-loading::after {
        content: '';
        position: absolute;
        left: 50%;
        top: 50%;
        width: 20px;
        height: 20px;
        margin: -10px 0 0 -10px;
        border: 2px solid white;
        border-top-color: transparent;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    /* Validation States */
    .is-invalid {
        border-color: #dc3545 !important;
    }

    .invalid-feedback {
        display: none;
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .is-invalid + .invalid-feedback {
        display: block;
    }
</style>
@endpush

@push('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
   $(document).ready(function() {
    // Update button text based on payment method
    $('input[name="payment_method"]').change(function() {
        const method = $(this).val();
        const buttonText = $('.btn-place-order .button-text');

        // Update check icons
        $('.payment-option-card .fa-check-circle').removeClass('text-primary').addClass('text-muted');
        $(this).closest('.payment-option-card').find('.fa-check-circle').removeClass('text-muted').addClass('text-primary');

        // Update button text
        if (method === 'cod') {
            buttonText.html('<i class="fas fa-lock me-2"></i>Place Order');
        } else {
            buttonText.html('<i class="fas fa-credit-card me-2"></i>Place Order & Pay');
        }
    });

    // Place order button handler
    $(document).on('click', '.btn-place-order', function(e) {
        e.preventDefault();
        handlePlaceOrder();
    });

    function handlePlaceOrder() {
        const button = $('.btn-place-order');
        const buttonText = button.find('.button-text');

        // Check if we're on desktop or mobile
        const isDesktop = window.innerWidth >= 992;

        // Desktop: Check terms-desktop, Mobile: Check terms
        const termsCheckboxId = isDesktop ? '#terms-desktop' : '#terms';
        const termsCheckbox = $(termsCheckboxId);

        if (termsCheckbox.length && !termsCheckbox.is(':checked')) {
            Swal.fire({
                icon: 'warning',
                title: 'Terms Required',
                text: 'Please agree to the Terms & Conditions to proceed',
                confirmButtonColor: '#6BB252',
                confirmButtonText: 'Okay'
            });
            return;
        }

        // Validate form
        const form = $('#checkout-form')[0];
        if (!form.checkValidity()) {
            $(form).addClass('was-validated');
            const firstError = $(form).find(':invalid').first();
            if (firstError.length) {
                $('html, body').animate({
                    scrollTop: firstError.offset().top - 100
                }, 500);
            }
            return;
        }

        // Get selected payment method
        const method = $('input[name="payment_method"]:checked').val();

        // Show loading state
        button.addClass('btn-loading').prop('disabled', true);
        buttonText.html('<span class="spinner-border spinner-border-sm me-2"></span>Processing...');

        // Cash on Delivery
        if (method === 'cod') {
            setTimeout(() => {
                $('#checkout-form').submit();
            }, 1000);
            return;
        }

        // Razorpay Payment
        $.ajax({
            url: "{{ route('razorpay.create.order') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                amount: {{ $total * 100 }}
            },
            success: function(data) {
                if (!data.order_id) {
                    throw new Error('No order ID received');
                }

                const options = {
                    key: data.key,
                    amount: data.amount,
                    currency: "INR",
                    name: "{{ config('app.name') }}",
                    description: "Order Payment",
                    order_id: data.order_id,
                    theme: {
                        color: "#6BB252"
                    },
                    modal: {
                        ondismiss: function() {
                            // Reset button state
                            button.removeClass('btn-loading').prop('disabled', false);
                            const method = $('input[name="payment_method"]:checked').val();
                            buttonText.html(method === 'cod' ?
                                '<i class="fas fa-lock me-2"></i>Place Order' :
                                '<i class="fas fa-credit-card me-2"></i>Place Order & Pay');
                        }
                    },
                    handler: function(response) {
                        // Add Razorpay response to form
                        $('#razorpay_payment_id').val(response.razorpay_payment_id);
                        $('#razorpay_order_id').val(response.razorpay_order_id);
                        $('#razorpay_signature').val(response.razorpay_signature);

                        // Show processing message
                        buttonText.html('<span class="spinner-border spinner-border-sm me-2"></span>Verifying...');

                        // Submit form
                        setTimeout(() => {
                            $('#checkout-form').submit();
                        }, 1000);
                    },
                    prefill: {
                        name: $('input[name="first_name"]').val() + ' ' + $('input[name="last_name"]').val(),
                        email: $('input[name="email"]').val(),
                        contact: $('input[name="phone"]').val()
                    },
                    notes: {
                        address: $('textarea[name="address"]').val()
                    }
                };

                const razorpay = new Razorpay(options);
                razorpay.open();
            },
            error: function(xhr, status, error) {
                console.error('Razorpay error:', xhr.responseText);

                // Reset button state
                button.removeClass('btn-loading').prop('disabled', false);
                const method = $('input[name="payment_method"]:checked').val();
                buttonText.html(method === 'cod' ?
                    '<i class="fas fa-lock me-2"></i>Place Order' :
                    '<i class="fas fa-credit-card me-2"></i>Place Order & Pay');

                Swal.fire({
                    icon: 'error',
                    title: 'Payment Error',
                    html: 'Unable to initialize payment.<br>Please try again or choose Cash on Delivery.',
                    confirmButtonColor: '#6BB252',
                    confirmButtonText: 'Try Again'
                });
            }
        });
    }

    // Form validation
    $('#checkout-form').on('submit', function(e) {
        const form = this;
        if (!form.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();

            $(form).addClass('was-validated');

            // Scroll to first error
            const firstError = $(form).find(':invalid').first();
            if (firstError.length) {
                $('html, body').animate({
                    scrollTop: firstError.offset().top - 100
                }, 500);
            }
        }
    });

    // Auto-save form data
    $('input, textarea, select').on('input change', function() {
        localStorage.setItem('checkout_' + $(this).attr('name'), $(this).val());
    });

    // Load saved form data
    $('input, textarea, select').each(function() {
        const savedValue = localStorage.getItem('checkout_' + $(this).attr('name'));
        if (savedValue !== null && !$(this).val()) {
            $(this).val(savedValue);
        }
    });

    // Clear saved data on successful form submit
    $('#checkout-form').on('submit', function() {
        Object.keys(localStorage).forEach(key => {
            if (key.startsWith('checkout_')) {
                localStorage.removeItem(key);
            }
        });
    });

    // Make payment options more accessible
    $('.payment-label').on('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            $(this).find('input').prop('checked', true).trigger('change');
        }
    });
});
</script>
@endpush
