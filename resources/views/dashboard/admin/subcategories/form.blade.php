{{-- @dd($subcategory->toArray()) --}}
@php
    $subcategory = $subcategory ?? new \App\Models\Subcategory()
@endphp

@extends('dashboard.layouts.master')

@section('title', $subcategory->exists ? 'Edit Subcategory' : 'New Subcategory')
@section('page-title', $subcategory->exists ? 'Edit Subcategory' : 'New Subcategory')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card card-primary card-outline">
            <form method="POST" action="{{ $subcategory->exists ? route('subcategories.update', $subcategory) : route('subcategories.store') }}">
                @csrf
                @if ($subcategory->exists) @method('PUT') @endif

                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">-- Select category --</option>
                            @foreach ($categories as $c)
                                <option value="{{ $c->id }}" @selected(old('category_id', $subcategory->category_id) == $c->id)>
                                    {{ $c->section->name }} › {{ $c->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" value="{{ old('name', $subcategory->name) }}"
                               class="form-control @error('name') is-invalid @enderror" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="3" class="form-control">{{ old('description', $subcategory->description) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Display Order</label>
                        <input type="number" name="display_order" min="0" value="{{ old('display_order', $subcategory->display_order ?? 0) }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="active" @selected(old('status', $subcategory->status ?? 'active') == 'active')>Active</option>
                            <option value="inactive" @selected(old('status', $subcategory->status ?? 'inactive') == 'inactive')>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="card-footer">
                    <button class="btn btn-primary">Save</button>
                    <a href="{{ route('subcategories.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
