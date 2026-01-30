@extends('frontend.layouts.app')

@section('title', 'Register - Shopora')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<div class="min-vh-100 d-flex align-items-center justify-content-center bg-light py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">

                <div class="card border-0 shadow-lg rounded-3 overflow-hidden">

                    <!-- Header -->
                    <div class="card-header bg-white text-center py-4">
                        <h2 class="fw-bold mb-1">Shopora</h2>
                        <p class="text-muted mb-0">Create your account</p>
                    </div>

                    <!-- Body -->
                    <div class="card-body p-4">

                        {{-- 🔴 Validation Errors --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Name -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Full Name *</label>
                                <input type="text"
                                       name="name"
                                       class="form-control"
                                       value="{{ old('name') }}"
                                       required>
                            </div>

                            <!-- Phone -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Mobile Number *</label>
                                <div class="input-group">
                                    <span class="input-group-text">+91</span>
                                    <input type="tel"
                                           name="phone"
                                           class="form-control"
                                           maxlength="10"
                                           pattern="[6-9][0-9]{9}"
                                           title="Enter valid 10 digit mobile number"
                                           value="{{ old('phone') }}"
                                           required>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email Address *</label>
                                <input type="email"
                                       name="email"
                                       class="form-control"
                                       value="{{ old('email') }}"
                                       required>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Password *</label>
                                <input type="password"
                                       name="password"
                                       class="form-control"
                                       minlength="6"
                                       required>
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Confirm Password *</label>
                                <input type="password"
                                       name="password_confirmation"
                                       class="form-control"
                                       minlength="6"
                                       required>
                            </div>

                            <!-- Terms -->
                            <div class="form-check mb-3">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="terms"
                                       required>
                                <label class="form-check-label small">
                                    I agree to the Terms & Conditions
                                </label>
                            </div>

                            <!-- Submit -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-user-plus me-2"></i>
                                    Register
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Footer -->
                    <div class="card-footer bg-white text-center">
                        <small class="text-muted">
                            Already have an account?
                            <a href="{{ route('login') }}" class="text-primary fw-semibold">
                                Login
                            </a>
                        </small>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection
