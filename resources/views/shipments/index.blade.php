@extends('layouts.app')

@section('title', 'Shipments')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Shipments</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <!-- Search and Filters -->
                    <div class="p-3">
                        <form method="GET" action="{{ route('shipments.index') }}" class="row g-3">
                            <div class="col-md-3">
                                <div class="input-group input-group-outline">
                                    <label class="form-label">Search Shipments</label>
                                    <input type="text" class="form-control" name="search"
                                        value="{{ request('search') }}" title="Search by number, vessel, customer...">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group input-group-outline">
                                    <label class="form-label">Status</label>
                                    <select class="form-control" name="status">
                                        <option value="" selected disabled></option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="in_transit"
                                            {{ request('status') == 'in_transit' ? 'selected' : '' }}>In Transit</option>
                                        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>
                                            Delivered</option>
                                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                                            Cancelled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group input-group-outline">
                                    <label class="form-label">From Date</label>
                                    <input type="date" class="form-control" name="date_from"
                                        value="{{ request('date_from') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group input-group-outline">
                                    <label class="form-label">To Date</label>
                                    <input type="date" class="form-control" name="date_to"
                                        value="{{ request('date_to') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary me-2">Search</button>
                                <a href="{{ route('shipments.index') }}" class="btn btn-secondary">Clear</a>
                            </div>
                        </form>
                    </div>

                    <!-- Results -->
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Shipment
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Customer</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Vessel</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        ETD</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        ETA</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Containers</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($shipments as $shipment)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $shipment->shipment_number }}</h6>
                                                    <p class="text-xs text-secondary mb-0">L/C:
                                                        {{ $shipment->letterOfCredit->lc_number ?? 'N/A' }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-0 text-sm">
                                                    {{ $shipment->letterOfCredit->indent->customer->name ?? 'N/A' }}</h6>
                                                <p class="text-xs text-secondary mb-0">
                                                    {{ $shipment->letterOfCredit->indent->customer->company ?? '' }}</p>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ $shipment->vessel_name ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ $shipment->etd ? $shipment->etd->format('M d, Y') : 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ $shipment->eta ? $shipment->eta->format('M d, Y') : 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            @if ($shipment->status === 'pending')
                                                <span class="badge badge-sm bg-gradient-warning">Pending</span>
                                            @elseif($shipment->status === 'in_transit')
                                                <span class="badge badge-sm bg-gradient-info">In Transit</span>
                                            @elseif($shipment->status === 'delivered')
                                                <span class="badge badge-sm bg-gradient-success">Delivered</span>
                                            @elseif($shipment->status === 'cancelled')
                                                <span class="badge badge-sm bg-gradient-danger">Cancelled</span>
                                            @else
                                                <span
                                                    class="badge badge-sm bg-gradient-secondary">{{ ucfirst($shipment->status) }}</span>
                                            @endif
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ $shipment->container_count ?? 0 }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('shipments.show', $shipment) }}"
                                                    class="btn btn-link text-dark px-2 mb-0" title="View Details">
                                                    <i class="material-icons text-sm">visibility</i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <p class="text-secondary">No shipments found matching your criteria.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center py-3">
                        {{ $shipments->links() }}
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
                                <li>Search by shipment number, vessel name, or customer</li>
                                <li>Filter by status and date range</li>
                                <li>View shipment details and tracking information</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <p class="text-sm mb-2"><strong>Logistics Workflow:</strong></p>
                            <ul class="text-sm text-secondary">
                                <li>Click "View" to see shipment details</li>
                                <li>Track vessel movement and container status</li>
                                <li>Monitor ETD/ETA dates and delivery status</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
