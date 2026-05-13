@extends('admin.layout')

@section('content')
<div class="mb-5">
    <h2 class="fw-800 mb-1">Edit User Profile</h2>
    <p class="text-dim">Update the user's personal information and balance.</p>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header border-0 pb-0">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-person-gear text-primary"></i>
                    <h5 class="mb-0 fw-700">Account Details</h5>
                </div>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="name" class="form-label text-dim small fw-600">FULL NAME</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required placeholder="Enter full name">
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label text-dim small fw-600">EMAIL ADDRESS</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required placeholder="Enter email address">
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col-md-6">
                            <label for="balance" class="form-label text-dim small fw-600">CURRENT BALANCE (TAN)</label>
                            <div class="input-group">
                                <input type="number" step="0.01" class="form-control" id="balance" name="balance" value="{{ old('balance', $user->balance) }}" required>
                                <span class="input-group-text bg-light bg-opacity-5 border-0 text-dim">TAN</span>
                            </div>
                        </div>
                        <!-- <div class="col-md-6 d-flex align-items-end">
                             <div class="alert alert-primary py-3 px-4 mb-0 w-100 bg-primary bg-opacity-5 border-0 rounded-4">
                                <div class="d-flex align-items-center gap-3">
                                    <i class="bi bi-info-circle-fill text-primary fs-4"></i>
                                    <small class="text-dim">Role, Status, and Premium status can be managed directly from the user list actions.</small>
                                </div>
                             </div>
                        </div> -->
                    </div>

                    <div class="d-flex justify-content-end gap-3 pt-3 border-top border-white border-opacity-5">
                        <a href="{{ route('admin.users') }}" class="btn btn-outline-light border-0 bg-light text-dark bg-opacity-5">Canel</a>
                        <button type="submit" class="btn btn-primary px-5">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
