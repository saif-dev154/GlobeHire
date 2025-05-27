@extends('Admin.layouts.app')

@section('title')
    Create Users
@endsection




@section('content')
 <div class="container py-3">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card shadow border-0 rounded-4">
                <div class="card-header bg-primary bg-gradient text-light text-center py-3 rounded-top-2">
                    <h4 class="mb-0 fw-bold">
                        <i class="bi bi-person-lines-fill me-2"></i>
                        {{ isset($user) ? 'Edit User' : 'Create New User' }}
                    </h4>
                    <small class="text-white fst-italic">
                        {{ isset($user) ? 'Update user details below' : 'Fill the form below to add a new user' }}
                    </small>
                </div>

                <div class="card-body p-4">
                    <form action="{{ isset($user) ? route('admin.users.update', $user->id) : route('admin.users.store') }}" method="POST" novalidate>
                        @csrf
                        @if(isset($user))
                            @method('PUT')
                        @endif

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="userName" class="form-label">Full Name</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                    <input type="text" class="form-control" id="userName" name="name"
                                           value="{{ old('name', $user->name ?? '') }}" placeholder="John Doe" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="userEmail" class="form-label">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                                    <input type="email" class="form-control" id="userEmail" name="email"
                                           value="{{ old('email', $user->email ?? '') }}" placeholder="example@mail.com" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="userPassword" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                    <input type="password" class="form-control" id="userPassword" name="password"
                                           placeholder="{{ isset($user) ? 'Leave blank to keep current password' : 'Password' }}"
                                           {{ isset($user) ? '' : 'required' }}>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="userRole" class="form-label">Select Role</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-briefcase-fill"></i></span>
                                    <select class="form-select" id="userRole" name="role" required>
                                        <option disabled value="">Choose role...</option>
                                        <option value="employer" {{ (old('role', $user->role ?? '') === 'employer') ? 'selected' : '' }}>Employer</option>
                                        <option value="agent" {{ (old('role', $user->role ?? '') === 'agent') ? 'selected' : '' }}>Agent</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-check-circle me-1"></i> {{ isset($user) ? 'Update' : 'Submit' }}
                            </button>
                            <button type="reset" class="btn btn-outline-secondary px-4">
                                <i class="bi bi-arrow-clockwise me-1"></i> Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
