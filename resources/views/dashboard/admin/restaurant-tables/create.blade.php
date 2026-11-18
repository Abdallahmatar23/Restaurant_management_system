@extends('dashboard.layouts.master')

@section('title', 'Add Table')
@section('page-title', 'Add Table')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('restaurant-tables.index') }}" class="text-decoration-none">
            <i class="bi bi-arrow-left"></i> Back to Tables
        </a>
        <h4 class="mt-2 mb-1">Add New Table</h4>
        <p class="text-muted mb-0">Enter the table information below.</p>
    </div>
    @include('dashboard.admin.restaurant-tables.form')
</div>
@endsection
