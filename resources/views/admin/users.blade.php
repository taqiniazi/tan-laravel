@extends('admin.layout')

@section('content')
<div class="mb-5">
    <h2 class="fw-800 mb-1">User Management</h2>
    <p class="text-dim">Search, edit, and manage all users in the system.</p>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">User</th>
                        <th>Balance</th>
                        <th>Role</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Joined</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="bi bi-person text-primary"></i>
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="fw-bold">{{ $user->name }}</span>
                                    <span class="text-dim small">{{ $user->email }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="fw-600">{{ number_format($user->balance, 2) }}</span>
                            <small class="text-dim">TAN</small>
                        </td>
                        <td>
                            <span class="badge {{ $user->role === 'admin' ? 'bg-primary text-dark' : 'bg-secondary bg-opacity-10 text-dim' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>
                            @if($user->is_premium)
                                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25">Premium</span>
                            @else
                                <span class="badge bg-light bg-opacity-10 text-dim">Simple</span>
                            @endif
                        </td>
                        <td>
                            @if($user->is_flagged)
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25">Flagged</span>
                            @else
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">Active</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end align-items-center gap-2">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-outline-light d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; border-radius: 8px;" title="Edit User">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                
                                <form action="{{ route('admin.users.premium', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $user->is_premium ? 'btn-outline-secondary' : 'btn-outline-warning' }} rounded-pill px-3 fw-600" style="font-size: 0.75rem;">
                                        {{ $user->is_premium ? 'Simple' : 'Premium' }}
                                    </button>
                                </form>

                                <form action="{{ route('admin.users.flag', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $user->is_flagged ? 'btn-success text-dark' : 'btn-outline-danger' }} rounded-pill px-3 fw-600" style="font-size: 0.75rem;">
                                        {{ $user->is_flagged ? 'Unflag' : 'Flag' }}
                                    </button>
                                </form>

                                <!-- <form action="{{ route('admin.users.role', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $user->role === 'admin' ? 'btn-outline-warning' : 'btn-outline-primary' }} rounded-pill px-3 fw-600" style="font-size: 0.75rem;">
                                        {{ $user->role === 'admin' ? 'User' : 'Admin' }}
                                    </button>
                                </form> -->

                                <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; border-radius: 8px;" title="Delete User">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-dim">
                            <i class="bi bi-search fs-1 d-block mb-3 opacity-25"></i>
                            No users found in the system.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer border-0 bg-transparent py-4">
        {{ $users->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
