
@php
    $section = $section ?? new \App\Models\Section();
@endphp

@extends('dashboard.layouts.master')

@section('title', $section->exists ? 'Edit Section' : 'New Section')
@section('page-title', $section->exists ? 'Edit Section' : 'New Section')

@section('content')

    <div class="row justify-content-center">

        <div class="col-lg-7 col-md-9">

            {{-- Header --}}
            <div class="mb-4">
                <h4 class="fw-bold mb-1">
                    {{ $section->exists ? 'Edit Section' : 'Create New Section' }}
                </h4>

                <p class="text-muted small mb-0">
                    {{ $section->exists
                        ? 'Update your menu section information.'
                        : 'Add a new section to organize your menu.' }}
                </p>
            </div>

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-shadow p-3">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-collection text-primary me-2"></i>
                        Section Information
                    </h5>
                </div>

                <form method="POST"
                    action="{{ $section->exists
                        ? route('sections.update', $section)
                        : route('sections.store') }}">

                    @csrf

                    @if ($section->exists)
                        @method('PUT')
                    @endif

                    <div class="card-body p-4">

                        {{-- Name --}}
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Section Name <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                name="name"
                                value="{{ old('name', $section->name) }}"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Enter section name"
                                required>

                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>

                        {{-- Description --}}
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Description
                            </label>

                            <textarea name="description"
                                rows="4"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Enter section description">{{ old('description', $section->description) }}</textarea>

                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>

                        {{-- Display Order --}}
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Display Order
                            </label>

                            <input type="number"
                                name="display_order"
                                min="0"
                                value="{{ old('display_order', $section->display_order ?? 0) }}"
                                class="form-control @error('display_order') is-invalid @enderror">

                            <small class="text-muted">
                                Determines the section's position in the menu.
                            </small>

                            @error('display_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>

                        {{-- Status --}}
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Status
                            </label>

                            <select name="status"
                                class="form-select @error('status') is-invalid @enderror">

                                <option value="active"
                                    @selected(old('status', $section->status ?? 'active') == 'active')>
                                    Active
                                </option>

                                <option value="inactive"
                                    @selected(old('status', $section->status ?? 'active') == 'inactive')>
                                    Inactive
                                </option>

                            </select>

                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>

                    </div>

                    {{-- Actions --}}
                    <div class="card-footer bg-shadow p-3">

                        <div class="d-flex gap-2">

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i>
                                {{ $section->exists ? 'Update Section' : 'Create Section' }}
                            </button>

                            <a href="{{ route('sections.index') }}"
                                class="btn btn-light border">
                                Cancel
                            </a>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection
