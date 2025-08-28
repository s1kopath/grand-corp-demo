@extends('layouts.app')

@section('title', 'Quotations')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Quotations</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <!-- Search and Filters -->
                    <div class="p-3">
                        <form method="GET" action="{{ route('quotations.index') }}" class="row g-3">
                            <div class="col-md-3">
                                <div class="input-group input-group-outline">
                                    <label class="form-label">Search Quotations</label>
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
                                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>
                                            Rejected</option>
                                        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>
                                            Expired</option>
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
                                <a href="{{ route('quotations.index') }}" class="btn btn-secondary">Clear</a>
                            </div>
                        </form>
                    </div>

                    <!-- Results -->
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Quotation</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Customer</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Date</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Items</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Total Amount</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($quotations as $quotation)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $quotation->quotation_number }}</h6>
                                                    <p class="text-xs text-secondary mb-0">Valid until:
                                                        {{ $quotation->valid_until ? $quotation->valid_until->format('M d, Y') : '-' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-0 text-sm">{{ $quotation->customer->name }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $quotation->customer->company }}
                                                </p>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ $quotation->quotation_date ? $quotation->quotation_date->format('M d, Y') : '-' }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            @if ($quotation->status === 'pending')
                                                <span class="badge badge-sm bg-gradient-warning">Pending</span>
                                            @elseif($quotation->status === 'approved')
                                                <span class="badge badge-sm bg-gradient-success">Approved</span>
                                            @elseif($quotation->status === 'rejected')
                                                <span class="badge badge-sm bg-gradient-danger">Rejected</span>
                                            @elseif($quotation->status === 'expired')
                                                <span class="badge badge-sm bg-gradient-secondary">Expired</span>
                                            @else
                                                <span
                                                    class="badge badge-sm bg-gradient-secondary">{{ ucfirst($quotation->status) }}</span>
                                            @endif
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ $quotation->items->count() }} items
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                ${{ number_format($quotation->total_amount, 2) }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('quotations.show', $quotation) }}"
                                                    class="btn btn-link text-dark px-2 mb-0" title="View Details">
                                                    <i class="material-symbols-rounded text-sm">visibility</i>
                                                </a>
                                                @if ($quotation->status === 'approved')
                                                    <a href="{{ route('quotations.goToIndent', $quotation) }}"
                                                        class="btn btn-link text-success px-2 mb-0" title="Create Indent">
                                                        <i class="material-symbols-rounded text-sm">shopping_cart</i>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <p class="text-secondary">No quotations found matching your criteria.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center py-3">
                        {{ $quotations->links() }}
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
                                <li>Search by quotation number or customer name</li>
                                <li>Filter by status and date range</li>
                                <li>View quotation details and items</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <p class="text-sm mb-2"><strong>Workflow Navigation:</strong></p>
                            <ul class="text-sm text-secondary">
                                <li>Click "View" to see quotation details</li>
                                <li>Click "Create Indent" (shopping cart icon) to continue workflow</li>
                                <li>Only approved quotations can create indents</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
