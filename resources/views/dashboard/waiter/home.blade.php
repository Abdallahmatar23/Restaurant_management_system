@extends('dashboard.layouts.master')

@section('title', 'Waiter Dashboard')
@section('page-title', 'Waiter Dashboard')

@section('content')
    {{-- Quick actions --}}
    <div class="mb-3 d-flex gap-2 flex-wrap">
        @foreach ([['New Order', 'bi-plus-circle', 'orders.create', 'primary'],
                   ['View Tables', 'bi-grid-3x3-gap', 'tables.index', 'secondary'],
                   ['View Reservations', 'bi-calendar-check', 'reservations.index', 'secondary']] as [$t, $i, $r, $c])
            @if (Route::has($r))
                <a href="{{ route($r) }}" class="btn btn-{{ $c }}"><i class="bi {{ $i }} me-1"></i>{{ $t }}</a>
            @else
                <button class="btn btn-{{ $c }}" disabled><i class="bi {{ $i }} me-1"></i>{{ $t }}</button>
            @endif
        @endforeach
    </div>

    <div class="row">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Tables Overview</h3></div>
                <div class="card-body">
                    <div class="text-center text-muted py-4">No tables yet</div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header"><h3 class="card-title">My Active Orders</h3></div>
                <div class="card-body">
                    <div class="text-center text-muted py-4">No active orders</div>
                </div>
            </div>
        </div>
    </div>
@endsection
