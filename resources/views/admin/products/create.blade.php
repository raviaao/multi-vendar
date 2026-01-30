@extends('admin.layouts.app')

@section('title', 'Add New Product')
@section('page-title', 'Add New Product')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="data-card shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-lg-8">
                            <!-- Basic Information -->
                            <div class="card mb-4 border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="fas fa-info-circle me-2 text-primary"></i>
                                        Basic Information
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label">Product Name *</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                   id="name" name="name" value="{{ old('name') }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="sku" class="form-label">SKU (Stock Keeping Unit)</label>
                                            <input type="text" class="form-control @error('sku') is-invalid @enderror"
                                                   id="sku" name="sku" value="{{ old('sku') }}">
                                            @error('sku')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror"
                                                      id="description" name="description" rows="4">{{ old('description') }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pricing -->
                            <div class="card mb-4 border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="fas fa-tag me-2 text-success"></i>
                                        Pricing
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="price" class="form-label">Regular Price *</label>
                                            <div class="input-group">
                                                <span class="input-group-text">₹</span>
                                                <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror"
                                                       id="price" name="price" value="{{ old('price') }}" required>
                                                @error('price')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="discount_price" class="form-label">Sale Price</label>
                                            <div class="input-group">
                                                <span class="input-group-text">₹</span>
                                                <input type="number" step="0.01" class="form-control @error('discount_price') is-invalid @enderror"
                                                       id="discount_price" name="discount_price" value="{{ old('discount_price') }}">
                                                @error('discount_price')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <small class="text-muted">Leave empty if not on sale</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Inventory -->
                            <div class="card mb-4 border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="fas fa-boxes me-2 text-warning"></i>
                                        Inventory
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="stock_quantity" class="form-label">Stock Quantity *</label>
                                            <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror"
                                                   id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', 0) }}" required>
                                            @error('stock_quantity')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="status" class="form-label">Status *</label>
                                            <select class="form-select @error('status') is-invalid @enderror"
                                                    id="status" name="status" required>
                                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                <option value="out_of_stock" {{ old('status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-lg-4">
                            <!-- Product Image -->
                            <div class="card mb-4 border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="fas fa-image me-2 text-info"></i>
                                        Product Image
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="text-center mb-3">
                                        <div id="imagePreview" class="mb-3" style="display: none;">
                                            <img id="previewImg" class="img-fluid rounded"
                                                 style="max-height: 200px; object-fit: cover;">
                                        </div>
                                        <div id="noImage" class="text-center py-4 border rounded">
                                            <i class="fas fa-image fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">No image selected</p>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="image" class="form-label">Upload Image *</label>
                                        <input type="file" class="form-control @error('image') is-invalid @enderror"
                                               id="image" name="image" accept="image/*" onchange="previewImage(this)">
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Recommended: 800x800 pixels, max 2MB</small>
                                    </div>

                                    <!-- Multiple Images -->
                                    <div class="mb-3">
                                        <label for="images" class="form-label">Additional Images</label>
                                        <input type="file" class="form-control"
                                               id="images" name="images[]" multiple accept="image/*">
                                        <small class="text-muted">You can select multiple images</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Categories -->
                            <div class="card mb-4 border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="fas fa-list me-2 text-success"></i>
                                        Categories
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">Category</label>
                                        <select class="form-select @error('category_id') is-invalid @enderror"
                                                id="category_id" name="category_id">
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="text-center">
                                        <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-plus me-1"></i> Add New Category
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Product Features -->
                            <div class="card mb-4 border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="fas fa-star me-2 text-warning"></i>
                                        Features
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox"
                                               id="featured" name="featured" value="1"
                                               {{ old('featured') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="featured">Featured Product</label>
                                    </div>

                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox"
                                               id="best_selling" name="best_selling" value="1"
                                               {{ old('best_selling') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="best_selling">Best Selling</label>
                                    </div>

                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox"
                                               id="popular" name="popular" value="1"
                                               {{ old('popular') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="popular">Popular</label>
                                    </div>

                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox"
                                               id="latest" name="latest" value="1"
                                               {{ old('latest') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="latest">Latest Product</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Publish -->
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="fas fa-paper-plane me-2 text-primary"></i>
                                        Publish
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="fas fa-save me-2"></i> Save Product
                                        </button>
                                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                                            Cancel
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Image preview
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                document.getElementById('previewImg').src = e.target.result;
                document.getElementById('imagePreview').style.display = 'block';
                document.getElementById('noImage').style.display = 'none';
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    // Auto calculate sale percentage
    document.getElementById('price').addEventListener('input', calculateDiscount);
    document.getElementById('discount_price').addEventListener('input', calculateDiscount);

    function calculateDiscount() {
        const price = parseFloat(document.getElementById('price').value) || 0;
        const discountPrice = parseFloat(document.getElementById('discount_price').value) || 0;

        if (discountPrice > 0 && price > discountPrice) {
            const discountPercent = ((price - discountPrice) / price * 100).toFixed(1);
            document.getElementById('discount_percent').textContent = discountPercent + '% OFF';
        } else {
            document.getElementById('discount_percent').textContent = '';
        }
    }
</script>
@endpush
