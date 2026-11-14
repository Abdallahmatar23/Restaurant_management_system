@extends('dashboard.layouts.master')

@section('title', $subcategory->name)
@section('page-title', 'Subcategory Details')

@section('content')

    {{-- Subcategory Header --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">

            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">

                <div>
                    <span class="badge bg-primary-subtle text-primary mb-2">
                        Menu Subcategory
                    </span>

                    <h2 class="fw-bold mb-2">
                        {{ $subcategory->name }}
                    </h2>

                    <p class="text-muted mb-3">
                        {{ $subcategory->description ?: 'No description available.' }}
                    </p>

                    <div class="d-flex gap-2 flex-wrap">

                        <span
                            class="badge {{ $subcategory->status === 'active' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                            {{ ucfirst($subcategory->status) }}
                        </span>

                        <span class="badge bg-light text-dark border">
                            Category: {{ $subcategory->category->name }}
                        </span>

                        <span class="badge bg-light text-dark border">
                            Section: {{ $subcategory->category->section->name }}
                        </span>

                        <span class="badge bg-light text-dark border">
                            {{ $subcategory->items->count() }} Menu Items
                        </span>

                    </div>
                </div>

                <div class="d-flex gap-2">

                    <a href="{{ route('subcategories.edit', $subcategory->id) }}" class="btn btn-outline-primary">
                        <i class="bi bi-pencil me-1"></i>
                        Edit Subcategory
                    </a>

                    <a href="{{ route('categories.show', $subcategory->category_id) }}" class="btn btn-light border">
                        Back to Category
                    </a>

                </div>

            </div>

        </div>
    </div>


    {{-- Menu Items Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">

        <div>
            <h4 class="fw-bold mb-1">Menu Items</h4>

            <p class="text-muted mb-0 small">
                Items belonging to {{ $subcategory->name }}
            </p>
        </div>

        <a href="{{ route('menu-items.create', ['subcategory_id' => $subcategory->id]) }}" class="btn btn-primary">

            <i class="bi bi-plus-lg me-1"></i>
            Add Menu Item

        </a>

    </div>


    {{-- Menu Items --}}
    <div class="row g-3">

        @forelse($subcategory->items as $item)
            <div class="col-sm-6 col-lg-4 col-xl-3">

                <div class="card h-100 border-0 shadow-sm">

                    {{-- Item Image --}}
                    <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" class="card-img-top"
                        style="height: 180px; object-fit: cover;">

                    <div class="card-body">

                        <h5 class="card-title fw-bold mb-2">
                            {{ $item->name }}
                        </h5>

                        <p class="text-muted small mb-3">
                            {{ Str::limit($item->description, 100) }}
                        </p>

                        <div class="d-flex justify-content-between align-items-center mb-3">

                            <span class="fw-bold text-primary fs-5">
                                {{ number_format($item->price, 2) }} EGP
                            </span>

                            <span
                                class="badge {{ $item->availability === 'available' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                                {{ $item->availability === 'available' ? 'Available' : 'Out of Stock' }}
                            </span>

                        </div>

                        <div class="small text-muted">
                            <i class="bi bi-clock me-1"></i>

                            Preparation Time:
                            {{ $item->preparation_time }} min
                        </div>

                    </div>

                    {{-- Item Actions --}}
                    <div class="card-footer bg-white border-0 pt-0 pb-3">

                        <a href="{{ route('menu-items.show', $item->id) }}"
                            class="btn btn-sm btn-outline-secondary w-100 mb-2">
                            View Details
                        </a>

                        <a href="{{ route('menu-items.edit', $item->id) }}" class="btn btn-sm btn-outline-primary w-100">
                            <i class="bi bi-pencil me-1"></i>
                            Edit Item
                        </a>

                    </div>

                </div>

            </div>

        @empty

            <div class="col-12">

                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">

                        <i class="bi bi-egg-fried fs-1 text-muted"></i>

                        <h5 class="fw-bold mt-3">
                            No Menu Items Yet
                        </h5>

                        <p class="text-muted">
                            Start by adding your first menu item.
                        </p>

                        <a href="{{ route('menu-items.create', ['subcategory_id' => $subcategory->id]) }}"
                            class="btn btn-primary">
                            Add First Item
                        </a>

                    </div>
                </div>

            </div>
        @endforelse

    </div>

@endsection
