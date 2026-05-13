@extends('admin.layout')

@section('content')
<div class="mb-5">
    <h2 class="fw-800 mb-1">Pending Withdrawals</h2>
    <p class="text-dim">Process and manage user withdrawal requests.</p>
</div>

<div class="card border-0 shadow-sm">
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
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="bi bi-wallet2 text-primary"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold">{{ $withdrawal->user->name }}</span>
                                        <span class="text-dim small">{{ $withdrawal->user->email }}</span>
                                    </div>
                                </div>
                            @else
                                <span class="text-dim">Unknown User</span>
                            @endif
                        </td>
                        <td>
                            <h5 class="mb-0 fw-700 text-warning">{{ number_format($withdrawal->amount, 2) }} <small class="fs-6">TAN</small></h5>
                        </td>
                        <td>
                            <span class="badge bg-light bg-opacity-10 text-dim border border-white border-opacity-10 px-3">{{ strtoupper($withdrawal->network) }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2 bg-light bg-opacity-5 p-2 rounded-3" style="width: fit-content;">
                                <code class="text-dim small">{{ substr($withdrawal->wallet_address, 0, 8) }}...{{ substr($withdrawal->wallet_address, -8) }}</code>
                                <button class="btn btn-sm p-0 border-0 text-primary" onclick="navigator.clipboard.writeText('{{ $withdrawal->wallet_address }}')" title="Copy">
                                    <i class="bi bi-clipboard"></i>
                                </button>
                            </div>
                        </td>
                        <td>
                            <span class="text-dim small">{{ $withdrawal->created_at->diffForHumans() }}</span>
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-sm btn-primary px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#approveModal{{ $withdrawal->id }}">
                                    Approve
                                </button>
                                <form action="{{ route('admin.withdrawals.reject') }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="withdrawal_id" value="{{ $withdrawal->id }}">
                                    <button type="submit" class="btn btn-sm btn-outline-danger border-0 bg-danger bg-opacity-10" onclick="return confirm('Reject this withdrawal and refund the balance?')">
                                        Reject
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <!-- Approve Modal -->
                    <div class="modal fade" id="approveModal{{ $withdrawal->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow-lg" style="background-color: var(--bg-card); border-radius: 24px;">
                                <form action="{{ route('admin.withdrawals.approve') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="withdrawal_id" value="{{ $withdrawal->id }}">
                                    <div class="modal-header border-0 p-4">
                                        <h5 class="modal-title fw-800 text-primary">Approve Payment</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-4 pt-0">
                                        <div class="bg-light bg-opacity-5 p-4 rounded-4 mb-4">
                                            <div class="d-flex justify-content-between mb-2">
                                                <span class="text-dim">Amount</span>
                                                <span class="fw-800 text-warning">{{ number_format($withdrawal->amount, 2) }} TAN</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span class="text-dim">Network</span>
                                                <span class="fw-700">{{ strtoupper($withdrawal->network) }}</span>
                                            </div>
                                            <div class="mb-0">
                                                <span class="text-dim d-block mb-1">Wallet Address</span>
                                                <code class="text-primary break-all small">{{ $withdrawal->wallet_address }}</code>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label text-dim small fw-600">TRANSACTION HASH (TXID)</label>
                                            <input type="text" name="tx_hash" class="form-control" placeholder="Enter proof of payment hash" required>
                                            <div class="form-text text-dim opacity-50 small">This hash will be shown to the user as proof of payment.</div>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0 p-4 pt-0">
                                        <button type="button" class="btn btn-outline-light border-0 bg-light bg-opacity-5" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary px-4">Confirm Approval</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-dim">
                            <i class="bi bi-check2-circle fs-1 d-block mb-3 opacity-25"></i>
                            No pending withdrawals at the moment.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
