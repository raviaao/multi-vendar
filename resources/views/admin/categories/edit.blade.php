@extends('admin.layouts.app')

@section('title', 'Edit Category')
@section('page-title', 'Edit Category')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="data-card shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

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
                                               id="name" name="name" value="{{ old('name', $category->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror"
                                                  id="description" name="description" rows="4">{{ old('description', $category->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="order" class="form-label">Display Order</label>
                                        <input type="number" class="form-control @error('order') is-invalid @enderror"
                                               id="order" name="order" value="{{ old('order', $category->order) }}" min="0">
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
                                        @if($category->image)
                                        <img src="{{ asset('storage/' . $category->image) }}"
                                             class="img-fluid rounded mb-3"
                                             style="max-height: 200px; object-fit: cover;"
                                             id="currentImage">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                   id="remove_image" name="remove_image" value="1">
                                            <label class="form-check-label text-danger" for="remove_image">
                                                Remove current image
                                            </label>
                                        </div>
                                        @else
                                        <div id="noImage" class="text-center py-4 border rounded">
                                            <i class="fas fa-image fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">No image selected</p>
                                        </div>
                                        @endif

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
                                               {{ old('featured', $category->featured) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="featured">Featured Category</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Publish -->
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="fas fa-paper-plane me-2 text-primary"></i>
                                        Update Category
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="fas fa-save me-2"></i> Update Category
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
                if (document.getElementById('noImage')) {
                    document.getElementById('noImage').style.display = 'none';
                }
                if (document.getElementById('currentImage')) {
                    document.getElementById('currentImage').style.display = 'none';
                }
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    // Handle remove image checkbox
    document.getElementById('remove_image')?.addEventListener('change', function() {
        if (this.checked) {
            document.getElementById('currentImage').style.display = 'none';
        } else {
            document.getElementById('currentImage').style.display = 'block';
        }
    });
</script>
@endpush
