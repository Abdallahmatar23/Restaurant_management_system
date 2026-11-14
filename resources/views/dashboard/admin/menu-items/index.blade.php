@extends('dashboard.layouts.master')

@section('title', 'Menu Items')
@section('page-title', 'Menu Items')

@section('content')

    <div class="card border-0 shadow-sm">

        {{-- Header --}}
        <div class="card-header bg-white py-3">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">

                <div>
                    <h5 class="fw-bold mb-1">Menu Items</h5>
                    <small class="text-muted">Manage all restaurant menu items</small>
                </div>

                <a href="{{ route('menu-items.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i>
                    Add New Item
                </a>

            </div>


            <form action="{{ route('menu-items.index') }}" method="GET">

                <div class="row g-2">

                    <div class="col-lg-3 col-md-6">

                        <label class="form-label small fw-semibold">
                            Search
                        </label>

                        <input type="search" name="search" value="{{ request('search') }}" class="form-control"
                            placeholder="Search by item name...">

                    </div>

                    <div class="col-lg-2 col-md-6">

                        <label class="form-label small fw-semibold">
                            Section
                        </label>

                        <select name="section_id" id="sectionFilter" class="form-select"
                            data-url="{{ route('categories.by-section', ['section' => '__ID__']) }}">

                            <option value="">All Sections</option>

                            @foreach ($sections as $section)
                                <option value="{{ $section->id }}" @selected(request('section_id') == $section->id)>
                                    {{ $section->name }}
                                </option>
                            @endforeach

                        </select>

                    </div>

                    <div class="col-lg-2 col-md-6">

                        <label class="form-label small fw-semibold">
                            Category
                        </label>

                        <select name="category_id" id="categoryFilter" class="form-select"
                            data-url="{{ route('subcategories.by-category', ['category' => '__ID__']) }}">

                            <option value="">All Categories</option>

                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach

                        </select>

                    </div>

                    <div class="col-lg-2 col-md-6">

                        <label class="form-label small fw-semibold">
                            Subcategory
                        </label>

                        <select name="subcategory_id" id="subcategoryFilter" class="form-select">

                            <option value="">All Subcategories</option>

                            @foreach ($subcategories as $subcategory)
                                <option value="{{ $subcategory->id }}" @selected(request('subcategory_id') == $subcategory->id)>
                                    {{ $subcategory->name }}
                                </option>
                            @endforeach

                        </select>

                    </div>


                    <div class="col-lg-2 col-md-6">

                        <label class="form-label small fw-semibold">
                            Availability
                        </label>

                        <select name="availability" class="form-select">

                            <option value="">All Availability</option>

                            <option value="available" @selected(request('availability') === 'available')>
                                Available
                            </option>

                            <option value="unavailable" @selected(request('availability') === 'unavailable')>
                                Unavailable
                            </option>

                        </select>

                    </div>

                    <div class="col-lg-1 col-md-6 d-flex align-items-end">

                        <button type="submit" class="btn btn-secondary w-100">
                            <i class="bi bi-funnel"></i>
                            Filter
                        </button>

                    </div>

                </div>


                <div class="mt-2">

                    <a href="{{ route('menu-items.index') }}" class="text-decoration-none small text-muted">
                        <i class="bi bi-arrow-counterclockwise me-1"></i>
                        Clear Filters
                    </a>

                </div>

            </form>

        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>
                            <th class="ps-3">Image</th>
                            <th>Name</th>
                            <th>Subcategory</th>
                            <th>Category</th>
                            <th>Section</th>
                            <th>Price</th>
                            <th>Availability</th>
                            <th>Special Tags</th>
                            <th class="text-center">Actions</th>
                        </tr>

                    </thead>


                    <tbody>

                        @forelse ($items as $item)
                            <tr>

                                {{-- Image --}}
                                <td class="ps-3">

                                    @if ($item->image)
                                        <img src="{{ $item->image }}" alt="{{ $item->name }}" class="rounded"
                                            style="width: 65px; height: 50px; object-fit: cover;">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                            style="width: 65px; height: 50px;">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                    @endif

                                </td>

                                <td>
                                    <span class="fw-semibold">
                                        {{ $item->name }}
                                    </span>
                                </td>

                                <td>
                                    {{ $item->subcategory->name ?? 'N/A' }}
                                </td>

                                <td>
                                    {{ $item->subcategory->category->name ?? 'N/A' }}
                                </td>

                                <td>
                                    {{ $item->subcategory->category->section->name ?? 'N/A' }}
                                </td>


                                <td class="fw-semibold text-nowrap">
                                    {{ number_format($item->price, 2) }} EGP
                                </td>


                                <td>

                                    @if ($item->availability === 'available')
                                        <span class="badge text-bg-success">
                                            Available
                                        </span>
                                    @else
                                        <span class="badge text-bg-danger">
                                            Unavailable
                                        </span>
                                    @endif

                                </td>
                                <td>

                                    @if ($item->tags)
                                        {{ '[' }}
                                        @foreach ($item->tags as $tag)
                                            {{ $tag . ',' }}
                                        @endforeach
                                        {{ ']' }}
                                    @else
                                        <span class="badge text-bg-danger">
                                            Null
                                        </span>
                                    @endif

                                </td>

                                <td>

                                    <div class="d-flex justify-content-center gap-1">

                                        <a href="{{ route('menu-items.show', $item) }}" class="btn btn-sm btn-outline-info"
                                            title="View Item">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a href="{{ route('menu-items.edit', $item) }}"
                                            class="btn btn-sm btn-outline-primary" title="Edit Item">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form action="{{ route('menu-items.destroy', $item) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this item?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                title="Delete Item">
                                                <i class="bi bi-trash"></i>
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="8" class="text-center py-5">

                                    <i class="bi bi-inbox fs-1 text-muted"></i>

                                    <p class="text-muted mt-2 mb-0">
                                        No menu items found.
                                    </p>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        @if ($items->hasPages())
            <div class="card-footer bg-white">

                {{ $items->withQueryString()->links('pagination::bootstrap-5') }}

            </div>
        @endif

    </div>


    {{-- Cascading Dropdowns --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const sectionFilter = document.getElementById('sectionFilter');
            const categoryFilter = document.getElementById('categoryFilter');
            const subcategoryFilter = document.getElementById('subcategoryFilter');


            // Load Categories when Section changes
            sectionFilter.addEventListener('change', function() {

                const sectionId = this.value;

                categoryFilter.innerHTML = '<option value="">All Categories</option>';
                subcategoryFilter.innerHTML = '<option value="">All Subcategories</option>';

                // If All Sections selected, reload all categories
                if (!sectionId) {
                    this.form.submit();
                    return;
                }

                categoryFilter.disabled = true;
                subcategoryFilter.disabled = true;

                const url = sectionFilter.dataset.url.replace('__ID__', sectionId);

                fetch(url)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to load categories');
                        }

                        return response.json();
                    })
                    .then(categories => {

                        categories.forEach(category => {

                            const option = document.createElement('option');

                            option.value = category.id;
                            option.textContent = category.name;

                            categoryFilter.appendChild(option);

                        });

                        categoryFilter.disabled = false;
                        subcategoryFilter.disabled = false;

                    })
                    .catch(error => {

                        console.error(error);

                        categoryFilter.disabled = false;
                        subcategoryFilter.disabled = false;

                        alert('Could not load categories.');

                    });

            });


            // Load Subcategories when Category changes
            categoryFilter.addEventListener('change', function() {

                const categoryId = this.value;

                subcategoryFilter.innerHTML = '<option value="">All Subcategories</option>';

                // If All Categories selected, reload subcategories for selected section
                if (!categoryId) {
                    this.form.submit();
                    return;
                }

                subcategoryFilter.disabled = true;

                const url = categoryFilter.dataset.url.replace('__ID__', categoryId);

                fetch(url)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to load subcategories');
                        }

                        return response.json();
                    })
                    .then(subcategories => {

                        subcategories.forEach(subcategory => {

                            const option = document.createElement('option');

                            option.value = subcategory.id;
                            option.textContent = subcategory.name;

                            subcategoryFilter.appendChild(option);

                        });

                        subcategoryFilter.disabled = false;

                    })
                    .catch(error => {

                        console.error(error);

                        subcategoryFilter.disabled = false;

                        alert('Could not load subcategories.');

                    });

            });

        });
    </script>

@endsection
