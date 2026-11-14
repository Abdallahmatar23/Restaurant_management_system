@extends('dashboard.layouts.master')

@section('title', $category->name)
@section('page-title', 'Category Details')

@section('content')

    {{-- Category Header --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">

            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">

                <div>
                    <span class="badge bg-primary-subtle text-primary mb-2">
                        Menu Category
                    </span>

                    <h2 class="fw-bold mb-2">
                        {{ $category->name }}
                    </h2>

                    <p class="text-muted mb-3">
                        {{ $category->description ?: 'No description available.' }}
                    </p>

                    <div class="d-flex gap-2 flex-wrap">

                        <span
                            class="badge {{ $category->status === 'active' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                            {{ ucfirst($category->status) }}
                        </span>

                        <span class="badge bg-light text-dark border">
                            Section: {{ $category->section->name }}
                        </span>

                        <span class="badge bg-light text-dark border">
                            {{ $category->subcategories->count() }} Subcategories
                        </span>

                    </div>
                </div>

                <div class="d-flex gap-2">

                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-outline-primary">
                        <i class="bi bi-pencil me-1"></i>
                        Edit Category
                    </a>

                    <a href="{{ route('sections.show', $category->section_id) }}" class="btn btn-light border">
                        Back to Section
                    </a>

                </div>

            </div>

        </div>
    </div>


    {{-- Subcategories Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">

        <div>
            <h4 class="fw-bold mb-1">Subcategories</h4>

            <p class="text-muted mb-0 small">
                Subcategories belonging to {{ $category->name }}
            </p>
        </div>

        <a href="{{ route('subcategories.create', ['category_id' => $category->id]) }}" class="btn btn-primary">

            <i class="bi bi-plus-lg me-1"></i>
            Add Subcategory

        </a>

    </div>


    {{-- Subcategories --}}
    @forelse($category->subcategories as $subcategory)

        <div class="card border-0 shadow-sm mb-4">

            {{-- Subcategory Header --}}
            <div class="card-header bg-white p-3">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                    <div>

                        <h5 class="fw-bold mb-1">
                            <i class="bi bi-folder2-open text-primary me-1"></i>
                            {{ $subcategory->name }}
                        </h5>

                        <p class="text-muted small mb-2">
                            {{ $subcategory->description ?: 'No description available.' }}
                        </p>

                        <div class="d-flex gap-2 flex-wrap">

                            <span class="badge bg-light text-dark border">
                                {{ $subcategory->items->count() }} Items
                            </span>

                            <span
                                class="badge {{ $subcategory->status === 'active' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                                {{ ucfirst($subcategory->status) }}
                            </span>

                        </div>

                    </div>

                    <div class="d-flex gap-2">

                        <a href="{{ route('subcategories.show', $subcategory->id) }}"
                            class="btn btn-sm btn-outline-secondary">
                            View
                        </a>

                        <a href="{{ route('subcategories.edit', $subcategory->id) }}"
                            class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                            Edit
                        </a>

                    </div>

                </div>

            </div>


            {{-- Menu Items --}}
            <div class="card-body p-3">

                <div class="row g-3">

                    @forelse($subcategory->items as $item)
                        <div class="col-sm-6 col-lg-4 col-xl-3">

                            <div class="card h-100 border">

                                <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" class="card-img-top"
                                    style="height: 150px; object-fit: cover;">

                                <div class="card-body">

                                    <h6 class="fw-bold mb-2">
                                        {{ $item->name }}
                                    </h6>

                                    <p class="text-muted small mb-2">
                                        {{ Str::limit($item->description, 75) }}
                                    </p>

                                    <div class="fw-bold text-primary mb-2">
                                        {{ number_format($item->price, 2) }} EGP
                                    </div>

                                    <span
                                        class="badge {{ $item->availability === 'available' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                                        {{ $item->availability === 'available' ? 'Available' : 'Out of Stock' }}
                                    </span>

                                </div>

                                <div class="card-footer bg-white border-0 pt-0">

                                    <a href="{{ route('menu-items.show', $item->id) }}"
                                        class="btn btn-sm btn-outline-secondary w-100 mb-2">
                                        View Details
                                    </a>

                                    <a href="{{ route('menu-items.edit', $item->id) }}"
                                        class="btn btn-sm btn-outline-primary w-100">
                                        <i class="bi bi-pencil me-1"></i>
                                        Edit Item
                                    </a>

                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="col-12">
                            <div class="text-center text-muted py-3">
                                No menu items in this subcategory yet.
                            </div>
                        </div>
                    @endforelse

                </div>

            </div>

        </div>

    @empty

        <div class="card border-0 shadow-sm">

            <div class="card-body text-center py-5">

                <i class="bi bi-folder-x fs-1 text-muted"></i>

                <h5 class="fw-bold mt-3">
                    No Subcategories Yet
                </h5>

                <p class="text-muted">
                    Start by adding a subcategory to this category.
                </p>

                <a href="{{ route('subcategories.create', ['category_id' => $category->id]) }}" class="btn btn-primary">
                    Add First Subcategory
                </a>

            </div>

        </div>

    @endforelse

@endsection
