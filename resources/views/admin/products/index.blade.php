@extends('admin.layouts.app')

@section('title', 'Manage Products')
@section('page-title', 'Products Management')

@section('page-actions')
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i> Add New Product
    </a>
@endsection

@section('content')
<div class="data-card shadow-sm">
    <div class="card-body">
        <!-- Search and Filter -->
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="input-group">
                    <span class="input-group-text bg-light border-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control border-0 bg-light" placeholder="Search products...">
                    <button class="btn btn-primary">Search</button>
                </div>
            </div>
            <div class="col-md-4">
                <select class="form-select bg-light border-0">
                    <option>All Categories</option>
                    <option>Featured</option>
                    <option>Best Selling</option>
                    <option>Out of Stock</option>
                </select>
            </div>
        </div>

        @if($products->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="50">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox">
                                </div>
                            </th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox">
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                         alt="{{ $product->name }}"
                                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;"
                                         class="me-3">
                                    @else
                                    <div class="bg-light d-flex align-items-center justify-content-center me-3"
                                         style="width: 50px; height: 50px; border-radius: 8px;">
                                        <i class="fas fa-box text-muted"></i>
                                    </div>
                                    @endif
                                    <div>
                                        <strong>{{ $product->name }}</strong>
                                        <div class="text-muted small">{{ $product->sku ?? 'No SKU' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($product->category)
                                <span class="badge bg-info">{{ $product->category->name }}</span>
                                @else
                                <span class="badge bg-secondary">Uncategorized</span>
                                @endif
                            </td>
                            <td>
                                <div>
                                    @if($product->is_on_sale)
                                        <span class="text-danger fw-bold">₹{{ $product->discount_price }}</span>
                                        <del class="text-muted small d-block">₹{{ $product->price }}</del>
                                    @else
                                        <span class="fw-bold">₹{{ $product->price }}</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-{{ $product->stock_quantity > 10 ? 'success' : ($product->stock_quantity > 0 ? 'warning' : 'danger') }} me-2">
                                        {{ $product->stock_quantity }}
                                    </span>
                                    @if($product->stock_quantity == 0)
                                    <small class="text-danger">Out of stock</small>
                                    @elseif($product->stock_quantity < 10)
                                    <small class="text-warning">Low stock</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-{{ $product->status == 'active' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($product->status) }}
                                </span>
                                <div class="mt-1">
                                    @if($product->featured)
                                    <span class="badge bg-primary badge-sm">Featured</span>
                                    @endif
                                    @if($product->best_selling)
                                    <span class="badge bg-warning badge-sm">Best Seller</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.products.edit', $product->id) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                            onclick="confirmDelete({{ $product->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>

                                <!-- Delete Form -->
                                <form id="delete-form-{{ $product->id }}"
                                      action="{{ route('admin.products.destroy', $product->id) }}"
                                      method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    <p class="mb-0">Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} products</p>
                </div>
                <div>
                    {{ $products->links() }}
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-box-open fa-4x text-muted"></i>
                </div>
                <h4>No Products Found</h4>
                <p class="text-muted mb-4">Start adding products to your store</p>
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus me-2"></i> Add Your First Product
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Bulk Actions -->
@if($products->count() > 0)
<div class="card shadow-sm mt-3">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="selectAll">
                <label class="form-check-label" for="selectAll">Select All</label>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-tag me-1"></i> Update Status
                </button>
                <button type="button" class="btn btn-outline-danger btn-sm">
                    <i class="fas fa-trash me-1"></i> Delete Selected
                </button>
                <button type="button" class="btn btn-outline-success btn-sm">
                    <i class="fas fa-file-export me-1"></i> Export
                </button>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
    // Confirm delete
    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this product?')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }

    // Select all checkbox
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('tbody .form-check-input');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
</script>
@endpush
