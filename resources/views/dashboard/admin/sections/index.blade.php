
@extends('dashboard.layouts.master')

@section('title', 'Sections')
@section('page-title', 'Menu Sections')

@section('content')

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1">Menu Sections</h4>
            <p class="text-muted mb-0 small">
                Manage your menu sections and their categories.
            </p>
        </div>

        <a href="{{ route('sections.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>
            Add Section
        </a>
    </div>

    {{-- Sections Table --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-grey p-3 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold mb-1">All Sections</h5>
                <p class="text-muted small mb-0">
                    {{ $sections->count() }} Sections
                </p>
            </div>

            <span class="badge bg-primary-subtle text-primary">
                Menu Management
            </span>
        </div>

        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th style="width:40px"></th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Categories</th>
                            <th>Display Order</th>
                            <th>Status</th>
                            <th class="text-center" style="width:150px">Actions</th>
                        </tr>
                    </thead>

                    <tbody id="sortable" data-url="{{ route('sections.reorder') }}">

                        @forelse ($sections as $section)

                            <tr data-id="{{ $section->id }}">

                                <td class="text-muted" style="cursor:move">
                                    <i class="bi bi-grip-vertical fs-5"></i>
                                </td>

                                <td>
                                    <div class="fw-semibold">
                                        {{ $section->name }}
                                    </div>
                                </td>

                                <td>
                                    <span class="text-muted small">
                                        {{ Str::limit($section->description, 50) ?: 'No description' }}
                                    </span>
                                </td>

                                <td>
                                    <span class="badge bg-light text-dark border">
                                        <i class="bi bi-folder2 me-1"></i>
                                        {{ $section->categories_count }} Categories
                                    </span>
                                </td>

                                <td>
                                    <span class="text-muted">
                                        {{ $section->display_order }}
                                    </span>
                                </td>

                                <td>
                                    <span class="badge {{ $section->status === 'active'
                                        ? 'bg-success-subtle text-success'
                                        : 'bg-secondary-subtle text-secondary' }}">
                                        {{ ucfirst($section->status) }}
                                    </span>
                                </td>

                                <td>
                                    <div class="d-flex justify-content-center gap-1">

                                        <a href="{{ route('sections.show', $section->id) }}"
                                            class="btn btn-sm btn-outline-secondary"
                                            title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a href="{{ route('sections.edit', $section->id) }}"
                                            class="btn btn-sm btn-outline-primary"
                                            title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form action="{{ route('sections.destroy', $section->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Delete this section?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="7">
                                    <div class="text-center py-5">

                                        <i class="bi bi-collection fs-1 text-muted"></i>

                                        <h5 class="fw-bold mt-3">
                                            No Sections Yet
                                        </h5>

                                        <p class="text-muted">
                                            Start by creating your first menu section.
                                        </p>

                                        <a href="{{ route('sections.create') }}"
                                            class="btn btn-primary">
                                            <i class="bi bi-plus-lg me-1"></i>
                                            Add First Section
                                        </a>

                                    </div>
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>
            </div>

        </div>
    </div>

@endsection

@push('scripts')
    @include('dashboard.admin.partials.sortable')
@endpush
