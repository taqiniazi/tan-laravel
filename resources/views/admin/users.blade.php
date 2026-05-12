@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>User Management</h2>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">User</th>
                        <th>Balance</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Joined</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex flex-column">
                                <span class="fw-bold">{{ $user->name }}</span>
                                <span class="text-secondary small">{{ $user->email }}</span>
                            </div>
                        </td>
                        <td>{{ number_format($user->balance, 2) }} TAN</td>
                        <td>
                            <span class="badge {{ $user->role === 'admin' ? 'bg-primary' : 'bg-secondary' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>
                            @if($user->is_flagged)
                                <span class="badge bg-danger">Flagged</span>
                            @else
                                <span class="badge bg-success" style="background-color: rgba(0,255,136,0.2)!important; color: #00ff88!important;">Active</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <form action="{{ route('admin.users.role', $user->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $user->role === 'admin' ? 'btn-outline-warning' : 'btn-outline-primary' }}">
                                        Make {{ $user->role === 'admin' ? 'User' : 'Admin' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.users.flag', $user->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $user->is_flagged ? 'btn-success' : 'btn-outline-danger' }}">
                                        {{ $user->is_flagged ? 'Unflag' : 'Flag' }}
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-secondary">No users found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer border-0 bg-transparent pt-3">
        {{ $users->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
