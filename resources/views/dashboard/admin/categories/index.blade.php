@extends('dashboard.layouts.master')

@section('title', 'Categories')
@section('page-title', 'Categories')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <form method="GET" class="d-flex gap-2">
                <select name="section_id" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">All sections</option>
                    @foreach ($sections as $s)
                        <option value="{{ $s->id }}" @selected(request('section_id') == $s->id)>{{ $s->name }}</option>
                    @endforeach
                </select>
            </form>
            <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Add
                Category</a>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width:40px"></th>
                        <th>Name</th>
                        <th>Section</th>
                        <th>Description</th>
                        <th>Subcategories</th>
                        <th>Items</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th style="width:150px">Actions</th>
                    </tr>
                </thead>
                <tbody id="sortable" data-url="{{ route('categories.reorder') }}">
                    @forelse ($categories as $category)
                        <tr data-id="{{ $category->id }}">
                            <td class="text-muted" style="cursor:move"><i class="bi bi-grip-vertical"></i></td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->section->name }}</td>
                            <td>{{ Str::limit($category->description, 40) }}</td>
                            <td>{{ $category->subcategories_count }}</td>
                            <td>{{ $category->items_count }}</td>
                            <td>{{ $category->display_order }}</td>
                            <td><span
                                    class="badge text-bg-{{ $category->status === 'active' ? 'success' : 'secondary' }}">{{ $category->status === 'active' ? 'Active' : 'Inactive' }}</span>
                            </td>
                            <td>
                                <a href="{{ route('categories.show', $category) }}"
                                    class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('categories.edit', $category) }}"
                                    class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Delete this category?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">No categories yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    @include('dashboard.admin.partials.sortable')
@endpush
