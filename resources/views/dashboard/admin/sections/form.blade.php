{{-- @dd($section->name) --}}
@php
    $section = $section ?? new \App\Models\Section();
@endphp

@extends('dashboard.layouts.master')

@section('title', $section->exists ? 'Edit Section' : 'New Section')
@section('page-title', $section->exists ? 'Edit Section' : 'New Section')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-primary card-outline">
                <form method="POST"
                    action="{{ $section->exists ? route('sections.update', $section) : route('sections.store') }}">
                    @csrf
                    @if ($section->exists)
                        @method('PUT')
                    @endif

                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" value="{{ old('name', $section->name) }}"
                                class="form-control @error('name') is-invalid @enderror" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="3" class="form-control">{{ old('description', $section->description) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Display Order</label>
                            <input type="number" name="display_order" min="0"
                                value="{{ old('display_order', $section->display_order ?? 0) }}"
                                class="form-control @error('display_order') is-invalid @enderror">
                            @error('display_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="active" @selected(old('status', $section->status) == 'active')>Active</option>
                                <option value="inactive" @selected(old('status', $section->status) == 'inactive')>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button class="btn btn-primary">Save</button>
                        <a href="{{ route('sections.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
