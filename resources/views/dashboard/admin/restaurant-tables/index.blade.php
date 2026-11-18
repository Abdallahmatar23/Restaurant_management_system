@extends('dashboard.layouts.master')

@section('title', 'Restaurant Tables')
@section('page-title', 'Restaurant Tables')

@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
            <div>
                <h4 class="mb-1">Restaurant Tables</h4>
                <p class="text-muted mb-0">Manage tables, capacities, statuses and QR codes.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('restaurant-tables.to.qr.bulk-generate') }}" class="btn btn-outline-primary">
                <i class="bi bi-qr-code me-1"></i> Generate All QR Codes
                </a>
                <a href="{{ route('restaurant-tables.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i> Add Table
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <form action="{{ route('restaurant-tables.index') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="type" class="form-label">Table Type</label>
                        <select name="type" id="type" class="form-select">
                            <option value="">All Types</option>
                            <option value="private" @selected(request('type') === 'private')>Private</option>
                            <option value="public" @selected(request('type') === 'public')>Public</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">All Statuses</option>
                            @foreach (['available' => 'Available', 'occupied' => 'Occupied', 'reserved' => 'Reserved', 'maintenance' => 'Maintenance'] as $value => $label)
                                <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 d-flex gap-2">
                        <button class="btn btn-primary flex-grow-1" type="submit">
                            <i class="bi bi-funnel me-1"></i> Filter
                        </button>
                        <a href="{{ route('restaurant-tables.index') }}" class="btn btn-outline-secondary">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        @php
            $statusClasses = [
                'available' => 'success',
                'occupied' => 'danger',
                'reserved' => 'warning',
                'maintenance' => 'secondary',
            ];
        @endphp

        <div class="row g-3">
            @forelse ($tables as $table)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <div class="text-muted small">Table Number</div>
                                    <h4 class="mb-0">{{ $table->table_number }}</h4>
                                </div>
                                <span class="badge text-bg-{{ $statusClasses[$table->status] ?? 'secondary' }}">
                                    {{ ucfirst($table->status) }}
                                </span>
                            </div>

                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Type</span>
                                <span class="fw-semibold">{{ ucfirst($table->type) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Capacity</span>
                                <span class="fw-semibold">{{ $table->min_capacity }} - {{ $table->max_capacity }}
                                    persons</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Area</span>
                                <span class="fw-semibold">{{ ucfirst($table->area) ?: 'Not specified' }}</span>
                            </div>

                            <hr>
                            <div class="d-flex flex-wrap gap-2">
                                <a href="{{ route('restaurant-tables.show', $table) }}"
                                    class="btn btn-sm btn-outline-primary" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('restaurant-tables.edit', $table) }}"
                                    class="btn btn-sm btn-outline-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="{{ route('restaurant-tables.qr.show', $table) }}" class="btn btn-sm btn-outline-dark" title="QR Code">
                                <i class="bi bi-qr-code"></i>
                                </a>
                                <form action="{{ route('restaurant-tables.destroy', $table) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this table?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center py-5">
                            <i class="bi bi-table fs-1 text-muted"></i>
                            <h5 class="mt-3">No tables found</h5>
                            <p class="text-muted">Add your first restaurant table or change the filters.</p>
                            <a href="{{ route('restaurant-tables.create') }}" class="btn btn-primary">Add Table</a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $tables->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
