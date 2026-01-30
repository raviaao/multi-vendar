@extends('admin.layouts.app')

@section('title', 'Edit Order')

@section('content')
<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Edit Order #{{ $order->order_number }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Orders</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.orders.show', $order->id) }}">#{{ $order->order_number }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>

        <div>
            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Edit Order Form -->
            <div class="card border-0 shadow mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i> Update Order Details
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Order Status -->
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Order Status</label>
                                <select class="form-select @error('status') is-invalid @enderror"
                                        id="status" name="status" required>
                                    <option value="">Select Status</option>
                                    @foreach($statuses as $value => $label)
                                    <option value="{{ $value }}"
                                            {{ $order->status == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Payment Status -->
                            <div class="col-md-6 mb-3">
                                <label for="payment_status" class="form-label">Payment Status</label>
                                <select class="form-select @error('payment_status') is-invalid @enderror"
                                        id="payment_status" name="payment_status" required>
                                    <option value="">Select Payment Status</option>
                                    @foreach($paymentStatuses as $value => $label)
                                    <option value="{{ $value }}"
                                            {{ $order->payment_status == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('payment_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tracking Number -->
                        <div class="mb-3">
                            <label for="tracking_number" class="form-label">Tracking Number</label>
                            <input type="text" class="form-control @error('tracking_number') is-invalid @enderror"
                                   id="tracking_number" name="tracking_number"
                                   value="{{ old('tracking_number', $order->tracking_number) }}"
                                   placeholder="Enter tracking number">
                            @error('tracking_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div class="mb-3">
                            <label for="notes" class="form-label">Admin Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror"
                                      id="notes" name="notes" rows="4"
                                      placeholder="Add internal notes about this order">{{ old('notes', $order->notes) }}</textarea>
                            @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.orders.show', $order->id) }}"
                               class="btn btn-outline-secondary px-4">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-1"></i> Update Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Manage Order Items -->
            <div class="card border-0 shadow">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-boxes me-2"></i> Manage Order Items
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>{{ $item->product->name }}</td>
                                    <td>
                                        <form action="{{ route('admin.orders.items.update', [$order->id, $item->id]) }}"
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <div class="input-group input-group-sm" style="width: 120px;">
                                                <span class="input-group-text">₹</span>
                                                <input type="number" name="price"
                                                       class="form-control form-control-sm"
                                                       value="{{ $item->price }}" step="0.01" min="0" required>
                                            </div>
                                    </td>
                                    <td>
                                            <div class="input-group input-group-sm" style="width: 100px;">
                                                <input type="number" name="quantity"
                                                       class="form-control form-control-sm"
                                                       value="{{ $item->quantity }}" min="1" required>
                                            </div>
                                    </td>
                                    <td>₹{{ number_format($item->total, 2) }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-save"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.orders.items.remove', [$order->id, $item->id]) }}"
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                    onclick="return confirm('Remove this item?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Add Item Form -->
                    <div class="mt-4 pt-3 border-top">
                        <h6 class="mb-3">Add New Item to Order</h6>
                        <form action="{{ route('admin.orders.items.add', $order->id) }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-5">
                                    <select class="form-select" name="product_id" required>
                                        <option value="">Select Product</option>
                                        <!-- Populate with products -->
                                        @foreach($products ?? [] as $product)
                                        <option value="{{ $product->id }}">
                                            {{ $product->name }} (Stock: {{ $product->stock_quantity }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" name="quantity" class="form-control"
                                           placeholder="Qty" min="1" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" name="price" class="form-control"
                                           placeholder="Price" step="0.01" min="0" required>
                                </div>
                                <div class="col-md-1">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Summary Sidebar -->
        <div class="col-lg-4">
            <div class="card border-0 shadow">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i> Order Summary
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-muted mb-2">Current Status</h6>
                        <div class="d-flex align-items-center">
                            <div class="me-2">
                                <div class="p-2 rounded-circle bg-{{ $order->status_color }} bg-opacity-10">
                                    <i class="fas fa-circle text-{{ $order->status_color }}"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="mb-0 text-capitalize">{{ $order->status }}</h5>
                                <small class="text-muted">Last updated: {{ $order->updated_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <h6 class="text-muted mb-2">Payment Information</h6>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Method:</span>
                            <span class="text-capitalize">{{ $order->payment_method ?? 'N/A' }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Status:</span>
                            <span class="badge bg-{{ $order->payment_status_color }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                        @if($order->razorpay_payment_id)
                        <div class="mb-2">
                            <small class="text-muted">Payment ID: {{ $order->razorpay_payment_id }}</small>
                        </div>
                        @endif
                    </div>

                    <hr>

                    <div class="mb-3">
                        <h6 class="text-muted mb-2">Customer Information</h6>
                        <p class="mb-1"><strong>{{ $order->user->name }}</strong></p>
                        <p class="mb-1">{{ $order->user->email }}</p>
                        <p class="mb-0">{{ $order->user->phone ?? 'N/A' }}</p>
                    </div>

                    <hr>

                    <div>
                        <h6 class="text-muted mb-2">Order Totals</h6>
                        <div class="d-flex justify-content-between mb-1">
                            <span>Subtotal:</span>
                            <span>₹{{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span>Shipping:</span>
                            <span>₹{{ number_format($order->shipping, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span>Tax:</span>
                            <span>₹{{ number_format($order->tax, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span>Discount:</span>
                            <span class="text-danger">-₹{{ number_format($order->discount, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mt-2 pt-2 border-top">
                            <strong>Total:</strong>
                            <strong>₹{{ number_format($order->total, 2) }}</strong>
                        </div>
                    </div>
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

.form-control-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

.input-group-sm .input-group-text {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

.btn-group-sm .btn {
    padding: 0.25rem 0.5rem;
}

.border-top {
    border-top: 1px solid #e3e6f0 !important;
}
</style>
@endpush
@endsection
