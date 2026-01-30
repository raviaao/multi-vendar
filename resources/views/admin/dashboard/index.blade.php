@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- ===== STATS CARDS ===== -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stats-card shadow-sm">
            <div class="card-body">
                <div class="stats-icon users">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stats-number">{{ $stats['total_users'] ?? 0 }}</div>
                <div class="stats-text">Total Users</div>
                <div class="mt-3">
                    <span class="text-success">
                        <i class="fas fa-arrow-up"></i> 12%
                    </span>
                    <span class="text-muted ms-2">Since last month</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stats-card shadow-sm">
            <div class="card-body">
                <div class="stats-icon products">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stats-number">{{ $stats['total_products'] ?? 0 }}</div>
                <div class="stats-text">Total Products</div>
                <div class="mt-3">
                    <span class="text-success">
                        <i class="fas fa-arrow-up"></i> 8%
                    </span>
                    <span class="text-muted ms-2">Since last week</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stats-card shadow-sm">
            <div class="card-body">
                <div class="stats-icon categories">
                    <i class="fas fa-list"></i>
                </div>
                <div class="stats-number">{{ $stats['total_categories'] ?? 0 }}</div>
                <div class="stats-text">Total Categories</div>
                <div class="mt-3">
                    <span class="text-success">
                        <i class="fas fa-arrow-up"></i> 5%
                    </span>
                    <span class="text-muted ms-2">Since last month</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stats-card shadow-sm">
            <div class="card-body">
                <div class="stats-icon stock">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stats-number">{{ $stats['low_stock_products'] ?? 0 }}</div>
                <div class="stats-text">Low Stock</div>
                <div class="mt-3">
                    <span class="text-danger">
                        <i class="fas fa-arrow-up"></i> 3%
                    </span>
                    <span class="text-muted ms-2">Need attention</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===== RECENT DATA ===== -->
<div class="row">
    <!-- Recent Products -->
    <div class="col-xl-6 mb-4">
        <div class="data-card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-box me-2 text-primary"></i>
                    Recent Products
                </h5>
                <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus me-1"></i> Add New
                </a>
            </div>
            <div class="card-body">
                @if(isset($recentProducts) && $recentProducts->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentProducts as $product)
                                <tr class="cursor-pointer" onclick="window.location='#'">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}"
                                                 alt="{{ $product->name }}"
                                                 style="width: 40px; height: 40px; object-fit: cover; border-radius: 8px;">
                                            @else
                                            <div class="user-avatar me-3">
                                                <i class="fas fa-box"></i>
                                            </div>
                                            @endif
                                            <div>
                                                <strong>{{ $product->name }}</strong>
                                                <div class="text-muted small">{{ $product->category->name ?? 'Uncategorized' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($product->is_on_sale)
                                            <span class="text-danger fw-bold">₹{{ $product->discount_price }}</span>
                                            <del class="text-muted small">₹{{ $product->price }}</del>
                                        @else
                                            <span class="fw-bold">₹{{ $product->price }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $product->stock_quantity > 10 ? 'success' : ($product->stock_quantity > 0 ? 'warning' : 'danger') }}">
                                            {{ $product->stock_quantity }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $product->status == 'active' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($product->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-box-open fa-3x text-muted"></i>
                        </div>
                        <h5>No Products Yet</h5>
                        <p class="text-muted mb-4">Start adding products to your store</p>
                        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i> Add First Product
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Users -->
    <div class="col-xl-6 mb-4">
        <div class="data-card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-users me-2 text-info"></i>
                    Recent Users
                </h5>
                <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-user-plus me-1"></i> Add User
                </a>
            </div>
            <div class="card-body">
                @if(isset($recentUsers) && $recentUsers->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Joined</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentUsers as $user)
                                <tr class="cursor-pointer" onclick="window.location='#'">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar me-3">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <strong>{{ $user->name }}</strong>
                                                <div class="text-muted small">{{ $user->phone ?? 'No phone' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : 'primary' }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td>{{ $user->created_at->format('d M, Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-users fa-3x text-muted"></i>
                        </div>
                        <h5>No Users Yet</h5>
                        <p class="text-muted mb-4">Users will appear here when they register</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- ===== QUICK ACTIONS ===== -->
<div class="row">
    <div class="col-12">
        <div class="data-card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-bolt me-2 text-warning"></i>
                    Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-xl-3 col-md-6">
                        <a href="{{ route('admin.products.create') }}" class="action-btn" style="background: linear-gradient(135deg, #4361ee, #3a0ca3);">
                            <i class="fas fa-plus-circle"></i>
                            <span>Add Product</span>
                        </a>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <a href="{{ route('admin.categories.create') }}" class="action-btn" style="background: linear-gradient(135deg, #06d6a0, #049c75);">
                            <i class="fas fa-folder-plus"></i>
                            <span>Add Category</span>
                        </a>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <a href="{{ route('admin.users.create') }}" class="action-btn" style="background: linear-gradient(135deg, #118ab2, #0a6c8a);">
                            <i class="fas fa-user-plus"></i>
                            <span>Add User</span>
                        </a>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <a href="{{ route('home') }}" class="action-btn" style="background: linear-gradient(135deg, #ffd166, #ff9e00);">
                            <i class="fas fa-store"></i>
                            <span>Visit Store</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
