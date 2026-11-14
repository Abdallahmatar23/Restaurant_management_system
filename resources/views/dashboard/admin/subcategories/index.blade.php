{{-- @foreach ($subcategories as $subcategory)
{{ $subcategory->category->name }}
@endforeach
@dd('end') --}}
@extends('dashboard.layouts.master')

@section('title', 'Subcategories')
@section('page-title', 'Subcategories')

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
                <select name="category_id" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">All categories</option>
                    @foreach ($categories as $c)
                        <option value="{{ $c->id }}" @selected(request('category_id') == $c->id)>{{ $c->name }}</option>
                    @endforeach
                </select>
            </form>
            <a href="{{ route('subcategories.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Add
                Subcategory</a>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width:40px"></th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Section</th>
                        <th>Items</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th style="width:150px">Actions</th>
                    </tr>
                </thead>
                <tbody id="sortable" data-url="{{ route('subcategories.reorder') }}">
                    @forelse ($subcategories as $sub)
                        <tr data-id="{{ $sub->id }}">
                            <td class="text-muted" style="cursor:move"><i class="bi bi-grip-vertical"></i></td>
                            <td>{{ $sub->name }}</td>
                            <td>{{ $sub->category->name }}</td>
                            <td>{{ $sub->category->section->name }}</td>
                            <td>{{ $sub->items_count }}</td>
                            <td>{{ $sub->display_order }}</td>
                            <td><span
                                    class="badge text-bg-{{ $sub->status === 'active' ? 'success' : 'secondary' }}">{{ $sub->status === 'active' ? 'Active' : 'Inactive' }}</span>
                            </td>
                            <td>
                                <a href="{{ route('subcategories.show', $sub) }}" class="btn btn-sm btn-outline-info"><i
                                        class="bi bi-eye"></i></a>
                                <a href="{{ route('subcategories.edit', $sub) }}" class="btn btn-sm btn-outline-primary"><i
                                        class="bi bi-pencil"></i></a>
                                <form action="{{ route('subcategories.destroy', $sub) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Delete this subcategory?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">No subcategories yet</td>
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
