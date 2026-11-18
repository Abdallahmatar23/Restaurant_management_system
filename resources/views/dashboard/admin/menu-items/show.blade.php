@extends('dashboard.layouts.master')

@section('title', $item->name)
@section('page-title', 'Menu Item Details')

@section('content')

    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('sections.show', $item->subcategory->category->section_id) }}">
                        {{ $item->subcategory->category->section->name }}
                    </a>
                </li>

                <li class="breadcrumb-item">
                    <a href="{{ route('categories.show', $item->subcategory->category_id) }}">
                        {{ $item->subcategory->category->name }}
                    </a>
                </li>

                <li class="breadcrumb-item">
                    <a href="{{ route('subcategories.show', $item->subcategory_id) }}">
                        {{ $item->subcategory->name }}
                    </a>
                </li>

                <li class="breadcrumb-item active text-body-secondary" aria-current="page">
                    {{ $item->name }}
                </li>
            </ol>
        </nav>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-lg-5">
                    <img
                        src="{{ asset($item->image) }}"
                        alt="{{ $item->name }}"
                        class="img-fluid rounded-3 w-100"
                        style="height: 350px; object-fit: cover;"
                    >
                </div>

                <div class="col-lg-7">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                        <div>
                            <span class="badge bg-primary-subtle text-primary mb-2">
                                Menu Item
                            </span>

                            <h2 class="fw-bold mb-1">
                                {{ $item->name }}
                            </h2>
                        </div>

                        <span class="badge {{ $item->availability === 'available' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} fs-6">
                            {{ $item->availability === 'available' ? 'Available' : 'Out of Stock' }}
                        </span>
                    </div>

                    <div class="mb-4">
                        <span class="text-body-secondary small">
                            Price
                        </span>

                        <h3 class="fw-bold text-primary mb-0">
                            {{ number_format($item->price, 2) }} EGP
                        </h3>
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-bold">
                            Description
                        </h6>

                        <p class="text-body-secondary mb-0">
                            {{ $item->description ?: 'No description available.' }}
                        </p>
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-bold">
                            <i class="bi bi-clock text-primary me-1"></i>
                            Preparation Time
                        </h6>

                        <p class="text-body-secondary mb-0">
                            {{ $item->preparation_time }} Minutes
                        </p>
                    </div>

                    <div class="border rounded-3 p-3 mb-4 bg-body-tertiary">
                        <h6 class="fw-bold mb-3">
                            Menu Classification
                        </h6>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <small class="text-body-secondary d-block mb-1">
                                    Section
                                </small>

                                <strong class="text-body">
                                    {{ $item->subcategory->category->section->name }}
                                </strong>
                            </div>

                            <div class="col-md-4">
                                <small class="text-body-secondary d-block mb-1">
                                    Category
                                </small>

                                <strong class="text-body">
                                    {{ $item->subcategory->category->name }}
                                </strong>
                            </div>

                            <div class="col-md-4">
                                <small class="text-body-secondary d-block mb-1">
                                    Subcategory
                                </small>

                                <strong class="text-body">
                                    {{ $item->subcategory->name }}
                                </strong>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('menu-items.edit', $item->id) }}"
                           class="btn btn-primary">

                            <i class="bi bi-pencil me-1"></i>
                            Edit Item
                        </a>

                        <a href="{{ route('subcategories.show', $item->subcategory_id) }}"
                           class="btn btn-outline-secondary">

                            Back to Subcategory
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-calendar-plus text-primary me-2"></i>
                        Created At
                    </h6>

                    <p class="text-body-secondary mb-0">
                        {{ $item->created_at->format('d M Y - h:i A') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-clock-history text-primary me-2"></i>
                        Last Updated
                    </h6>

                    <p class="text-body-secondary mb-0">
                        {{ $item->updated_at->format('d M Y - h:i A') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

@endsection
