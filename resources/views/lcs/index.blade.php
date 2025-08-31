@extends('layouts.app')

@section('title', 'Letters of Credit')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Letters of Credit</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <!-- Search and Filters -->
                    <div class="p-3">
                        <form method="GET" action="{{ route('lcs.index') }}" class="row g-3">
                            <div class="col-md-3">
                                <div class="input-group input-group-outline">
                                    <label class="form-label">Search L/Cs</label>
                                    <input type="text" class="form-control" name="search"
                                        value="{{ request('search') }}" title="Search by L/C number, bank, customer...">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group input-group-outline">
                                    <label class="form-label">Status</label>
                                    <select class="form-control" name="status">
                                        <option value="" selected disabled></option>
                                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>
                                            Expired</option>
                                        <option value="utilized" {{ request('status') == 'utilized' ? 'selected' : '' }}>
                                            Utilized</option>
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
                                <a href="{{ route('lcs.index') }}" class="btn btn-secondary me-2">Clear</a>
                                <button type="button" class="btn btn-primary"
                                    onclick="alert('Application in demo version')">
                                    <i class="material-symbols-rounded text-sm me-2">add</i>Add New
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Results -->
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">L/C
                                        Number</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Customer</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Bank</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Issue Date</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Expiry Date</th>
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
                                @forelse($lcs as $lc)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $lc->lc_number }}</h6>
                                                    <p class="text-xs text-secondary mb-0">
                                                        {{ $lc->indent->indent_number ?? 'INDENT#' . rand(1000, 9999) }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-0 text-sm">{{ $lc->indent->customer->name ?? 'N/A' }}</h6>
                                                <p class="text-xs text-secondary mb-0">
                                                    {{ $lc->indent->customer->company ?? '' }}</p>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ $lc->issuing_bank }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ $lc->issue_date ? $lc->issue_date->format('M d, Y') : 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ $lc->expiry_date ? $lc->expiry_date->format('M d, Y') : 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                ${{ number_format($lc->amount, 2) }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            @php
                                                $statuses = ['active', 'expired', 'utilized', 'cancelled'];
                                                $lc->status = $statuses[rand(0, count($statuses) - 1)];
                                            @endphp
                                            @if ($lc->status === 'active')
                                                <span class="badge badge-sm bg-gradient-success">Active</span>
                                            @elseif($lc->status === 'expired')
                                                <span class="badge badge-sm bg-gradient-danger">Expired</span>
                                            @elseif($lc->status === 'utilized')
                                                <span class="badge badge-sm bg-gradient-primary">Utilized</span>
                                            @elseif($lc->status === 'cancelled')
                                                <span class="badge badge-sm bg-gradient-secondary">Cancelled</span>
                                            @else
                                                <span
                                                    class="badge badge-sm bg-gradient-secondary">{{ $lc->status ? ucfirst($lc->status) : 'N/A' }}</span>
                                            @endif
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('lcs.show', $lc) }}"
                                                    class="btn btn-link text-dark px-2 mb-0" title="View Details">
                                                    <i class="material-symbols-rounded text-sm">visibility</i>
                                                </a>
                                                @if ($lc->status === 'active')
                                                    <a href="{{ route('lcs.goToShipment', $lc) }}"
                                                        class="btn btn-link text-warning px-2 mb-0" title="Create Shipment">
                                                        <i class="material-symbols-rounded text-sm">local_shipping</i>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <p class="text-secondary">No letters of credit found matching your criteria.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center py-3">
                        {{ $lcs->links() }}
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
                                <li>Search by L/C number, issuing bank, or customer name</li>
                                <li>Filter by status and date range</li>
                                <li>View L/C details and related information</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <p class="text-sm mb-2"><strong>Workflow Navigation:</strong></p>
                            <ul class="text-sm text-secondary">
                                <li>Click "View" to see L/C details</li>
                                <li>Click "Create Shipment" (truck icon) to continue workflow</li>
                                <li>Only active L/Cs can create shipments</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
