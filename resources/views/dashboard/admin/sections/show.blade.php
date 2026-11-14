@extends('dashboard.layouts.master')

@section('title', $section->name)
@section('page-title', 'Section Details')

@section('content')

    {{-- Section Header --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">

                <div>
                    <span class="badge bg-primary-subtle text-primary mb-2">
                        Menu Section
                    </span>

                    <h2 class="fw-bold mb-2">
                        {{ $section->name }}
                    </h2>

                    <p class="text-muted mb-3">
                        {{ $section->description ?: 'No description available.' }}
                    </p>

                    <div class="d-flex gap-2 flex-wrap">
                        <span
                            class="badge {{ $section->status === 'active' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                            {{ ucfirst($section->status) }}
                        </span>

                        <span class="badge bg-light text-dark border">
                            {{ $section->categories->count() }} Categories
                        </span>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('sections.edit', $section->id) }}" class="btn btn-outline-primary">
                        <i class="bi bi-pencil me-1"></i>
                        Edit Section
                    </a>

                    <a href="{{ route('sections.index') }}" class="btn btn-light border">
                        Back
                    </a>
                </div>

            </div>
        </div>
    </div>


    {{-- Categories Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="fw-bold mb-1">Categories</h4>
            <p class="text-muted mb-0 small">
                Categories belonging to {{ $section->name }}
            </p>
        </div>

        <a href="{{ route('categories.create', ['section_id' => $section->id]) }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>
            Add Category
        </a>
    </div>


    {{-- Categories --}}
    @forelse($section->categories as $category)

        <div class="card border-0 shadow-sm mb-4">

            {{-- Category Header --}}
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                    <div>
                        <h5 class="fw-bold mb-1">
                            {{ $category->name }}
                        </h5>

                        <p class="text-muted small mb-2">
                            {{ $category->description ?: 'No description available.' }}
                        </p>

                        <div class="d-flex gap-2 flex-wrap">
                            <span class="badge bg-light text-dark border">
                                {{ $category->subcategories->count() }} Subcategories
                            </span>

                            <span
                                class="badge {{ $category->status === 'active' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                                {{ ucfirst($category->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('categories.show', $category->id) }}" class="btn btn-sm btn-outline-secondary">
                            View
                        </a>

                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                    </div>

                </div>
            </div>


            {{-- Subcategories --}}
            <div class="card-body p-3">

                @forelse($category->subcategories as $subcategory)
                    <div class="border rounded-3 p-3 mb-3">

                        {{-- Subcategory Header --}}
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">

                            <div>
                                <h6 class="fw-bold mb-1">
                                    <i class="bi bi-folder2-open text-primary me-1"></i>
                                    {{ $subcategory->name }}
                                </h6>

                                <p class="text-muted small mb-1">
                                    {{ $subcategory->description ?: 'No description available.' }}
                                </p>

                                <span class="badge bg-light text-dark border">
                                    {{ $subcategory->items->count() }} Items
                                </span>

                                <span
                                    class="badge {{ $subcategory->status === 'active' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                                    {{ ucfirst($subcategory->status) }}
                                </span>
                            </div>

                            <div class="d-flex gap-2">
                                <a href="{{ route('subcategories.show', $subcategory->id) }}"
                                    class="btn btn-sm btn-outline-secondary">
                                    View
                                </a>

                                <a href="{{ route('subcategories.edit', $subcategory->id) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                            </div>

                        </div>


                        {{-- Menu Items --}}
                        <div class="row g-3">

                            @forelse($subcategory->items as $item)
                                <div class="col-sm-6 col-lg-4 col-xl-3">

                                    <div class="card h-100 border">

                                        <img src="{{ asset($item->image) }}" alt="{{ $item->name }}"
                                            class="card-img-top" style="height: 150px; object-fit: cover;">

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
                                                {{ $item->availability === 'available' ? 'Available' : 'Unavailable' }}
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

                @empty

                    <div class="text-center text-muted py-4">
                        <i class="bi bi-folder-x fs-2 d-block mb-2"></i>
                        No subcategories found.
                    </div>
                @endforelse

            </div>
        </div>

    @empty

        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="bi bi-collection fs-1 text-muted"></i>

                <h5 class="fw-bold mt-3">No Categories Yet</h5>

                <p class="text-muted">
                    Start by adding a category to this section.
                </p>

                <a href="{{ route('categories.create', ['section_id' => $section->id]) }}" class="btn btn-primary">
                    Add First Category
                </a>
            </div>
        </div>

    @endforelse

@endsection



{{-- {{ $section->name }}
@foreach ($section->categories as $category)
    {{ $category->name }}
    @foreach ($category->subcategories as $subcategory)
        {{ $subcategory->name }}
        @foreach ($subcategory->items as $item)
            {{ $item->name }}
        @endforeach
    @endforeach
@endforeach --}}

{{-- <h1>{{ $section->name }}</h1>

@foreach ($section->categories as $category)
    <div class="category-block">
        <h2>Category: {{ $category->name }}</h2>

        @foreach ($category->subcategories as $subcategory)
            <div class="subcategory-block" style="margin-left: 20px;">
                <h3>Subcategory: {{ $subcategory->name }}</h3>

                <ul>
                    @foreach ($subcategory->items as $item)
                        <li>Item: {{ $item->name }} - Price: {{ $item->price }}</li>
                    @endforeach
                </ul>

            </div>
        @endforeach
    </div>
@endforeach --}}
