@extends('dashboard.layouts.master')

@section('title', $category->name)
@section('page-title', 'Category Details')

@section('content')

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                <div>
                    <span class="badge bg-primary-subtle text-primary mb-2">
                        Menu Category
                    </span>

                    <h2 class="fw-bold mb-2">{{ $category->name }}</h2>

                    <p class="text-body-secondary mb-3">
                        {{ $category->description ?: 'No description available.' }}
                    </p>

                    <div class="d-flex gap-2 flex-wrap">
                        <span class="badge {{ $category->status === 'active' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                            {{ ucfirst($category->status) }}
                        </span>

                        <span class="badge bg-body-tertiary text-body border">
                            Section: {{ $category->section->name }}
                        </span>

                        <span class="badge bg-body-tertiary text-body border">
                            {{ $category->subcategories->count() }} Subcategories
                        </span>
                    </div>
                </div>

                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary">
                        <i class="bi bi-pencil me-1"></i>
                        Edit Category
                    </a>

                    <a href="{{ route('sections.show', $category->section_id) }}" class="btn btn-outline-secondary">
                        Back to Section
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <div>
            <h4 class="fw-bold mb-1">Subcategories</h4>
            <small class="text-body-secondary">
                Subcategories belonging to {{ $category->name }}
            </small>
        </div>

        <a href="{{ route('subcategories.create', ['category_id' => $category->id]) }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>
            Add Subcategory
        </a>
    </div>

    @forelse($category->subcategories as $subcategory)

        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-body py-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <h5 class="fw-bold mb-1">
                            <i class="bi bi-folder2-open text-primary me-1"></i>
                            {{ $subcategory->name }}
                        </h5>

                        <p class="text-body-secondary small mb-2">
                            {{ $subcategory->description ?: 'No description available.' }}
                        </p>

                        <div class="d-flex gap-2 flex-wrap">
                            <span class="badge bg-body-tertiary text-body border">
                                {{ $subcategory->items->count() }} Items
                            </span>

                            <span class="badge {{ $subcategory->status === 'active' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                                {{ ucfirst($subcategory->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('subcategories.show', $subcategory->id) }}" class="btn btn-sm btn-outline-info">
                            <i class="bi bi-eye me-1"></i>
                            View
                        </a>

                        <a href="{{ route('subcategories.edit', $subcategory->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil me-1"></i>
                            Edit
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body p-3">
                <div class="row g-3">

                    @forelse($subcategory->items as $item)

                        <div class="col-sm-6 col-lg-4 col-xl-3">
                            <div class="card h-100 border shadow-sm">

                                @if($item->image)
                                    <img src="{{ asset($item->image) }}"
                                        alt="{{ $item->name }}"
                                        class="card-img-top"
                                        style="height: 150px; object-fit: cover;">
                                @else
                                    <div class="bg-body-tertiary d-flex align-items-center justify-content-center"
                                        style="height: 150px;">
                                        <i class="bi bi-image fs-1 text-body-secondary"></i>
                                    </div>
                                @endif

                                <div class="card-body">
                                    <h6 class="fw-bold mb-2">{{ $item->name }}</h6>

                                    <p class="text-body-secondary small mb-2">
                                        {{ Str::limit($item->description, 75) }}
                                    </p>

                                    <div class="fw-bold text-primary mb-2">
                                        {{ number_format($item->price, 2) }} EGP
                                    </div>

                                    <span class="badge {{ $item->availability === 'available' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                                        {{ $item->availability === 'available' ? 'Available' : 'Unavailable' }}
                                    </span>
                                </div>

                                <div class="card-footer bg-body border-0 pt-0">
                                    <a href="{{ route('menu-items.show', $item->id) }}"
                                        class="btn btn-sm btn-outline-info w-100 mb-2">
                                        <i class="bi bi-eye me-1"></i>
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
                            <div class="text-center text-body-secondary py-3">
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
                <i class="bi bi-folder-x fs-1 text-body-secondary"></i>

                <h5 class="fw-bold mt-3">No Subcategories Yet</h5>

                <p class="text-body-secondary">
                    Start by adding a subcategory to this category.
                </p>

                <a href="{{ route('subcategories.create', ['category_id' => $category->id]) }}"
                    class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i>
                    Add First Subcategory
                </a>
            </div>
        </div>

    @endforelse

@endsection
