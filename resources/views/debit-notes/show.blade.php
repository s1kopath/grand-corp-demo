@extends('layouts.app')

@section('title', 'Debit Note ' . $debitNote->debit_note_number)

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <div class="row">
                            <div class="col-6">
                                <h6 class="text-white text-capitalize ps-3">Debit Note Details</h6>
                            </div>
                            <div class="col-6 text-end">
                                <a href="{{ route('debit-notes.index') }}" class="btn btn-sm btn-outline-light me-3">
                                    <i class="material-symbols-rounded text-sm me-1">arrow_back</i>Back to List
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Debit Note Information -->
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="mb-3">Debit Note Information</h6>
                            <div class="row">
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Debit Note Number:</strong></p>
                                    <p class="text-sm text-secondary mb-3">{{ $debitNote->debit_note_number }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Status:</strong></p>
                                    <p class="text-sm mb-3">
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
                                    </p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Issue Date:</strong></p>
                                    <p class="text-sm text-secondary mb-3">
                                        {{ $debitNote->issue_date ? $debitNote->issue_date->format('M d, Y') : 'N/A' }}
                                    </p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Due Date:</strong></p>
                                    <p class="text-sm text-secondary mb-3">
                                        {{ $debitNote->due_date ? $debitNote->due_date->format('M d, Y') : 'N/A' }}
                                    </p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Reference Number:</strong></p>
                                    <p class="text-sm text-secondary mb-3">{{ $debitNote->reference_number ?? 'N/A' }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Currency:</strong></p>
                                    <p class="text-sm text-secondary mb-3">{{ $debitNote->currency ?? 'USD' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="mb-3">Customer Information</h6>
                            <div class="row">
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Customer:</strong></p>
                                    <p class="text-sm text-secondary mb-3">{{ $debitNote->customer->name }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Company:</strong></p>
                                    <p class="text-sm text-secondary mb-3">{{ $debitNote->customer->company }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Email:</strong></p>
                                    <p class="text-sm text-secondary mb-3">{{ $debitNote->customer->email }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Phone:</strong></p>
                                    <p class="text-sm text-secondary mb-3">{{ $debitNote->customer->phone }}</p>
                                </div>
                                <div class="col-12">
                                    <p class="text-sm mb-1"><strong>Address:</strong></p>
                                    <p class="text-sm text-secondary mb-3">{{ $debitNote->customer->address }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Related Shipment Information -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="mb-3">Related Shipment Information</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="text-sm mb-1"><strong>Shipment Number:</strong></p>
                                            <p class="text-sm text-secondary mb-3">
                                                {{ $debitNote->shipment->shipment_number ?? 'N/A' }}</p>
                                        </div>
                                        <div class="col-6">
                                            <p class="text-sm mb-1"><strong>Vessel Name:</strong></p>
                                            <p class="text-sm text-secondary mb-3">
                                                {{ $debitNote->shipment->vessel_name ?? 'N/A' }}</p>
                                        </div>
                                        <div class="col-6">
                                            <p class="text-sm mb-1"><strong>L/C Number:</strong></p>
                                            <p class="text-sm text-secondary mb-3">
                                                {{ $debitNote->shipment->letterOfCredit->lc_number ?? 'N/A' }}</p>
                                        </div>
                                        <div class="col-6">
                                            <p class="text-sm mb-1"><strong>Indent Number:</strong></p>
                                            <p class="text-sm text-secondary mb-3">
                                                {{ $debitNote->shipment->letterOfCredit->indent->indent_number ?? 'N/A' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="text-sm mb-1"><strong>ETD:</strong></p>
                                            <p class="text-sm text-secondary mb-3">
                                                {{ $debitNote->shipment->etd ? $debitNote->shipment->etd->format('M d, Y') : 'N/A' }}
                                            </p>
                                        </div>
                                        <div class="col-6">
                                            <p class="text-sm mb-1"><strong>ETA:</strong></p>
                                            <p class="text-sm text-secondary mb-3">
                                                {{ $debitNote->shipment->eta ? $debitNote->shipment->eta->format('M d, Y') : 'N/A' }}
                                            </p>
                                        </div>
                                        <div class="col-6">
                                            <p class="text-sm mb-1"><strong>Container Count:</strong></p>
                                            <p class="text-sm text-secondary mb-3">
                                                {{ $debitNote->shipment->container_count ?? 0 }}</p>
                                        </div>
                                        <div class="col-6">
                                            <p class="text-sm mb-1"><strong>Shipment Status:</strong></p>
                                            <p class="text-sm mb-3">
                                                @if ($debitNote->shipment->status === 'pending')
                                                    <span class="badge badge-sm bg-gradient-warning">Pending</span>
                                                @elseif($debitNote->shipment->status === 'in_transit')
                                                    <span class="badge badge-sm bg-gradient-info">In Transit</span>
                                                @elseif($debitNote->shipment->status === 'delivered')
                                                    <span class="badge badge-sm bg-gradient-success">Delivered</span>
                                                @else
                                                    <span
                                                        class="badge badge-sm bg-gradient-secondary">{{ ucfirst($debitNote->shipment->status ?? 'N/A') }}</span>
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
                                        <h4 class="text-white mb-0">${{ number_format($debitNote->subtotal, 2) }}</h4>
                                        <p class="text-white text-sm mb-0">Subtotal</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-gradient-warning">
                                <div class="card-body p-3">
                                    <div class="text-center">
                                        <h4 class="text-white mb-0">${{ number_format($debitNote->tax_amount, 2) }}</h4>
                                        <p class="text-white text-sm mb-0">Tax</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-gradient-success">
                                <div class="card-body p-3">
                                    <div class="text-center">
                                        <h4 class="text-white mb-0">${{ number_format($debitNote->total_amount, 2) }}</h4>
                                        <p class="text-white text-sm mb-0">Total Amount</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-gradient-primary">
                                <div class="card-body p-3">
                                    <div class="text-center">
                                        <h4 class="text-white mb-0">{{ $debitNote->accountEntries->count() }}</h4>
                                        <p class="text-white text-sm mb-0">Account Entries</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Charges Breakdown -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="mb-3">Charges Breakdown</h6>
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Description</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Quantity</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Unit Price</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Amount</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($debitNote->charges ?? [] as $charge)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{ $charge['description'] ?? 'N/A' }}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">
                                                        {{ $charge['quantity'] ?? 1 }}
                                                    </span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">
                                                        ${{ number_format($charge['unit_price'] ?? 0, 2) }}
                                                    </span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">
                                                        ${{ number_format($charge['amount'] ?? 0, 2) }}
                                                    </span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">
                                                        {{ Str::limit($charge['remarks'] ?? '', 30) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-4">
                                                    <p class="text-secondary">No charges found for this debit note.</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-end"><strong>Subtotal:</strong></td>
                                            <td class="text-center">
                                                <strong>${{ number_format($debitNote->subtotal, 2) }}</strong>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-end"><strong>Tax
                                                    ({{ $debitNote->tax_rate ?? 0 }}%):</strong></td>
                                            <td class="text-center">
                                                <strong>${{ number_format($debitNote->tax_amount, 2) }}</strong>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                            <td class="text-center">
                                                <strong>${{ number_format($debitNote->total_amount, 2) }}</strong>
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Account Entries -->
                    @if ($debitNote->accountEntries->count() > 0)
                        <div class="row mt-4">
                            <div class="col-12">
                                <h6 class="mb-3">Account Entries</h6>
                                <div class="table-responsive">
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Entry Date</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Account</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Type</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Amount</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Description</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($debitNote->accountEntries as $entry)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex px-2 py-1">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">
                                                                    {{ $entry->entry_date ? $entry->entry_date->format('M d, Y') : 'N/A' }}
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0">
                                                            {{ $entry->account_name }}</p>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <span class="text-secondary text-xs font-weight-bold">
                                                            {{ ucfirst($entry->entry_type) }}
                                                        </span>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <span class="text-secondary text-xs font-weight-bold">
                                                            ${{ number_format($entry->amount, 2) }}
                                                        </span>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <span class="text-secondary text-xs font-weight-bold">
                                                            {{ Str::limit($entry->description, 40) }}
                                                        </span>
                                                    </td>
                                                    <td class="align-middle text-center text-sm">
                                                        @if ($entry->status === 'posted')
                                                            <span class="badge badge-sm bg-gradient-success">Posted</span>
                                                        @elseif($entry->status === 'pending')
                                                            <span class="badge badge-sm bg-gradient-warning">Pending</span>
                                                        @else
                                                            <span
                                                                class="badge badge-sm bg-gradient-secondary">{{ ucfirst($entry->status) }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Payment Terms -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="mb-3">Payment Terms & Conditions</h6>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="text-sm mb-1"><strong>Payment Terms:</strong></p>
                                            <p class="text-sm text-secondary mb-3">
                                                {{ $debitNote->payment_terms ?? 'Net 30 days' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="text-sm mb-1"><strong>Late Payment Fee:</strong></p>
                                            <p class="text-sm text-secondary mb-3">
                                                {{ $debitNote->late_payment_fee ?? '2% per month' }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <p class="text-sm mb-1"><strong>Terms & Conditions:</strong></p>
                                            <p class="text-sm text-secondary mb-0">
                                                {{ $debitNote->terms_conditions ?? 'Standard payment terms apply. Payment is due within the specified period. Late payments may incur additional charges.' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Financial Workflow Status -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="mb-3">Financial Workflow Status</h6>
                            <div class="timeline timeline-one-side">
                                <div class="timeline-block mb-3">
                                    <span class="timeline-step">
                                        <i class="material-symbols-rounded text-success text-gradient">check_circle</i>
                                    </span>
                                    <div class="timeline-content">
                                        <h6 class="text-dark text-sm font-weight-bold mb-0">Shipment Completed</h6>
                                        <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                            Cargo delivered to customer
                                        </p>
                                    </div>
                                </div>
                                <div class="timeline-block mb-3">
                                    <span class="timeline-step">
                                        @if ($debitNote->status === 'pending')
                                            <i class="material-symbols-rounded text-warning text-gradient">pending</i>
                                        @else
                                            <i class="material-symbols-rounded text-success text-gradient">check_circle</i>
                                        @endif
                                    </span>
                                    <div class="timeline-content">
                                        <h6 class="text-dark text-sm font-weight-bold mb-0">Debit Note Created</h6>
                                        <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                            {{ $debitNote->issue_date ? $debitNote->issue_date->format('M d, Y') : 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="timeline-block mb-3">
                                    <span class="timeline-step">
                                        @if ($debitNote->status === 'approved')
                                            <i class="material-symbols-rounded text-success text-gradient">check_circle</i>
                                        @elseif($debitNote->status === 'cancelled')
                                            <i class="material-symbols-rounded text-danger text-gradient">cancel</i>
                                        @else
                                            <i class="material-symbols-rounded text-warning text-gradient">pending</i>
                                        @endif
                                    </span>
                                    <div class="timeline-content">
                                        <h6 class="text-dark text-sm font-weight-bold mb-0">Customer Approval</h6>
                                        <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                            @if ($debitNote->status === 'approved')
                                                Approved - Ready for Payment
                                            @elseif($debitNote->status === 'cancelled')
                                                Cancelled
                                            @else
                                                Pending Customer Approval
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                @if ($debitNote->status === 'paid')
                                    <div class="timeline-block mb-3">
                                        <span class="timeline-step">
                                            <i class="material-symbols-rounded text-success text-gradient">check_circle</i>
                                        </span>
                                        <div class="timeline-content">
                                            <h6 class="text-dark text-sm font-weight-bold mb-0">Payment Received</h6>
                                            <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                                Payment completed and recorded
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
