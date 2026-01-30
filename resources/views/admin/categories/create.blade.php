@extends('admin.layouts.app')

@section('title', 'Add New Category')
@section('page-title', 'Add New Category')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="data-card shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-8">
                            <!-- Category Info -->
                            <div class="card mb-4 border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="fas fa-info-circle me-2 text-primary"></i>
                                        Category Information
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Category Name *</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                               id="name" name="name" value="{{ old('name') }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror"
                                                  id="description" name="description" rows="4">{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="order" class="form-label">Display Order</label>
                                        <input type="number" class="form-control @error('order') is-invalid @enderror"
                                               id="order" name="order" value="{{ old('order', 0) }}" min="0">
                                        @error('order')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Lower numbers display first</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-4">
                            <!-- Category Image -->
                            <div class="card mb-4 border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="fas fa-image me-2 text-info"></i>
                                        Category Image
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
                                        <label for="image" class="form-label">Upload Image</label>
                                        <input type="file" class="form-control @error('image') is-invalid @enderror"
                                               id="image" name="image" accept="image/*" onchange="previewImage(this)">
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Recommended: 400x400 pixels, max 2MB</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Category Features -->
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
                                        <label class="form-check-label" for="featured">Featured Category</label>
                                    </div>
                                    <small class="text-muted">Featured categories will be highlighted on the homepage</small>
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
                                            <i class="fas fa-save me-2"></i> Save Category
                                        </button>
                                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
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
</script>
@endpush
