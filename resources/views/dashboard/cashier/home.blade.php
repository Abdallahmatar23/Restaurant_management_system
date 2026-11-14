@extends('dashboard.layouts.master')

@section('title', 'Cashier Dashboard')
@section('page-title', 'Cashier Dashboard')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="small-box text-bg-warning">
                <div class="inner"><h3>0</h3><p>Pending Bills</p></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="small-box text-bg-success">
                <div class="inner"><h3>0 EGP</h3><p>Today's Revenue</p></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Orders Ready for Billing</h3></div>
                <div class="card-body text-center text-muted py-4">No orders ready</div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Recent Bills</h3></div>
                <div class="card-body text-center text-muted py-4">No bills yet</div>
            </div>
        </div>
    </div>
@endsection
