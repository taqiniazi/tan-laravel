@extends('admin.layout')

@section('content')
<div class="mb-5">
    <h2 class="fw-800 mb-1">Dashboard Overview</h2>
    <p class="text-dim">Welcome back to your administration panel.</p>
</div>

<div class="row g-4 mb-5">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="bg-primary bg-opacity-10 p-2 rounded-3">
                        <i class="bi bi-people text-primary fs-4"></i>
                    </div>
                </div>
                <h6 class="text-dim mb-1 fw-600">Total Users</h6>
                <h2 class="mb-0 fw-800">{{ number_format($stats['total_users']) }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="bg-success bg-opacity-10 p-2 rounded-3">
                        <i class="bi bi-person-plus text-success fs-4"></i>
                    </div>
                    <span class="badge bg-success bg-opacity-10 text-success border-0 small">+{{ number_format($stats['new_users_24h']) }}</span>
                </div>
                <h6 class="text-dim mb-1 fw-600">New Users (24h)</h6>
                <h2 class="mb-0 fw-800 text-success">{{ number_format($stats['new_users_24h']) }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="bg-primary bg-opacity-10 p-2 rounded-3">
                        <i class="bi bi-cpu text-primary fs-4"></i>
                    </div>
                </div>
                <h6 class="text-dim mb-1 fw-600">Active Miners</h6>
                <h2 class="mb-0 fw-800 text-primary">{{ number_format($stats['active_miners']) }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="bg-warning bg-opacity-10 p-2 rounded-3">
                        <i class="bi bi-star text-warning fs-4"></i>
                    </div>
                </div>
                <h6 class="text-dim mb-1 fw-600">Premium Users</h6>
                <h2 class="mb-0 fw-800 text-warning">{{ number_format($stats['premium_users']) }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card h-100 shadow-sm">
            <div class="card-header border-0 pb-0">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-graph-up text-primary"></i>
                    <h5 class="mb-0 fw-700">Financial Summary</h5>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-light bg-opacity-10 rounded-4">
                    <div>
                        <span class="text-dim d-block mb-1">Pending Withdrawals</span>
                        <h4 class="mb-0 fw-700">{{ number_format($stats['pending_withdrawals']) }}</h4>
                    </div>
                    <a href="{{ route('admin.withdrawals') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="d-flex justify-content-between align-items-center p-3 bg-light bg-opacity-10 rounded-4">
                    <div>
                        <span class="text-dim d-block mb-1">Approved (24h)</span>
                        <h4 class="mb-0 fw-700 text-primary">{{ number_format($stats['total_approved_24h'], 2) }} <small class="fs-6">TAN</small></h4>
                    </div>
                    <i class="bi bi-check2-circle text-primary fs-3"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
