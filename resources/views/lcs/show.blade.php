@extends('layouts.app')

@section('title', 'L/C ' . $lc->lc_number)

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <div class="row">
                            <div class="col-6">
                                <h6 class="text-white text-capitalize ps-3">Letter of Credit Details</h6>
                            </div>
                            <div class="col-6 text-end">
                                <a href="{{ route('lcs.index') }}" class="btn btn-sm btn-outline-light me-3">
                                    <i class="material-symbols-rounded text-sm me-1">arrow_back</i>Back to List
                                </a>
                                @if ($lc->status === 'active')
                                    <a href="{{ route('lcs.goToShipment', $lc) }}" class="btn btn-sm btn-warning me-3">
                                        <i class="material-symbols-rounded text-sm me-1">local_shipping</i>Create Shipment
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- L/C Information -->
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="mb-3">L/C Information</h6>
                            <div class="row">
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>L/C Number:</strong></p>
                                    <p class="text-sm text-secondary mb-3">{{ $lc->lc_number }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Status:</strong></p>
                                    <p class="text-sm mb-3">
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
                                                class="badge badge-sm bg-gradient-secondary">{{ ucfirst($lc->status) }}</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Issue Date:</strong></p>
                                    <p class="text-sm text-secondary mb-3">{{ $lc->issue_date->format('M d, Y') }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Expiry Date:</strong></p>
                                    <p class="text-sm text-secondary mb-3">{{ $lc->expiry_date->format('M d, Y') }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Issuing Bank:</strong></p>
                                    <p class="text-sm text-secondary mb-3">{{ $lc->issuing_bank }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Advising Bank:</strong></p>
                                    <p class="text-sm text-secondary mb-3">{{ $lc->advising_bank ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="mb-3">Financial Information</h6>
                            <div class="row">
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Amount:</strong></p>
                                    <p class="text-sm text-secondary mb-3">${{ number_format($lc->amount, 2) }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Currency:</strong></p>
                                    <p class="text-sm text-secondary mb-3">{{ $lc->currency ?? 'USD' }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Utilized Amount:</strong></p>
                                    <p class="text-sm text-secondary mb-3">
                                        ${{ number_format($lc->utilized_amount ?? 0, 2) }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Available Amount:</strong></p>
                                    <p class="text-sm text-secondary mb-3">
                                        ${{ number_format($lc->amount - ($lc->utilized_amount ?? 0), 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Related Indent Information -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="mb-3">Related Indent Information</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="text-sm mb-1"><strong>Indent Number:</strong></p>
                                            <p class="text-sm text-secondary mb-3">
                                                {{ $lc->indent->indent_number ?? 'N/A' }}</p>
                                        </div>
                                        <div class="col-6">
                                            <p class="text-sm mb-1"><strong>Indent Date:</strong></p>
                                            <p class="text-sm text-secondary mb-3">
                                                {{ $lc->indent->indent_date->format('M d, Y') ?? 'N/A' }}</p>
                                        </div>
                                        <div class="col-6">
                                            <p class="text-sm mb-1"><strong>Customer:</strong></p>
                                            <p class="text-sm text-secondary mb-3">
                                                {{ $lc->indent->customer->name ?? 'N/A' }}</p>
                                        </div>
                                        <div class="col-6">
                                            <p class="text-sm mb-1"><strong>Company:</strong></p>
                                            <p class="text-sm text-secondary mb-3">
                                                {{ $lc->indent->customer->company ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="text-sm mb-1"><strong>Indent Amount:</strong></p>
                                            <p class="text-sm text-secondary mb-3">
                                                ${{ number_format($lc->indent->total_amount ?? 0, 2) }}</p>
                                        </div>
                                        <div class="col-6">
                                            <p class="text-sm mb-1"><strong>Items Count:</strong></p>
                                            <p class="text-sm text-secondary mb-3">{{ $lc->indent->items->count() ?? 0 }}
                                                items</p>
                                        </div>
                                        <div class="col-6">
                                            <p class="text-sm mb-1"><strong>Delivery Date:</strong></p>
                                            <p class="text-sm text-secondary mb-3">
                                                {{ $lc->indent->delivery_date->format('M d, Y') ?? 'N/A' }}</p>
                                        </div>
                                        <div class="col-6">
                                            <p class="text-sm mb-1"><strong>Indent Status:</strong></p>
                                            <p class="text-sm mb-3">
                                                @if ($lc->indent->status === 'approved')
                                                    <span class="badge badge-sm bg-gradient-success">Approved</span>
                                                @elseif($lc->indent->status === 'lc_issued')
                                                    <span class="badge badge-sm bg-gradient-info">L/C Issued</span>
                                                @else
                                                    <span
                                                        class="badge badge-sm bg-gradient-secondary">{{ ucfirst($lc->indent->status ?? 'N/A') }}</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Summary Cards -->
                    <div class="row mt-4">
                        <div class="col-md-3">
                            <div class="card bg-gradient-info">
                                <div class="card-body p-3">
                                    <div class="text-center">
                                        <h4 class="text-white mb-0">${{ number_format($lc->amount, 2) }}</h4>
                                        <p class="text-white text-sm mb-0">Total Amount</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-gradient-success">
                                <div class="card-body p-3">
                                    <div class="text-center">
                                        <h4 class="text-white mb-0">${{ number_format($lc->utilized_amount ?? 0, 2) }}
                                        </h4>
                                        <p class="text-white text-sm mb-0">Utilized</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-gradient-warning">
                                <div class="card-body p-3">
                                    <div class="text-center">
                                        <h4 class="text-white mb-0">
                                            ${{ number_format($lc->amount - ($lc->utilized_amount ?? 0), 2) }}</h4>
                                        <p class="text-white text-sm mb-0">Available</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-gradient-primary">
                                <div class="card-body p-3">
                                    <div class="text-center">
                                        <h4 class="text-white mb-0">{{ $lc->shipments->count() }}</h4>
                                        <p class="text-white text-sm mb-0">Shipments</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Related Shipments -->
                    @if ($lc->shipments->count() > 0)
                        <div class="row mt-4">
                            <div class="col-12">
                                <h6 class="mb-3">Related Shipments</h6>
                                <div class="table-responsive">
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Shipment</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
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
                                                    Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($lc->shipments as $shipment)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex px-2 py-1">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">{{ $shipment->shipment_number }}
                                                                </h6>
                                                                <p class="text-xs text-secondary mb-0">
                                                                    {{ $shipment->container_count ?? 0 }} containers</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0">
                                                            {{ $shipment->vessel_name ?? 'N/A' }}</p>
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
                                                            <span
                                                                class="badge badge-sm bg-gradient-success">Delivered</span>
                                                        @else
                                                            <span
                                                                class="badge badge-sm bg-gradient-secondary">{{ ucfirst($shipment->status) }}</span>
                                                        @endif
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <a href="{{ route('shipments.show', $shipment) }}"
                                                            class="btn btn-link text-dark px-3 mb-0"
                                                            title="View Shipment">
                                                            <i
                                                                class="material-symbols-rounded text-sm me-2">visibility</i>View
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- L/C Terms -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="mb-3">L/C Terms & Conditions</h6>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="text-sm mb-1"><strong>Payment Terms:</strong></p>
                                            <p class="text-sm text-secondary mb-3">{{ $lc->payment_terms ?? 'At sight' }}
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="text-sm mb-1"><strong>Documents Required:</strong></p>
                                            <p class="text-sm text-secondary mb-3">
                                                {{ $lc->documents_required ?? 'Commercial Invoice, Packing List, Bill of Lading, Certificate of Origin' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <p class="text-sm mb-1"><strong>Special Conditions:</strong></p>
                                            <p class="text-sm text-secondary mb-0">
                                                {{ $lc->special_conditions ?? 'Standard L/C terms apply. All documents must be presented within 21 days after shipment date.' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Workflow Status -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="mb-3">Workflow Status</h6>
                            <div class="timeline timeline-one-side">
                                <div class="timeline-block mb-3">
                                    <span class="timeline-step">
                                        <i class="material-symbols-rounded text-success text-gradient">check_circle</i>
                                    </span>
                                    <div class="timeline-content">
                                        <h6 class="text-dark text-sm font-weight-bold mb-0">Quotation Approved</h6>
                                        <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                            Customer approved the quotation
                                        </p>
                                    </div>
                                </div>
                                <div class="timeline-block mb-3">
                                    <span class="timeline-step">
                                        <i class="material-symbols-rounded text-success text-gradient">check_circle</i>
                                    </span>
                                    <div class="timeline-content">
                                        <h6 class="text-dark text-sm font-weight-bold mb-0">Indent Created</h6>
                                        <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                            {{ $lc->indent->indent_date->format('M d, Y') ?? 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="timeline-block mb-3">
                                    <span class="timeline-step">
                                        <i class="material-symbols-rounded text-success text-gradient">check_circle</i>
                                    </span>
                                    <div class="timeline-content">
                                        <h6 class="text-dark text-sm font-weight-bold mb-0">Indent Approved</h6>
                                        <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                            Indent approved and ready for L/C
                                        </p>
                                    </div>
                                </div>
                                <div class="timeline-block mb-3">
                                    <span class="timeline-step">
                                        @if ($lc->status === 'active')
                                            <i class="material-symbols-rounded text-success text-gradient">check_circle</i>
                                        @elseif($lc->status === 'expired')
                                            <i class="material-symbols-rounded text-danger text-gradient">cancel</i>
                                        @elseif($lc->status === 'utilized')
                                            <i class="material-symbols-rounded text-primary text-gradient">done_all</i>
                                        @else
                                            <i class="material-symbols-rounded text-warning text-gradient">pending</i>
                                        @endif
                                    </span>
                                    <div class="timeline-content">
                                        <h6 class="text-dark text-sm font-weight-bold mb-0">L/C Issued</h6>
                                        <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                            {{ $lc->issue_date->format('M d, Y') }} - {{ ucfirst($lc->status) }}
                                        </p>
                                    </div>
                                </div>
                                @if ($lc->status === 'active')
                                    <div class="timeline-block mb-3">
                                        <span class="timeline-step">
                                            <i
                                                class="material-symbols-rounded text-warning text-gradient">local_shipping</i>
                                        </span>
                                        <div class="timeline-content">
                                            <h6 class="text-dark text-sm font-weight-bold mb-0">Create Shipment</h6>
                                            <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                                Click "Create Shipment" to continue workflow
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
