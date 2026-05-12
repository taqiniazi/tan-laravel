@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Dashboard Overview</h2>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <h6 class="text-secondary mb-2">Total Users</h6>
                <h3 class="mb-0">{{ number_format($stats['total_users']) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <h6 class="text-secondary mb-2">New Users (24h)</h6>
                <h3 class="mb-0 text-success">+{{ number_format($stats['new_users_24h']) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <h6 class="text-secondary mb-2">Active Miners</h6>
                <h3 class="mb-0" style="color: var(--primary);">{{ number_format($stats['active_miners']) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <h6 class="text-secondary mb-2">Premium Users</h6>
                <h3 class="mb-0 text-warning">{{ number_format($stats['premium_users']) }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header pb-0 border-0 pt-4">
                <h5 class="mb-0">Economics</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3 border-bottom border-secondary pb-2">
                    <span class="text-secondary">Pending Withdrawals</span>
                    <span class="fw-bold">{{ number_format($stats['pending_withdrawals']) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-3 border-bottom border-secondary pb-2">
                    <span class="text-secondary">Total Approved (24h)</span>
                    <span class="fw-bold">{{ number_format($stats['total_approved_24h'], 2) }} TAN</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
