@extends('dashboard.layouts.master')

@section('title', 'Subcategories')
@section('page-title', 'Subcategories')

@section('content')

    <div class="card border-0 shadow-sm">

        <div class="card-header bg-body py-3">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">

                <div>
                    <h5 class="fw-bold mb-1">Subcategories</h5>
                    <small class="text-body-secondary">
                        Manage all menu subcategories
                    </small>
                </div>

                <a href="{{ route('subcategories.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i>
                    Add Subcategory
                </a>

            </div>

            <form method="GET" action="{{ route('subcategories.index') }}">

                <div class="row g-2">

                    <div class="col-lg-5 col-md-6">
                        <label class="form-label small fw-semibold">Section</label>

                        <select name="section_id" class="form-select">
                            <option value="">All Sections</option>

                            @foreach ($sections as $s)
                                <option value="{{ $s->id }}"
                                    @selected(request('section_id') == $s->id)>
                                    {{ $s->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-lg-5 col-md-6">
                        <label class="form-label small fw-semibold">Category</label>

                        <select name="category_id" class="form-select">
                            <option value="">All Categories</option>

                            @foreach ($categories as $c)
                                <option value="{{ $c->id }}"
                                    @selected(request('category_id') == $c->id)>
                                    {{ $c->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-lg-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-secondary w-100">
                            <i class="bi bi-funnel me-1"></i>
                            Filter
                        </button>
                    </div>

                </div>

                <div class="mt-2">
                    <a href="{{ route('subcategories.index') }}"
                        class="text-decoration-none small text-body-secondary">
                        <i class="bi bi-arrow-counterclockwise me-1"></i>
                        Clear Filters
                    </a>
                </div>

            </form>

        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-secondary">
                        <tr>
                            <th class="ps-3" style="width: 40px"></th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Section</th>
                            <th>Items</th>
                            <th>Order</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody id="sortable" data-url="{{ route('subcategories.reorder') }}">

                        @forelse ($subcategories as $sub)

                            <tr data-id="{{ $sub->id }}">

                                <td class="ps-3 text-body-secondary" style="cursor: move">
                                    <i class="bi bi-grip-vertical"></i>
                                </td>

                                <td>
                                    <span class="fw-semibold text-body">
                                        {{ $sub->name }}
                                    </span>
                                </td>

                                <td>{{ $sub->category->name }}</td>

                                <td>{{ $sub->category->section->name }}</td>

                                <td>{{ $sub->items_count }}</td>

                                <td>{{ $sub->display_order }}</td>

                                <td>
                                    <span class="badge {{ $sub->status === 'active' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                                        {{ $sub->status === 'active' ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>

                                <td>
                                    <div class="d-flex justify-content-center gap-1">

                                        <a href="{{ route('subcategories.show', $sub) }}"
                                            class="btn btn-sm btn-outline-info"
                                            title="View Subcategory">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a href="{{ route('subcategories.edit', $sub) }}"
                                            class="btn btn-sm btn-outline-primary"
                                            title="Edit Subcategory">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form action="{{ route('subcategories.destroy', $sub) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this subcategory?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                title="Delete Subcategory">
                                                <i class="bi bi-trash"></i>
                                            </button>

                                        </form>

                                    </div>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="8" class="text-center py-5">

                                    <i class="bi bi-inbox fs-1 text-body-secondary"></i>

                                    <p class="text-body-secondary mt-2 mb-0">
                                        No subcategories found.
                                    </p>

                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        @if (method_exists($subcategories, 'hasPages') && $subcategories->hasPages())
            <div class="card-footer bg-body">
                {{ $subcategories->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        @endif

    </div>

@endsection

@push('scripts')
    @include('dashboard.admin.partials.sortable')
@endpush
