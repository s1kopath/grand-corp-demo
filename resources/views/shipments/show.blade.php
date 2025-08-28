@extends('layouts.app')

@section('title', 'Shipment ' . $shipment->shipment_number)

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <div class="row">
                            <div class="col-6">
                                <h6 class="text-white text-capitalize ps-3">Shipment Details</h6>
                            </div>
                            <div class="col-6 text-end">
                                <a href="{{ route('shipments.index') }}" class="btn btn-sm btn-outline-light me-3">
                                    <i class="material-symbols-rounded text-sm me-1">arrow_back</i>Back to List
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Shipment Information -->
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="mb-3">Shipment Information</h6>
                            <div class="row">
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Shipment Number:</strong></p>
                                    <p class="text-sm text-secondary mb-3">{{ $shipment->shipment_number }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Status:</strong></p>
                                    <p class="text-sm mb-3">
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
                                    </p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Vessel Name:</strong></p>
                                    <p class="text-sm text-secondary mb-3">{{ $shipment->vessel_name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Container Number:</strong></p>
                                    <p class="text-sm text-secondary mb-3">{{ $shipment->container_number ?? 'N/A' }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>ETD (Port):</strong></p>
                                    <p class="text-sm text-secondary mb-3">
                                        {{ $shipment->etd ? $shipment->etd->format('M d, Y') : 'N/A' }}
                                        @if ($shipment->port_of_loading)
                                            <br><small class="text-muted">{{ $shipment->port_of_loading }}</small>
                                        @endif
                                    </p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>ETA (Port):</strong></p>
                                    <p class="text-sm text-secondary mb-3">
                                        {{ $shipment->eta ? $shipment->eta->format('M d, Y') : 'N/A' }}
                                        @if ($shipment->port_of_discharge)
                                            <br><small class="text-muted">{{ $shipment->port_of_discharge }}</small>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="mb-3">Related Information</h6>
                            <div class="row">
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>L/C Number:</strong></p>
                                    <p class="text-sm text-secondary mb-3">
                                        {{ $shipment->letterOfCredit->lc_number ?? 'N/A' }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Indent Number:</strong></p>
                                    <p class="text-sm text-secondary mb-3">
                                        {{ $shipment->letterOfCredit->indent->indent_number ?? 'N/A' }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Customer:</strong></p>
                                    <p class="text-sm text-secondary mb-3">
                                        {{ $shipment->letterOfCredit->indent->customer->name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Company:</strong></p>
                                    <p class="text-sm text-secondary mb-3">
                                        {{ $shipment->letterOfCredit->indent->customer->company ?? 'N/A' }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Shipping Line:</strong></p>
                                    <p class="text-sm text-secondary mb-3">{{ $shipment->shipping_line ?? 'N/A' }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Bill of Lading:</strong></p>
                                    <p class="text-sm text-secondary mb-3">{{ $shipment->bill_of_lading_number ?? 'N/A' }}
                                    </p>
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
                                        <h4 class="text-white mb-0">{{ $shipment->container_count ?? 0 }}</h4>
                                        <p class="text-white text-sm mb-0">Containers</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-gradient-success">
                                <div class="card-body p-3">
                                    <div class="text-center">
                                        <h4 class="text-white mb-0">{{ $shipment->documents->count() }}</h4>
                                        <p class="text-white text-sm mb-0">Documents</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-gradient-warning">
                                <div class="card-body p-3">
                                    <div class="text-center">
                                        <h4 class="text-white mb-0">{{ $shipment->certificates->count() }}</h4>
                                        <p class="text-white text-sm mb-0">Certificates</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-gradient-primary">
                                <div class="card-body p-3">
                                    <div class="text-center">
                                        <h4 class="text-white mb-0">{{ $shipment->weight ?? 0 }} MT</h4>
                                        <p class="text-white text-sm mb-0">Total Weight</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Container Details -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="mb-3">Container Details</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-6">
                                                    <p class="text-sm mb-1"><strong>Container Type:</strong></p>
                                                    <p class="text-sm text-secondary mb-3">
                                                        {{ $shipment->container_type ?? 'N/A' }}</p>
                                                </div>
                                                <div class="col-6">
                                                    <p class="text-sm mb-1"><strong>Container Size:</strong></p>
                                                    <p class="text-sm text-secondary mb-3">
                                                        {{ $shipment->container_size ?? 'N/A' }}</p>
                                                </div>
                                                <div class="col-6">
                                                    <p class="text-sm mb-1"><strong>Gross Weight:</strong></p>
                                                    <p class="text-sm text-secondary mb-3">
                                                        {{ $shipment->gross_weight ?? 0 }} MT</p>
                                                </div>
                                                <div class="col-6">
                                                    <p class="text-sm mb-1"><strong>Net Weight:</strong></p>
                                                    <p class="text-sm text-secondary mb-3">
                                                        {{ $shipment->net_weight ?? 0 }} MT</p>
                                                </div>
                                                <div class="col-6">
                                                    <p class="text-sm mb-1"><strong>Volume:</strong></p>
                                                    <p class="text-sm text-secondary mb-3">{{ $shipment->volume ?? 0 }}
                                                        CBM</p>
                                                </div>
                                                <div class="col-6">
                                                    <p class="text-sm mb-1"><strong>Seal Number:</strong></p>
                                                    <p class="text-sm text-secondary mb-3">
                                                        {{ $shipment->seal_number ?? 'N/A' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-6">
                                                    <p class="text-sm mb-1"><strong>Freight Charges:</strong></p>
                                                    <p class="text-sm text-secondary mb-3">
                                                        ${{ number_format($shipment->freight_charges ?? 0, 2) }}</p>
                                                </div>
                                                <div class="col-6">
                                                    <p class="text-sm mb-1"><strong>Insurance:</strong></p>
                                                    <p class="text-sm text-secondary mb-3">
                                                        ${{ number_format($shipment->insurance_amount ?? 0, 2) }}</p>
                                                </div>
                                                <div class="col-6">
                                                    <p class="text-sm mb-1"><strong>Handling Charges:</strong></p>
                                                    <p class="text-sm text-secondary mb-3">
                                                        ${{ number_format($shipment->handling_charges ?? 0, 2) }}</p>
                                                </div>
                                                <div class="col-6">
                                                    <p class="text-sm mb-1"><strong>Total Charges:</strong></p>
                                                    <p class="text-sm text-secondary mb-3">
                                                        ${{ number_format(($shipment->freight_charges ?? 0) + ($shipment->insurance_amount ?? 0) + ($shipment->handling_charges ?? 0), 2) }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shipment Documents -->
                    @if ($shipment->documents->count() > 0)
                        <div class="row mt-4">
                            <div class="col-12">
                                <h6 class="mb-3">Shipment Documents</h6>
                                <div class="table-responsive">
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Document</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Type</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Date</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Status</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($shipment->documents as $document)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex px-2 py-1">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">{{ $document->document_name }}
                                                                </h6>
                                                                <p class="text-xs text-secondary mb-0">
                                                                    {{ $document->document_number ?? '' }}</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0">
                                                            {{ $document->document_type }}</p>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <span class="text-secondary text-xs font-weight-bold">
                                                            {{ $document->issue_date ? $document->issue_date->format('M d, Y') : 'N/A' }}
                                                        </span>
                                                    </td>
                                                    <td class="align-middle text-center text-sm">
                                                        @if ($document->status === 'received')
                                                            <span
                                                                class="badge badge-sm bg-gradient-success">Received</span>
                                                        @elseif($document->status === 'pending')
                                                            <span class="badge badge-sm bg-gradient-warning">Pending</span>
                                                        @else
                                                            <span
                                                                class="badge badge-sm bg-gradient-secondary">{{ ucfirst($document->status) }}</span>
                                                        @endif
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <span class="text-secondary text-xs">View</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Certificates -->
                    @if ($shipment->certificates->count() > 0)
                        <div class="row mt-4">
                            <div class="col-12">
                                <h6 class="mb-3">Certificates</h6>
                                <div class="table-responsive">
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Certificate</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Type</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Issue Date</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Expiry Date</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Status</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($shipment->certificates as $certificate)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex px-2 py-1">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">
                                                                    {{ $certificate->certificate_name }}</h6>
                                                                <p class="text-xs text-secondary mb-0">
                                                                    {{ $certificate->certificate_number ?? '' }}</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0">
                                                            {{ $certificate->certificate_type }}</p>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <span class="text-secondary text-xs font-weight-bold">
                                                            {{ $certificate->issue_date ? $certificate->issue_date->format('M d, Y') : 'N/A' }}
                                                        </span>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <span class="text-secondary text-xs font-weight-bold">
                                                            {{ $certificate->expiry_date ? $certificate->expiry_date->format('M d, Y') : 'N/A' }}
                                                        </span>
                                                    </td>
                                                    <td class="align-middle text-center text-sm">
                                                        @if ($certificate->status === 'valid')
                                                            <span class="badge badge-sm bg-gradient-success">Valid</span>
                                                        @elseif($certificate->status === 'expired')
                                                            <span class="badge badge-sm bg-gradient-danger">Expired</span>
                                                        @else
                                                            <span
                                                                class="badge badge-sm bg-gradient-secondary">{{ ucfirst($certificate->status) }}</span>
                                                        @endif
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <span class="text-secondary text-xs">View</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Workflow Status -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="mb-3">Logistics Workflow Status</h6>
                            <div class="timeline timeline-one-side">
                                <div class="timeline-block mb-3">
                                    <span class="timeline-step">
                                        <i class="material-symbols-rounded text-success text-gradient">check_circle</i>
                                    </span>
                                    <div class="timeline-content">
                                        <h6 class="text-dark text-sm font-weight-bold mb-0">L/C Issued</h6>
                                        <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                            {{ $shipment->letterOfCredit->issue_date->format('M d, Y') ?? 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="timeline-block mb-3">
                                    <span class="timeline-step">
                                        @if ($shipment->status === 'pending')
                                            <i class="material-symbols-rounded text-warning text-gradient">pending</i>
                                        @else
                                            <i class="material-symbols-rounded text-success text-gradient">check_circle</i>
                                        @endif
                                    </span>
                                    <div class="timeline-content">
                                        <h6 class="text-dark text-sm font-weight-bold mb-0">Shipment Created</h6>
                                        <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                            {{ $shipment->created_at->format('M d, Y') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="timeline-block mb-3">
                                    <span class="timeline-step">
                                        @if ($shipment->status === 'in_transit')
                                            <i class="material-symbols-rounded text-info text-gradient">local_shipping</i>
                                        @elseif($shipment->status === 'delivered')
                                            <i class="material-symbols-rounded text-success text-gradient">check_circle</i>
                                        @else
                                            <i class="material-symbols-rounded text-warning text-gradient">pending</i>
                                        @endif
                                    </span>
                                    <div class="timeline-content">
                                        <h6 class="text-dark text-sm font-weight-bold mb-0">Vessel Departure</h6>
                                        <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                            {{ $shipment->etd ? $shipment->etd->format('M d, Y') : 'Pending' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="timeline-block mb-3">
                                    <span class="timeline-step">
                                        @if ($shipment->status === 'delivered')
                                            <i class="material-symbols-rounded text-success text-gradient">check_circle</i>
                                        @else
                                            <i class="material-symbols-rounded text-warning text-gradient">pending</i>
                                        @endif
                                    </span>
                                    <div class="timeline-content">
                                        <h6 class="text-dark text-sm font-weight-bold mb-0">Vessel Arrival</h6>
                                        <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                            {{ $shipment->eta ? $shipment->eta->format('M d, Y') : 'Pending' }}
                                        </p>
                                    </div>
                                </div>
                                @if ($shipment->status === 'delivered')
                                    <div class="timeline-block mb-3">
                                        <span class="timeline-step">
                                            <i class="material-symbols-rounded text-success text-gradient">check_circle</i>
                                        </span>
                                        <div class="timeline-content">
                                            <h6 class="text-dark text-sm font-weight-bold mb-0">Delivery Completed</h6>
                                            <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                                Cargo delivered to customer
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
