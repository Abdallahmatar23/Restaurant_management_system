@php
    $category = $category ?? new \App\Models\Category();
@endphp

@extends('dashboard.layouts.master')

@section('title', $category->exists ? 'Edit Category' : 'New Category')
@section('page-title', $category->exists ? 'Edit Category' : 'New Category')

@section('content')

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-body py-3">
                    <h5 class="fw-bold mb-0">
                        {{ $category->exists ? 'Edit Category' : 'Create Category' }}
                    </h5>

                    <small class="text-body-secondary">
                        {{ $category->exists ? 'Update the category information' : 'Add a new category to your menu' }}
                    </small>
                </div>

                <form method="POST"
                    action="{{ $category->exists ? route('categories.update', $category) : route('categories.store') }}">

                    @csrf

                    @if ($category->exists)
                        @method('PUT')
                    @endif

                    <div class="card-body p-4">

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Section</label>

                            <select name="section_id"
                                class="form-select @error('section_id') is-invalid @enderror"
                                required>

                                <option value="">-- Select Section --</option>

                                @foreach ($sections as $s)
                                    <option value="{{ $s->id }}"
                                        @selected(old('section_id', $category->section_id) == $s->id)>
                                        {{ $s->name }}
                                    </option>
                                @endforeach

                            </select>

                            @error('section_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Name</label>

                            <input type="text"
                                name="name"
                                maxlength="200"
                                value="{{ old('name', $category->name) }}"
                                class="form-control @error('name') is-invalid @enderror"
                                required>

                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Description
                                <small class="text-body-secondary fw-normal">(optional)</small>
                            </label>

                            <textarea name="description"
                                rows="3"
                                class="form-control @error('description') is-invalid @enderror">{{ old('description', $category->description) }}</textarea>

                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Display Order</label>

                                <input type="number"
                                    name="display_order"
                                    min="0"
                                    value="{{ old('display_order', $category->display_order ?? 0) }}"
                                    class="form-control @error('display_order') is-invalid @enderror">

                                @error('display_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Status</label>

                                <select name="status" class="form-select">
                                    <option value="active"
                                        @selected(old('status', $category->status ?? 'active') === 'active')>
                                        Active
                                    </option>

                                    <option value="inactive"
                                        @selected(old('status', $category->status ?? 'active') === 'inactive')>
                                        Inactive
                                    </option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="card-footer bg-body p-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>
                            Save
                        </button>

                        <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
