@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>System Configuration</h2>
</div>

<div class="row">
    <div class="col-md-8 col-lg-6">
        <div class="card">
            <div class="card-body p-4">
                <form action="{{ route('admin.config.update') }}" method="POST">
                    @csrf
                    
                    <h5 class="mb-4 text-primary">Mining Settings</h5>
                    <div class="mb-3">
                        <label class="form-label">Base Mining Rate (TAN/hr)</label>
                        <input type="number" step="0.0001" name="mining_rate" class="form-control" value="{{ $config->mining_rate }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Referral Bonus (TAN)</label>
                        <input type="number" step="0.1" name="referral_bonus" class="form-control" value="{{ $config->referral_bonus }}" required>
                    </div>

                    <h5 class="mb-4 mt-5 text-primary">Withdrawal Limits</h5>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Minimum Withdrawal</label>
                            <input type="number" step="1" name="min_withdrawal" class="form-control" value="{{ $config->min_withdrawal }}" required>
                        </div>
                        <div class="col-md-6 mt-3 mt-md-0">
                            <label class="form-label">Maximum Withdrawal</label>
                            <input type="number" step="1" name="max_withdrawal" class="form-control" value="{{ $config->max_withdrawal }}" required>
                        </div>
                    </div>

                    <h5 class="mb-4 mt-5 text-primary">App Settings</h5>
                    <div class="mb-3">
                        <label class="form-label">Minimum App Version</label>
                        <input type="text" name="min_app_version" class="form-control" value="{{ $config->min_app_version }}" required>
                        <div class="form-text text-secondary">Users with older versions will be forced to update.</div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">App Update URL</label>
                        <input type="url" name="app_update_url" class="form-control" value="{{ $config->app_update_url }}" required>
                    </div>

                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input" type="checkbox" name="maintenance_mode" value="1" id="maintenanceMode" {{ $config->maintenance_mode ? 'checked' : '' }}>
                        <label class="form-check-label text-danger" for="maintenanceMode">
                            Enable Maintenance Mode
                        </label>
                    </div>

                    <hr class="border-secondary my-4">
                    
                    <button type="submit" class="btn btn-primary w-100">Save Configuration</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
