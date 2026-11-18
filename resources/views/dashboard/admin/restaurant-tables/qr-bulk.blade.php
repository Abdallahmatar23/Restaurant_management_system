@extends('dashboard.layouts.master')

@section('title', 'Generate Table QR Codes')
@section('page-title', 'Generate Table QR Codes')

@section('content')
    <div class="container-fluid">
        <div class="mb-4">
            <a href="{{ route('restaurant-tables.index') }}" class="text-decoration-none">
                <i class="bi bi-arrow-left"></i> Back to Tables
            </a>
            <h4 class="mt-2 mb-1">Generate All QR Codes</h4>
            <p class="text-muted mb-0">Generate or refresh QR codes for the restaurant tables.</p>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="alert alert-info">
                    This action should generate QR codes for all tables. If it regenerates tokens, previously printed QR
                    codes will stop working.
                </div>
                <form action="{{ route('restaurant-tables.qr.bulk-generate') }}" method="POST"
                    onsubmit="return confirm('Generate QR codes for all tables?')">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-qr-code me-1"></i> Generate All QR Codes
                    </button>
                    <a href="{{ route('restaurant-tables.index') }}" class="btn btn-light">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection
