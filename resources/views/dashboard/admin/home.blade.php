@extends('dashboard.layouts.master')

@section('title', 'Admin Dashboard')
@section('page-title', 'Admin Dashboard')

@section('content')
    {{-- Statistics cards --}}
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-primary">
                <div class="inner"><h3>0 EGP</h3><p>Today's Revenue</p></div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-success">
                <div class="inner"><h3>0</h3><p>Total Orders</p></div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-warning">
                <div class="inner"><h3>0</h3><p>Occupied Tables</p></div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-danger">
                <div class="inner"><h3>0</h3><p>Pending Orders</p></div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Recent orders --}}
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Recent Orders (last 10)</h3></div>
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr><th>#</th><th>Table</th><th>Waiter</th><th>Total</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                            <tr><td colspan="5" class="text-center text-muted py-4">No orders yet</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Quick links --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Quick Links</h3></div>
                <div class="list-group list-group-flush">
                    @php
                        $links = [
                            ['Manage Users',  'bi-people',        'users.create'],
                            ['Manage Menu',   'bi-journal-text',  'sections.index'],
                            ['Manage Tables', 'bi-grid-3x3-gap',  'tables.index'],
                            ['View Reports',  'bi-bar-chart-line','reports.index'],
                        ];
                    @endphp
                    @foreach ($links as [$title, $icon, $route])
                        @if (Route::has($route))
                            <a href="{{ route($route) }}" class="list-group-item list-group-item-action">
                                <i class="bi {{ $icon }} me-2"></i>{{ $title }}
                            </a>
                        @else
                            <span class="list-group-item text-muted">
                                <i class="bi {{ $icon }} me-2"></i>{{ $title }} <small>(coming soon)</small>
                            </span>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
