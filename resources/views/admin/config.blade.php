@extends('admin.layout')

@section('content')
<div class="mb-5">
    <h2 class="fw-800 mb-1">System Configuration</h2>
    <p class="text-dim">Adjust global parameters, rates, and application settings.</p>
</div>

<div class="row">
    <div class="col-md-8 col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-5">
                <form action="{{ route('admin.config.update') }}" method="POST">
                    @csrf
                    
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="bg-primary bg-opacity-10 p-2 rounded-3">
                            <i class="bi bi-gear-wide-connected text-primary fs-4"></i>
                        </div>
                        <h5 class="mb-0 fw-800">Mining & Rewards</h5>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label text-dim small fw-600">BASE MINING RATE (TAN/HR)</label>
                            <input type="number" step="0.0001" name="mining_rate" class="form-control" value="{{ $config->mining_rate }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dim small fw-600">PREMIUM MINING RATE (TAN/HR)</label>
                            <input type="number" step="0.0001" name="premium_mining_rate" class="form-control" value="{{ $config->premium_mining_rate }}" required>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label text-dim small fw-600">REFERRAL BONUS (%)</label>
                            <div class="input-group">
                                <input type="number" step="0.1" name="referral_bonus" class="form-control" value="{{ $config->referral_bonus }}" required>
                                <span class="input-group-text bg-light bg-opacity-5 border-0 text-dim small">%</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-3 mb-4 mt-5">
                        <div class="bg-warning bg-opacity-10 p-2 rounded-3">
                            <i class="bi bi-bank text-warning fs-4"></i>
                        </div>
                        <h5 class="mb-0 fw-800">Withdrawal Limits</h5>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label text-dim small fw-600">MINIMUM WITHDRAWAL</label>
                            <div class="input-group">
                                <input type="number" step="1" name="min_withdrawal" class="form-control" value="{{ $config->min_withdrawal }}" required>
                                <span class="input-group-text bg-light bg-opacity-5 border-0 text-dim small">TAN</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dim small fw-600">MAXIMUM WITHDRAWAL</label>
                            <div class="input-group">
                                <input type="number" step="1" name="max_withdrawal" class="form-control" value="{{ $config->max_withdrawal }}" required>
                                <span class="input-group-text bg-light bg-opacity-5 border-0 text-dim small">TAN</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-3 mb-4 mt-5">
                        <div class="bg-info bg-opacity-10 p-2 rounded-3">
                            <i class="bi bi-phone text-info fs-4"></i>
                        </div>
                        <h5 class="mb-0 fw-800">Application Updates</h5>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-dim small fw-600">MINIMUM APP VERSION</label>
                        <input type="text" name="min_app_version" class="form-control" value="{{ $config->min_app_version }}" required placeholder="e.g. 1.0.0">
                        <!-- <div class="form-text text-dim opacity-50 small mt-2">Users with versions lower than this will be prompted to update.</div> -->
                    </div>

                    <div class="mb-5">
                        <label class="form-label text-dim small fw-600">APP UPDATE URL</label>
                        <input type="url" name="app_update_url" class="form-control" value="{{ $config->app_update_url }}" required placeholder="https://play.google.com/store/...">
                    </div>

                    <div class="p-3 rounded-4 bg-danger bg-opacity-5 border border-danger border-opacity-10 mb-5">
                        <div class="form-check form-switch mb-0 d-flex align-items-center gap-3">
                            <input class="form-check-input" type="checkbox" name="maintenance_mode" value="1" id="maintenanceMode" {{ $config->maintenance_mode ? 'checked' : '' }} style="width: 3em; height: 1.5em; cursor: pointer;">
                            <div>
                                <label class="form-check-label fw-800 text-danger mb-0 d-block" for="maintenanceMode" style="cursor: pointer;">Enable Maintenance Mode</label>
                                <small class="text-dim opacity-75 text-white">When enabled, users will see a maintenance screen and will not be able to use the app.</small>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-top border-white border-opacity-5">
                        <button type="submit" class="btn btn-primary w-100 py-3 shadow-sm fw-800">SAVE ALL CONFIGURATIONS</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
