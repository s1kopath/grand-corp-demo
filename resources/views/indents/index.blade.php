@extends('layouts.app')

@section('title', 'Indents')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Indents</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <!-- Search and Filters -->
                    <div class="p-3">
                        <form method="GET" action="{{ route('indents.index') }}" class="row g-3">
                            <div class="col-md-3">
                                <div class="input-group input-group-outline">
                                    <label class="form-label">Search Indents</label>
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
                                        <option value="lc_issued" {{ request('status') == 'lc_issued' ? 'selected' : '' }}>
                                            L/C Issued</option>
                                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                                            Completed</option>
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
                                <a href="{{ route('indents.index') }}" class="btn btn-secondary me-2">Clear</a>
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Indent
                                    </th>
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
                                @forelse($indents as $indent)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $indent->indent_number }}</h6>
                                                    <p class="text-xs text-secondary mb-0">Delivery:
                                                        {{ $indent->updated_at ? $indent->updated_at->format('M d, Y') : 'N/A' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-0 text-sm">{{ $indent->customer->name }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $indent->customer->company }}</p>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ $indent->created_at ? $indent->created_at->format('M d, Y') : 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            @if ($indent->status === 'pending')
                                                <span class="badge badge-sm bg-gradient-warning">Pending</span>
                                            @elseif($indent->status === 'approved')
                                                <span class="badge badge-sm bg-gradient-success">Approved</span>
                                            @elseif($indent->status === 'lc_issued')
                                                <span class="badge badge-sm bg-gradient-info">L/C Issued</span>
                                            @elseif($indent->status === 'completed')
                                                <span class="badge badge-sm bg-gradient-primary">Completed</span>
                                            @elseif($indent->status === 'cancelled')
                                                <span class="badge badge-sm bg-gradient-danger">Cancelled</span>
                                            @else
                                                <span
                                                    class="badge badge-sm bg-gradient-secondary">{{ ucfirst($indent->status) }}</span>
                                            @endif
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ $indent->items->count() }} items
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                ${{ number_format($indent->total_amount, 2) }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('indents.show', $indent) }}"
                                                    class="btn btn-link text-dark px-2 mb-0" title="View Details">
                                                    <i class="material-symbols-rounded text-sm">visibility</i>
                                                </a>
                                                @if ($indent->status === 'approved')
                                                    <a href="{{ route('indents.goToLc', $indent) }}"
                                                        class="btn btn-link text-info px-2 mb-0" title="Issue L/C">
                                                        <i class="material-symbols-rounded text-sm">account_balance</i>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <p class="text-secondary">No indents found matching your criteria.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center py-3">
                        {{ $indents->links() }}
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
                                <li>Search by indent number or customer name</li>
                                <li>Filter by status and date range</li>
                                <li>View indent details and items</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <p class="text-sm mb-2"><strong>Workflow Navigation:</strong></p>
                            <ul class="text-sm text-secondary">
                                <li>Click "View" to see indent details</li>
                                <li>Click "Issue L/C" (bank icon) to continue workflow</li>
                                <li>Only approved indents can issue L/Cs</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
