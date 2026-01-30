@extends('admin.layouts.app')

@section('title', 'Manage Categories')
@section('page-title', 'Categories Management')

@section('page-actions')
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i> Add New Category
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="data-card shadow-sm">
            <div class="card-body">
                @if($categories->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Products</th>
                                    <th>Status</th>
                                    <th>Featured</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($category->image)
                                            <img src="{{ asset('storage/' . $category->image) }}"
                                                 alt="{{ $category->name }}"
                                                 style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;"
                                                 class="me-3">
                                            @else
                                            <div class="bg-light d-flex align-items-center justify-content-center me-3"
                                                 style="width: 50px; height: 50px; border-radius: 8px;">
                                                <i class="fas fa-folder text-muted"></i>
                                            </div>
                                            @endif
                                            <div>
                                                <strong>{{ $category->name }}</strong>
                                                <div class="text-muted small">{{ $category->description ? substr($category->description, 0, 50) . '...' : 'No description' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $category->products_count ?? 0 }}</span>
                                        <small class="text-muted d-block">products</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">Active</span>
                                    </td>
                                    <td>
                                        @if($category->featured)
                                        <span class="badge bg-warning">
                                            <i class="fas fa-star me-1"></i> Featured
                                        </span>
                                        @else
                                        <span class="badge bg-secondary">Normal</span>
                                        @endif
                                    </td>
                                    <td>{{ $category->created_at->format('d M Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.categories.edit', $category->id) }}"
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="#" class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($category->products_count == 0)
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                    onclick="confirmDelete({{ $category->id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            @else
                                            <button type="button" class="btn btn-sm btn-outline-danger" disabled
                                                    title="Cannot delete category with products">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            @endif
                                        </div>

                                        <!-- Delete Form -->
                                        <form id="delete-form-{{ $category->id }}"
                                              action="{{ route('admin.categories.destroy', $category->id) }}"
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
                    <div class="d-flex justify-content-center mt-4">
                        {{ $categories->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-folder-open fa-4x text-muted"></i>
                        </div>
                        <h4>No Categories Found</h4>
                        <p class="text-muted mb-4">Categories help organize your products</p>
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-plus me-2"></i> Create First Category
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
<style>
    /* Category Card */
    .category-card {
        display: block;
        transition: all 0.3s ease;
    }

    .category-inner {
        padding: 15px 10px;
        border-radius: 12px;
        background: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        height: 100%;
    }

    .category-card:hover .category-inner {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(107, 178, 82, 0.15);
    }

    /* Category Image */
    .category-image img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border: 3px solid #f8f9fa;
        transition: all 0.3s ease;
    }

    .category-card:hover .category-image img {
        transform: scale(1.05);
        border-color: #6BB252;
    }

    .placeholder-image {
        border: 3px solid #f8f9fa;
    }

    /* Product Count Badge */
    .product-count-badge {
        font-size: 11px;
        padding: 4px 8px;
        transform: translate(-5px, -5px);
    }

    /* Category Info */
    .category-title {
        font-size: 0.95rem;
        line-height: 1.3;
        min-height: 2.6rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .category-count {
        font-size: 0.85rem;
    }

    /* Empty State */
    .empty-state {
        padding: 40px 20px;
    }

    /* Responsive Design */
    @media (max-width: 1199.98px) {
        .category-image img,
        .placeholder-image {
            width: 100px;
            height: 100px;
        }

        .category-title {
            font-size: 0.9rem;
            min-height: 2.4rem;
        }
    }

    @media (max-width: 991.98px) {
        .category-image img,
        .placeholder-image {
            width: 90px;
            height: 90px;
        }

        .category-inner {
            padding: 12px 8px;
        }
    }

    @media (max-width: 767.98px) {
        .section-header {
            text-align: center;
        }

        .section-header .d-flex {
            flex-direction: column;
            gap: 15px;
            align-items: center !important;
        }

        .category-image img,
        .placeholder-image {
            width: 80px;
            height: 80px;
        }

        .category-title {
            font-size: 0.85rem;
            min-height: 2.2rem;
        }

        .category-count {
            font-size: 0.8rem;
        }
    }

    @media (max-width: 575.98px) {
        .section-title {
            font-size: 1.5rem;
        }

        .category-image img,
        .placeholder-image {
            width: 70px;
            height: 70px;
        }

        .category-inner {
            padding: 10px 5px;
        }

        .product-count-badge {
            font-size: 10px;
            padding: 3px 6px;
        }
    }

    /* Animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .category-card {
        animation: fadeInUp 0.5s ease forwards;
        animation-delay: calc(var(--index) * 0.1s);
        opacity: 0;
    }
</style>
@push('scripts')
<script>
    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this category?')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>
@endpush
