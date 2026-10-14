@extends('dashboard.layouts.master')

@section('title', 'My Profile')
@section('page-title', 'My Profile')

@section('content')
<div class="row">
    {{-- View profile --}}
    <div class="col-lg-4">
        <div class="card card-primary card-outline">
            <div class="card-body text-center">
                <img src="{{ asset($user->profile_picture) }}" class="rounded-circle shadow mb-3"
                     style="width:128px;height:128px;object-fit:cover" alt="Profile picture">
                <h4 class="mb-0">{{ $user->name }}</h4>
                <span class="badge text-bg-primary mt-1">{{ str($user->role)->replace('_', ' ')->title() }}</span>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><i class="bi bi-envelope me-2"></i>{{ $user->email }}</li>
                <li class="list-group-item"><i class="bi bi-telephone me-2"></i>{{ $user->phone }}</li>
            </ul>
        </div>
    </div>

    <div class="col-lg-8">
        {{-- Edit profile --}}
        <div class="card mb-4">
            <div class="card-header"><h3 class="card-title">Edit Profile</h3></div>
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}"
                               class="form-control @error('name') is-invalid @enderror" required />
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input id="phone" type="tel" name="phone" value="{{ old('phone', $user->phone) }}"
                               class="form-control @error('phone') is-invalid @enderror" required />
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="profile_picture" class="form-label">Profile Picture <small class="text-muted">(JPG/PNG, max 2MB)</small></label>
                        <input id="profile_picture" type="file" name="profile_picture" accept="image/png,image/jpeg"
                               class="form-control @error('profile_picture') is-invalid @enderror" />
                        @error('profile_picture') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="card-footer"><button class="btn btn-primary">Save Changes</button></div>
            </form>
        </div>

        {{-- Change password --}}
        <div class="card">
            <div class="card-header"><h3 class="card-title">Change Password</h3></div>
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input id="current_password" type="password" name="current_password"
                               class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                               autocomplete="current-password" required />
                        @error('current_password', 'updatePassword') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <input id="new_password" type="password" name="password"
                               class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                               autocomplete="new-password" required />
                        @error('password', 'updatePassword') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation"
                               class="form-control" autocomplete="new-password" required />
                    </div>
                </div>
                <div class="card-footer"><button class="btn btn-warning">Change Password</button></div>
            </form>
        </div>
    </div>
</div>
@endsection
