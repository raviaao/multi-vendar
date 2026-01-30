@extends('admin.layouts.app')

@section('title', 'Order Management')

@section('content')
<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Order Management</h1>

        <!-- Export Button -->
        <div>
            <a href="{{ route('admin.orders.export') }}" class="btn btn-outline-secondary">
                <i class="fas fa-download me-1"></i> Export
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Orders</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalOrders ?? Order::count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-4">
            <a href="{{ route('admin.orders.filter', 'pending') }}" class="text-decoration-none">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Pending</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingCount ?? Order::where('status', 'pending')->count() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-xl-2 col-md-4 mb-4">
            <a href="{{ route('admin.orders.filter', 'processing') }}" class="text-decoration-none">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Processing</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $processingCount ?? Order::where('status', 'processing')->count() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-cog fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-xl-2 col-md-4 mb-4">
            <a href="{{ route('admin.orders.filter', 'shipped') }}" class="text-decoration-none">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Shipped</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $shippedCount ?? Order::where('status', 'shipped')->count() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-truck fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-xl-2 col-md-4 mb-4">
            <a href="{{ route('admin.orders.filter', 'delivered') }}" class="text-decoration-none">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Delivered</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $deliveredCount ?? Order::where('status', 'delivered')->count() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-xl-2 col-md-4 mb-4">
            <a href="{{ route('admin.orders.filter', 'cancelled') }}" class="text-decoration-none">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Cancelled</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $cancelledCount ?? Order::where('status', 'cancelled')->count() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="card mb-4 border-0 shadow">
        <div class="card-body p-0">
            <ul class="nav nav-tabs" id="orderTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link {{ !isset($status) ? 'active' : '' }}"
                       href="{{ route('admin.orders.index') }}">
                        All Orders
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link {{ isset($status) && $status == 'pending' ? 'active' : '' }}"
                       href="{{ route('admin.orders.filter', 'pending') }}">
                        Pending
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link {{ isset($status) && $status == 'processing' ? 'active' : '' }}"
                       href="{{ route('admin.orders.filter', 'processing') }}">
                        Processing
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link {{ isset($status) && $status == 'shipped' ? 'active' : '' }}"
                       href="{{ route('admin.orders.filter', 'shipped') }}">
                        Shipped
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link {{ isset($status) && $status == 'delivered' ? 'active' : '' }}"
                       href="{{ route('admin.orders.filter', 'delivered') }}">
                        Delivered
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link {{ isset($status) && $status == 'cancelled' ? 'active' : '' }}"
                       href="{{ route('admin.orders.filter', 'cancelled') }}">
                        Cancelled
                    </a>
                </li>
            </ul>

            <!-- Search Bar -->
            <div class="p-3 border-bottom">
                <form action="{{ route('admin.orders.search') }}" method="GET" class="d-flex">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control"
                               placeholder="Search by Order ID, Customer Name or Email..."
                               value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="card border-0 shadow">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td>
                                <strong>#{{ $order->order_number }}</strong><br>
                                <small class="text-muted">ID: {{ $order->id }}</small>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div>
                                        <strong>{{ $order->user->name ?? 'Guest' }}</strong><br>
                                        <small class="text-muted">{{ $order->user->email ?? 'N/A' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                {{ $order->created_at->format('d M Y') }}<br>
                                <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                            </td>
                            <td>
                                {{ $order->items->count() }} items<br>
                                <small class="text-muted">{{ $order->items->sum('quantity') }} units</small>
                            </td>
                            <td>
                                <strong>₹{{ number_format($order->total, 2) }}</strong><br>
                                <small class="text-muted">Sub: ₹{{ number_format($order->subtotal, 2) }}</small>
                            </td>
                            <td>
                                <span class="badge bg-{{ $order->status_color }} p-2">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $order->payment_status_color }} p-2">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                       class="btn btn-sm btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.orders.edit', $order->id) }}"
                                       class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('admin.orders.invoice', $order->id) }}"
                                       class="btn btn-sm btn-secondary" title="Invoice">
                                        <i class="fas fa-file-invoice"></i>
                                    </a>
                                    <form action="{{ route('admin.orders.destroy', $order->id) }}"
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure?')" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <div class="empty-state">
                                    <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                                    <h5>No Orders Found</h5>
                                    <p class="text-muted">No orders match your search criteria.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($orders->hasPages())
        <div class="card-footer">
            <div class="d-flex justify-content-center">
                {{ $orders->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

@push('styles')
<style>
.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 500;
}

.bg-pending { background-color: #ffc107; color: #000; }
.bg-processing { background-color: #17a2b8; color: #fff; }
.bg-shipped { background-color: #007bff; color: #fff; }
.bg-delivered { background-color: #28a745; color: #fff; }
.bg-cancelled { background-color: #dc3545; color: #fff; }

.bg-paid { background-color: #28a745; color: #fff; }
.bg-pending-payment { background-color: #ffc107; color: #000; }
.bg-failed { background-color: #dc3545; color: #fff; }
.bg-refunded { background-color: #6c757d; color: #fff; }

.nav-tabs .nav-link {
    color: #6c757d;
    border: none;
    padding: 0.75rem 1.5rem;
}

.nav-tabs .nav-link.active {
    color: #007bff;
    border-bottom: 2px solid #007bff;
    background-color: transparent;
}

.empty-state {
    text-align: center;
    padding: 2rem;
}

.table td {
    vertical-align: middle;
}

.btn-group .btn {
    margin-right: 0.25rem;
}
</style>
@endpush
@endsection
