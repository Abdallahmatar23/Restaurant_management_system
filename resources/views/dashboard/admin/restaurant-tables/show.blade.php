@extends('dashboard.layouts.master')

@section('title', 'Table Details')
@section('page-title', 'Table Details')

@section('content')
@php
    $statusClasses = [
        'available' => 'success',
        'occupied' => 'danger',
        'reserved' => 'warning',
        'maintenance' => 'secondary',
    ];
@endphp

<div class="container-fluid">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
        <div>
            <a href="{{ route('restaurant-tables.index') }}" class="text-decoration-none">
                <i class="bi bi-arrow-left"></i> Back to Tables
            </a>
            <h4 class="mt-2 mb-0">{{ $restaurantTable->table_number }}</h4>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('restaurant-tables.qr.show', $restaurantTable) }}" class="btn btn-outline-dark">
                <i class="bi bi-qr-code me-1"></i> QR Code
            </a>
            <a href="{{ route('restaurant-tables.edit', $restaurantTable) }}" class="btn btn-primary">
                <i class="bi bi-pencil me-1"></i> Edit Table
            </a>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="mb-0">Table Information</h5>
                        <span class="badge text-bg-{{ $statusClasses[$restaurantTable->status] ?? 'secondary' }}">
                            {{ ucfirst($restaurantTable->status) }}
                        </span>
                    </div>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="text-muted small">Table Number</div>
                            <div class="fw-semibold fs-5">{{ $restaurantTable->table_number }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted small">Type</div>
                            <div class="fw-semibold">{{ ucfirst($restaurantTable->type) }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted small">Minimum Capacity</div>
                            <div class="fw-semibold">{{ $restaurantTable->min_capacity }} persons</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted small">Maximum Capacity</div>
                            <div class="fw-semibold">{{ $restaurantTable->max_capacity }} persons</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted small">Area</div>
                            <div class="fw-semibold">{{ ucfirst($restaurantTable->area) ?: 'Not specified' }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted small">Notes</div>
                            <div class="fw-semibold">{{ $restaurantTable->notes ?: 'No notes' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h5 class="mb-3">QR Code</h5>
                    <div class="text-center py-3">
                        <i class="bi bi-qr-code fs-1"></i>
                        <p class="text-muted mt-2 mb-3">Open the QR Code page to view, print or download this table's code.</p>
                        <a href="{{ route('restaurant-tables.qr.show', $restaurantTable) }}" class="btn btn-outline-primary">
                            Manage QR Code
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-muted small">Created At</div>
                    <div class="fw-semibold">{{ $restaurantTable->created_at?->format('d M Y, h:i A') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-muted small">Last Updated</div>
                    <div class="fw-semibold">{{ $restaurantTable->updated_at?->format('d M Y, h:i A') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
