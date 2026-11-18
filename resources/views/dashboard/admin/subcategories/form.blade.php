@php
    $subcategory = $subcategory ?? new \App\Models\Subcategory();
@endphp

@extends('dashboard.layouts.master')

@section('title', $subcategory->exists ? 'Edit Subcategory' : 'New Subcategory')
@section('page-title', $subcategory->exists ? 'Edit Subcategory' : 'New Subcategory')

@section('content')

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-body py-3">
                    <h5 class="fw-bold mb-0">
                        {{ $subcategory->exists ? 'Edit Subcategory' : 'Create Subcategory' }}
                    </h5>

                    <small class="text-body-secondary">
                        {{ $subcategory->exists ? 'Update the subcategory information' : 'Add a new subcategory to your menu' }}
                    </small>
                </div>

                <form method="POST"
                    action="{{ $subcategory->exists ? route('subcategories.update', $subcategory) : route('subcategories.store') }}">

                    @csrf

                    @if ($subcategory->exists)
                        @method('PUT')
                    @endif

                    <div class="card-body p-4">

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Category</label>

                            <select name="category_id"
                                class="form-select @error('category_id') is-invalid @enderror"
                                required>

                                <option value="">-- Select Category --</option>

                                @foreach ($categories as $c)
                                    <option value="{{ $c->id }}"
                                        @selected(old('category_id', $subcategory->category_id) == $c->id)>
                                        {{ $c->section->name }} › {{ $c->name }}
                                    </option>
                                @endforeach

                            </select>

                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Name</label>

                            <input type="text"
                                name="name"
                                maxlength="200"
                                value="{{ old('name', $subcategory->name) }}"
                                class="form-control @error('name') is-invalid @enderror"
                                required>

                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Description</label>

                            <textarea name="description"
                                rows="3"
                                class="form-control @error('description') is-invalid @enderror">{{ old('description', $subcategory->description) }}</textarea>

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
                                    value="{{ old('display_order', $subcategory->display_order ?? 0) }}"
                                    class="form-control @error('display_order') is-invalid @enderror">

                                @error('display_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Status</label>

                                <select name="status" class="form-select">
                                    <option value="active"
                                        @selected(old('status', $subcategory->status ?? 'active') === 'active')>
                                        Active
                                    </option>

                                    <option value="inactive"
                                        @selected(old('status', $subcategory->status ?? 'active') === 'inactive')>
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

                        <a href="{{ route('subcategories.index') }}"
                            class="btn btn-outline-secondary">
                            Cancel
                        </a>

                    </div>

                </form>

            </div>

        </div>
    </div>

@endsection
