@php
    $category = $category ?? new \App\Models\Category();
@endphp


@extends('dashboard.layouts.master')

@section('title', $category->exists ? 'Edit Category' : 'New Category')
@section('page-title', $category->exists ? 'Edit Category' : 'New Category')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card card-primary card-outline">
            <form method="POST" action="{{ $category->exists ? route('categories.update', $category) : route('categories.store') }}">
                @csrf
                @if ($category->exists) @method('PUT') @endif

                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Section</label>
                        <select name="section_id" class="form-select @error('section_id') is-invalid @enderror" required>
                            <option value="">-- Select section --</option>
                            @foreach ($sections as $s)
                                <option value="{{ $s->id }}" @selected(old('section_id', $category->section_id) == $s->id)>{{ $s->name }}</option>
                            @endforeach
                        </select>
                        @error('section_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" value="{{ old('name', $category->name) }}"
                               class="form-control @error('name') is-invalid @enderror" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="3" class="form-control">{{ old('description', $category->description) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Display Order</label>
                        <input type="number" name="display_order" min="0" value="{{ old('display_order', $category->display_order ?? 0) }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="active" @selected(old('status', $category->status ?? 'active') == 'active')>Active</option>
                            <option value="inactive" @selected(old('status', $category->status ?? 'inactive') == 'inactive')>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="card-footer">
                    <button class="btn btn-primary">Save</button>
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
