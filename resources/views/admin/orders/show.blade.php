@extends('admin.layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Order Details</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Orders</a></li>
                    <li class="breadcrumb-item active" aria-current="page">#{{ $order->order_number }}</li>
                </ol>
            </nav>
        </div>

        <div class="btn-group">
            <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-warning">
                <i class="fas fa-edit me-1"></i> Edit Order
            </a>
            <a href="{{ route('admin.orders.invoice', $order->id) }}" class="btn btn-secondary">
                <i class="fas fa-print me-1"></i> Print Invoice
            </a>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Order Summary -->
        <div class="col-lg-8 mb-4">
            <!-- Order Status Card -->
            <div class="card border-0 shadow mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <div class="p-3 rounded-circle bg-{{ $order->status_color }} bg-opacity-10">
                                        <i class="fas fa-shopping-cart fa-2x text-{{ $order->status_color }}"></i>
                                    </div>
                                </div>
                                <div>
                                    <h5 class="mb-1">Order #{{ $order->order_number }}</h5>
                                    <p class="text-muted mb-0">Placed on {{ $order->created_at->format('F d, Y h:i A') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end mt-3 mt-md-0">
                            <div class="mb-2">
                                <span class="badge bg-{{ $order->status_color }} p-3 fs-6">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                            <div>
                                <span class="badge bg-{{ $order->payment_status_color }} p-2">
                                    Payment: {{ ucfirst($order->payment_status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="card border-0 shadow mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-box me-2"></i> Order Items ({{ $order->items->count() }})
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}"
                                                 alt="{{ $item->product->name }}"
                                                 class="rounded me-3"
                                                 style="width: 60px; height: 60px; object-fit: cover;">
                                            @else
                                            <div class="rounded bg-light me-3 d-flex align-items-center justify-content-center"
                                                 style="width: 60px; height: 60px;">
                                                <i class="fas fa-box text-muted"></i>
                                            </div>
                                            @endif
                                            <div>
                                                <h6 class="mb-1">{{ $item->product->name }}</h6>
                                                <small class="text-muted">SKU: {{ $item->product->sku ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>₹{{ number_format($item->price, 2) }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td><strong>₹{{ number_format($item->total, 2) }}</strong></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Order Notes -->
            @if($order->notes)
            <div class="card border-0 shadow mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-sticky-note me-2"></i> Order Notes
                    </h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $order->notes }}</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Order Details Sidebar -->
        <div class="col-lg-4 mb-4">
            <!-- Customer Info -->
            <div class="card border-0 shadow mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-user me-2"></i> Customer Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-muted mb-1">Name</h6>
                        <p class="mb-0">{{ $order->user->name }}</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-muted mb-1">Email</h6>
                        <p class="mb-0">{{ $order->user->email }}</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-muted mb-1">Phone</h6>
                        <p class="mb-0">{{ $order->user->phone ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-muted mb-1">Member Since</h6>
                        <p class="mb-0">{{ $order->user->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Shipping Address -->
            <div class="card border-0 shadow mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-truck me-2"></i> Shipping Address
                    </h5>
                </div>
                <div class="card-body">
                    @if($order->shippingAddress)
                    <address class="mb-0">
                        <strong>{{ $order->shippingAddress->full_name }}</strong><br>
                        {{ $order->shippingAddress->address_line_1 }}<br>
                        @if($order->shippingAddress->address_line_2)
                        {{ $order->shippingAddress->address_line_2 }}<br>
                        @endif
                        {{ $order->shippingAddress->city }}, {{ $order->shippingAddress->state }}<br>
                        {{ $order->shippingAddress->postal_code }}<br>
                        {{ $order->shippingAddress->country }}<br>
                        <abbr title="Phone">P:</abbr> {{ $order->shippingAddress->phone }}
                    </address>
                    @else
                    <p class="text-muted mb-0">No shipping address provided.</p>
                    @endif
                </div>
            </div>

            <!-- Billing Address -->
            <div class="card border-0 shadow mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-file-invoice me-2"></i> Billing Address
                    </h5>
                </div>
                <div class="card-body">
                    @if($order->billingAddress)
                    <address class="mb-0">
                        <strong>{{ $order->billingAddress->full_name }}</strong><br>
                        {{ $order->billingAddress->address_line_1 }}<br>
                        @if($order->billingAddress->address_line_2)
                        {{ $order->billingAddress->address_line_2 }}<br>
                        @endif
                        {{ $order->billingAddress->city }}, {{ $order->billingAddress->state }}<br>
                        {{ $order->billingAddress->postal_code }}<br>
                        {{ $order->billingAddress->country }}<br>
                        <abbr title="Phone">P:</abbr> {{ $order->billingAddress->phone }}
                    </address>
                    @else
                    <p class="text-muted mb-0">Same as shipping address.</p>
                    @endif
                </div>
            </div>

            <!-- Order Summary -->
            <div class="card border-0 shadow">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-receipt me-2"></i> Order Summary
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <span>₹{{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping</span>
                        <span>₹{{ number_format($order->shipping, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tax (18%)</span>
                        <span>₹{{ number_format($order->tax, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Discount</span>
                        <span class="text-danger">-₹{{ number_format($order->discount, 2) }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-2">
                        <strong>Total</strong>
                        <strong>₹{{ number_format($order->total, 2) }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Payment Method</span>
                        <span class="text-capitalize">{{ $order->payment_method ?? 'N/A' }}</span>
                    </div>
                    @if($order->razorpay_payment_id)
                    <div class="d-flex justify-content-between">
                        <span>Payment ID</span>
                        <small class="text-muted">{{ $order->razorpay_payment_id }}</small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.bg-pending { background-color: #ffc107; }
.bg-processing { background-color: #17a2b8; }
.bg-shipped { background-color: #007bff; }
.bg-delivered { background-color: #28a745; }
.bg-cancelled { background-color: #dc3545; }

.text-pending { color: #ffc107; }
.text-processing { color: #17a2b8; }
.text-shipped { color: #007bff; }
.text-delivered { color: #28a745; }
.text-cancelled { color: #dc3545; }

.bg-opacity-10 { opacity: 0.1; }

.card {
    border-radius: 10px;
}

.card-header {
    border-bottom: 1px solid #e3e6f0;
}

address {
    line-height: 1.8;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #6c757d;
}

.table td {
    border-top: 1px solid #e3e6f0;
}
</style>
@endpush
@endsection
