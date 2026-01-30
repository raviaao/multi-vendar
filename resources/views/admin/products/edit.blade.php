@extends('admin.layouts.app')

@section('title', 'Edit Product')
@section('page-title', 'Edit Product')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="data-card shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

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
                                                   id="name" name="name" value="{{ old('name', $product->name) }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="sku" class="form-label">SKU (Stock Keeping Unit)</label>
                                            <input type="text" class="form-control @error('sku') is-invalid @enderror"
                                                   id="sku" name="sku" value="{{ old('sku', $product->sku) }}">
                                            @error('sku')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror"
                                                      id="description" name="description" rows="4">{{ old('description', $product->description) }}</textarea>
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
                                                       id="price" name="price" value="{{ old('price', $product->price) }}" required>
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
                                                       id="discount_price" name="discount_price" value="{{ old('discount_price', $product->discount_price) }}">
                                                @error('discount_price')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <small class="text-muted">Leave empty if not on sale</small>
                                            @if($product->is_on_sale)
                                            <div class="mt-2">
                                                <span class="badge bg-danger">
                                                    {{ $product->discount_percentage }}% OFF
                                                </span>
                                            </div>
                                            @endif
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
                                                   id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" required>
                                            @error('stock_quantity')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Current stock: {{ $product->stock_quantity }}</small>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="status" class="form-label">Status *</label>
                                            <select class="form-select @error('status') is-invalid @enderror"
                                                    id="status" name="status" required>
                                                <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                <option value="out_of_stock" {{ old('status', $product->status) == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
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
                                        <!-- Current Image -->
                                        @if($product->image)
                                        <div id="currentImage" class="mb-3">
                                            <img src="{{ asset('storage/' . $product->image) }}"
                                                 class="img-fluid rounded"
                                                 style="max-height: 200px; object-fit: cover;"
                                                 alt="{{ $product->name }}">
                                            <div class="mt-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                           id="remove_image" name="remove_image" value="1">
                                                    <label class="form-check-label text-danger" for="remove_image">
                                                        Remove current image
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        <div id="noImage" class="text-center py-4 border rounded">
                                            <i class="fas fa-image fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">No image currently</p>
                                        </div>
                                        @endif

                                        <!-- New Image Preview -->
                                        <div id="imagePreview" class="mb-3" style="display: none;">
                                            <img id="previewImg" class="img-fluid rounded"
                                                 style="max-height: 200px; object-fit: cover;">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="image" class="form-label">Upload New Image</label>
                                        <input type="file" class="form-control @error('image') is-invalid @enderror"
                                               id="image" name="image" accept="image/*" onchange="previewImage(this)">
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Recommended: 800x800 pixels, max 2MB</small>
                                    </div>

                                    <!-- Additional Images -->
                                    @if($product->images && count(json_decode($product->images)) > 0)
                                    <div class="mb-3">
                                        <label class="form-label">Additional Images</label>
                                        <div class="row g-2">
                                            @foreach(json_decode($product->images) as $index => $additionalImage)
                                            <div class="col-4">
                                                <div class="position-relative">
                                                    <img src="{{ asset('storage/' . $additionalImage) }}"
                                                         class="img-fluid rounded"
                                                         style="height: 80px; object-fit: cover;">
                                                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0"
                                                            onclick="removeAdditionalImage({{ $index }})">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        <input type="hidden" name="removed_images" id="removedImages">
                                    </div>
                                    @endif

                                    <div class="mb-3">
                                        <label for="images" class="form-label">Add More Images</label>
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
                                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
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
                                               {{ old('featured', $product->featured) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="featured">Featured Product</label>
                                    </div>

                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox"
                                               id="best_selling" name="best_selling" value="1"
                                               {{ old('best_selling', $product->best_selling) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="best_selling">Best Selling</label>
                                    </div>

                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox"
                                               id="popular" name="popular" value="1"
                                               {{ old('popular', $product->popular) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="popular">Popular</label>
                                    </div>

                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox"
                                               id="latest" name="latest" value="1"
                                               {{ old('latest', $product->latest) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="latest">Latest Product</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Product Info -->
                            <div class="card mb-4 border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="fas fa-info me-2 text-primary"></i>
                                        Product Information
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <small class="text-muted">Product ID</small>
                                            <p class="mb-2"><strong>#{{ $product->id }}</strong></p>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Created</small>
                                            <p class="mb-2">{{ $product->created_at->format('d M Y') }}</p>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Updated</small>
                                            <p class="mb-2">{{ $product->updated_at->format('d M Y') }}</p>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Slug</small>
                                            <p class="mb-2 text-truncate">{{ $product->slug }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Update -->
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="fas fa-paper-plane me-2 text-primary"></i>
                                        Update Product
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="fas fa-save me-2"></i> Update Product
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

                // Hide current image and no image message
                if (document.getElementById('currentImage')) {
                    document.getElementById('currentImage').style.display = 'none';
                }
                if (document.getElementById('noImage')) {
                    document.getElementById('noImage').style.display = 'none';
                }
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    // Handle remove image checkbox
    document.getElementById('remove_image')?.addEventListener('change', function() {
        if (this.checked) {
            if (document.getElementById('currentImage')) {
                document.getElementById('currentImage').style.display = 'none';
            }
            if (document.getElementById('imagePreview')) {
                document.getElementById('imagePreview').style.display = 'none';
            }
            if (document.getElementById('noImage')) {
                document.getElementById('noImage').style.display = 'block';
            }
        } else {
            if (document.getElementById('currentImage')) {
                document.getElementById('currentImage').style.display = 'block';
            }
            if (document.getElementById('noImage')) {
                document.getElementById('noImage').style.display = 'none';
            }
        }
    });

    // Remove additional images
    const removedImages = [];

    function removeAdditionalImage(index) {
        removedImages.push(index);
        document.getElementById('removedImages').value = JSON.stringify(removedImages);

        // Hide the image (in real app, you might want to AJAX delete)
        event.target.closest('.col-4').style.display = 'none';
    }

    // Calculate discount percentage
    document.getElementById('price').addEventListener('input', calculateDiscount);
    document.getElementById('discount_price').addEventListener('input', calculateDiscount);

    function calculateDiscount() {
        const price = parseFloat(document.getElementById('price').value) || 0;
        const discountPrice = parseFloat(document.getElementById('discount_price').value) || 0;

        if (discountPrice > 0 && price > discountPrice) {
            const discountPercent = ((price - discountPrice) / price * 100).toFixed(1);
            // Show discount badge
            document.getElementById('discountBadge').innerHTML = discountPercent + '% OFF';
            document.getElementById('discountBadge').style.display = 'block';
        } else {
            document.getElementById('discountBadge').style.display = 'none';
        }
    }

    // Initialize discount calculation
    calculateDiscount();
</script>
@endpush

@push('styles')
<style>
    .form-check-input:checked {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .form-switch .form-check-input {
        height: 1.5em;
        width: 3em;
    }

    #discountBadge {
        display: none;
        margin-top: 5px;
    }
</style>
@endpush
