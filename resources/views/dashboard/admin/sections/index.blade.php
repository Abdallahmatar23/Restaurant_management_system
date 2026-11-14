{{-- @foreach ($sections as $section)
{{$section->id}}
@endforeach
@dd() --}}
@extends('dashboard.layouts.master')

@section('title', 'Sections')
@section('page-title', 'Menu Sections')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Sections <small class="text-muted">(drag to reorder)</small></h3>
            <a href="{{ route('sections.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Add
                Section</a>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width:40px"></th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Order</th>
                        <th>Categories Count</th>
                        <th>Status</th>
                        <th style="width:150px">Actions</th>
                    </tr>
                </thead>
                <tbody id="sortable" data-url="{{ route('sections.reorder') }}">
                    @forelse ($sections as $section)
                        <tr data-id="{{ $section->id }}">
                            <td class="text-muted" style="cursor:move"><i class="bi bi-grip-vertical"></i></td>
                            <td>{{ $section->name }}</td>
                            <td>{{ Str::limit($section->description, 50) }}</td>
                            <td>{{ $section->display_order }}</td>
                            <td>{{ $section->categories_count }}</td>
                            <td><span
                                    class="badge text-bg-{{ $section->status === 'active' ? 'success' : 'secondary' }}">{{ $section->status === 'active' ? 'Active' : 'Inactive' }}</span>
                            </td>
                            <td>
                                <a href="{{ route('sections.show', $section) }}" class="btn btn-sm btn-outline-info"><i
                                        class="bi bi-eye"></i></a>
                                <a href="{{ route('sections.edit', $section) }}" class="btn btn-sm btn-outline-primary"><i
                                        class="bi bi-pencil"></i></a>
                                <form action="{{ route('sections.destroy', $section) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Delete this section?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">No sections yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    @include('dashboard.admin.partials.sortable')
@endpush
