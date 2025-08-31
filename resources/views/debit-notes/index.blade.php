@extends('layouts.app')

@section('title', 'Debit Notes')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Debit Notes</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <!-- Search and Filters -->
                    <div class="p-3">
                        <form method="GET" action="{{ route('debit-notes.index') }}" class="row g-3">
                            <div class="col-md-3">
                                <div class="input-group input-group-outline">
                                    <label class="form-label">Search Debit Notes</label>
                                    <input type="text" class="form-control" name="search"
                                        value="{{ request('search') }}" title="Search by number, customer...">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group input-group-outline">
                                    <label class="form-label">Status</label>
                                    <select class="form-control" name="status">
                                        <option value="" selected disabled></option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>
                                            Approved</option>
                                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid
                                        </option>
                                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                                            Cancelled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group input-group-outline">
                                    <input type="date" class="form-control" name="date_from"
                                        value="{{ request('date_from') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group input-group-outline">
                                    <input type="date" class="form-control" name="date_to"
                                        value="{{ request('date_to') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary me-2">Search</button>
                                <a href="{{ route('debit-notes.index') }}" class="btn btn-secondary">Clear</a>
                            </div>
                        </form>
                    </div>

                    <!-- Results -->
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Debit
                                        Note</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Customer</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Issue Date</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Due Date</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Amount</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($debitNotes as $debitNote)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $debitNote->debit_note_number }}</h6>
                                                    <p class="text-xs text-secondary mb-0">Ref:
                                                        {{ $debitNote->reference_number ?? 'N/A' }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-0 text-sm">{{ $debitNote->customer->name }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $debitNote->customer->company }}
                                                </p>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ $debitNote->created_at ? $debitNote->created_at->format('M d, Y') : 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ $debitNote->updated_at ? $debitNote->updated_at->format('M d, Y') : 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                ${{ number_format($debitNote->total_amount, 2) }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            @if ($debitNote->status === 'pending')
                                                <span class="badge badge-sm bg-gradient-warning">Pending</span>
                                            @elseif($debitNote->status === 'approved')
                                                <span class="badge badge-sm bg-gradient-success">Approved</span>
                                            @elseif($debitNote->status === 'paid')
                                                <span class="badge badge-sm bg-gradient-primary">Paid</span>
                                            @elseif($debitNote->status === 'cancelled')
                                                <span class="badge badge-sm bg-gradient-danger">Cancelled</span>
                                            @else
                                                <span
                                                    class="badge badge-sm bg-gradient-secondary">{{ ucfirst($debitNote->status) }}</span>
                                            @endif
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('debit-notes.show', $debitNote) }}"
                                                    class="btn btn-link text-dark px-2 mb-0" title="View Details">
                                                    <i class="material-symbols-rounded text-sm">visibility</i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <p class="text-secondary">No debit notes found matching your criteria.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center py-3">
                        {{ $debitNotes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Demo Info Card -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-3">Demo Information</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="text-sm mb-2"><strong>Search Features:</strong></p>
                            <ul class="text-sm text-secondary">
                                <li>Search by debit note number, reference, or customer</li>
                                <li>Filter by status and date range</li>
                                <li>View financial details and payment status</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <p class="text-sm mb-2"><strong>Financial Workflow:</strong></p>
                            <ul class="text-sm text-secondary">
                                <li>Click "View" to see debit note details</li>
                                <li>Track payment status and due dates</li>
                                <li>Monitor accounts receivable</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
