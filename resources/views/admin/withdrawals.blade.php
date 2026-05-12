@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Pending Withdrawals</h2>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">User</th>
                        <th>Amount</th>
                        <th>Network</th>
                        <th>Wallet Address</th>
                        <th>Requested</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($withdrawals as $withdrawal)
                    <tr>
                        <td class="ps-4">
                            @if($withdrawal->user)
                                <div class="d-flex flex-column">
                                    <span class="fw-bold">{{ $withdrawal->user->name }}</span>
                                    <span class="text-secondary small">{{ $withdrawal->user->email }}</span>
                                </div>
                            @else
                                <span class="text-secondary">Unknown User</span>
                            @endif
                        </td>
                        <td class="fw-bold text-warning">{{ number_format($withdrawal->amount, 2) }} TAN</td>
                        <td><span class="badge bg-secondary">{{ strtoupper($withdrawal->network) }}</span></td>
                        <td>
                            <code class="text-secondary">{{ $withdrawal->wallet_address }}</code>
                        </td>
                        <td>{{ $withdrawal->created_at->diffForHumans() }}</td>
                        <td class="text-end pe-4">
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#approveModal{{ $withdrawal->id }}">
                                Approve
                            </button>
                            <form action="{{ route('admin.withdrawals.reject') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="withdrawal_id" value="{{ $withdrawal->id }}">
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Reject this withdrawal and refund the balance?')">
                                    Reject
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Approve Modal -->
                    <div class="modal fade" id="approveModal{{ $withdrawal->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content bg-dark">
                                <form action="{{ route('admin.withdrawals.approve') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="withdrawal_id" value="{{ $withdrawal->id }}">
                                    <div class="modal-header border-secondary">
                                        <h5 class="modal-title">Approve Withdrawal</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Approving {{ number_format($withdrawal->amount, 2) }} TAN for {{ $withdrawal->user ? $withdrawal->user->name : 'Unknown' }} on {{ strtoupper($withdrawal->network) }}.</p>
                                        <p>Address: <code>{{ $withdrawal->wallet_address }}</code></p>
                                        
                                        <div class="mb-3 mt-4">
                                            <label class="form-label">Transaction Hash</label>
                                            <input type="text" name="tx_hash" class="form-control" placeholder="0x..." required>
                                            <div class="form-text text-secondary">Enter the blockchain transaction hash as proof of payment.</div>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-secondary">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Confirm Approval</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-secondary">
                            <i class="bi bi-check2-circle fs-1 d-block mb-3"></i>
                            No pending withdrawals.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
