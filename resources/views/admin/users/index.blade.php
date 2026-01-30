@extends('admin.layouts.app')

@section('title', 'Manage Users')
@section('page-title', 'Users Management')

@section('page-actions')
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        <i class="fas fa-user-plus me-2"></i> Add New User
    </a>
@endsection

@section('content')
<div class="data-card shadow-sm">
    <div class="card-body">
        <!-- User Stats -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Total Users</h6>
                                <h3 class="mb-0">{{ $users->total() }}</h3>
                            </div>
                            <i class="fas fa-users fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Active Users</h6>
                                <h3 class="mb-0">{{ $users->total() }}</h3>
                            </div>
                            <i class="fas fa-user-check fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Admins</h6>
                                <h3 class="mb-0">{{ $adminCount }}</h3>
                            </div>
                            <i class="fas fa-crown fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">This Month</h6>
                                <h3 class="mb-0">{{ $monthlyUsers }}</h3>
                            </div>
                            <i class="fas fa-chart-line fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($users->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Contact</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar me-3">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <strong>{{ $user->name }}</strong>
                                        <div class="text-muted small">ID: {{ $user->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>{{ $user->email }}</div>
                                <div class="text-muted small">{{ $user->phone ?? 'No phone' }}</div>
                            </td>
                            <td>
                                <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : 'primary' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-success">
                                    <i class="fas fa-circle me-1" style="font-size: 0.6rem;"></i> Active
                                </span>
                            </td>
                            <td>
                                <div>{{ $user->created_at->format('d M Y') }}</div>
                                <div class="text-muted small">{{ $user->created_at->diffForHumans() }}</div>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($user->id != auth()->id())
                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                            onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    @else
                                    <button type="button" class="btn btn-sm btn-outline-secondary" disabled
                                            title="You cannot delete your own account">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    @endif
                                </div>

                                <!-- Delete Form -->
                                <form id="delete-form-{{ $user->id }}"
                                      action="{{ route('admin.users.destroy', $user->id) }}"
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
                    <p class="mb-0">Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} users</p>
                </div>
                <div>
                    {{ $users->links() }}
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-users fa-4x text-muted"></i>
                </div>
                <h4>No Users Found</h4>
                <p class="text-muted mb-4">Users will appear here when they register</p>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmDelete(id, name) {
        if (confirm(`Are you sure you want to delete user "${name}"?`)) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>
@endpush
