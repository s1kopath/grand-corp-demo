@extends('layouts.app')

@section('title', 'Quotation ' . $quotation->quotation_number)

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <div class="row">
                            <div class="col-6">
                                <h6 class="text-white text-capitalize ps-3">Quotation Details</h6>
                            </div>
                            <div class="col-6 text-end">
                                <a href="{{ route('quotations.index') }}" class="btn btn-sm btn-outline-light me-3">
                                    <i class="material-symbols-rounded text-sm me-1">arrow_back</i>Back to List
                                </a>
                                @if ($quotation->status === 'approved')
                                    <a href="{{ route('quotations.goToIndent', $quotation) }}"
                                        class="btn btn-sm btn-success me-3">
                                        <i class="material-symbols-rounded text-sm me-1">shopping_cart</i>Create Indent
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Quotation Information -->
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="mb-3">Basic Information</h6>
                            <div class="row">
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Quotation Number:</strong></p>
                                    <p class="text-sm text-secondary mb-3">{{ $quotation->quotation_number }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Status:</strong></p>
                                    <p class="text-sm mb-3">
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
                                    </p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Quotation Date:</strong></p>
                                    <p class="text-sm text-secondary mb-3">
                                        {{ $quotation->quotation_date ? $quotation->quotation_date->format('M d, Y') : 'N/A' }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Valid Until:</strong></p>
                                    <p class="text-sm text-secondary mb-3">{{ $quotation->valid_until ? $quotation->valid_until->format('M d, Y') : 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="mb-3">Customer Information</h6>
                            <div class="row">
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Customer:</strong></p>
                                    <p class="text-sm text-secondary mb-3">{{ $quotation->customer->name }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Company:</strong></p>
                                    <p class="text-sm text-secondary mb-3">{{ $quotation->customer->company }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Email:</strong></p>
                                    <p class="text-sm text-secondary mb-3">{{ $quotation->customer->email }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Phone:</strong></p>
                                    <p class="text-sm text-secondary mb-3">{{ $quotation->customer->phone }}</p>
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
                                        <h4 class="text-white mb-0">{{ $quotation->items->count() }}</h4>
                                        <p class="text-white text-sm mb-0">Items</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-gradient-success">
                                <div class="card-body p-3">
                                    <div class="text-center">
                                        <h4 class="text-white mb-0">${{ number_format($quotation->subtotal, 2) }}</h4>
                                        <p class="text-white text-sm mb-0">Subtotal</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-gradient-warning">
                                <div class="card-body p-3">
                                    <div class="text-center">
                                        <h4 class="text-white mb-0">${{ number_format($quotation->tax_amount, 2) }}</h4>
                                        <p class="text-white text-sm mb-0">Tax</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-gradient-primary">
                                <div class="card-body p-3">
                                    <div class="text-center">
                                        <h4 class="text-white mb-0">${{ number_format($quotation->total_amount, 2) }}</h4>
                                        <p class="text-white text-sm mb-0">Total</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quotation Items -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="mb-3">Quotation Items</h6>
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Product</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Principal</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Quantity</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Unit Price</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Total Price</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($quotation->items as $item)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{ $item->product->name ?? 'N/A' }}
                                                            </h6>
                                                            <p class="text-xs text-secondary mb-0">
                                                                {{ $item->product->description ?? '' }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $item->principal->name ?? 'N/A' }}</p>
                                                    <p class="text-xs text-secondary mb-0">
                                                        {{ $item->principal->company ?? '' }}</p>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">
                                                        {{ number_format($item->quantity) }}
                                                        {{ $item->product->uom ?? 'PCS' }}
                                                    </span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">
                                                        ${{ number_format($item->unit_price, 2) }}
                                                    </span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">
                                                        ${{ number_format($item->total_price, 2) }}
                                                    </span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">
                                                        {{ Str::limit($item->remarks, 30) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-4">
                                                    <p class="text-secondary">No items found for this quotation.</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="mb-3">Terms & Conditions</h6>
                            <div class="card">
                                <div class="card-body">
                                    <p class="text-sm text-secondary mb-0">
                                        {{ $quotation->terms_conditions ?? 'Standard terms and conditions apply. Payment terms: 30 days from invoice date. Delivery: As per agreed schedule.' }}
                                    </p>
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
                                        <h6 class="text-dark text-sm font-weight-bold mb-0">Quotation Created</h6>
                                        <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                            {{ $quotation->quotation_date ? $quotation->quotation_date->format('M d, Y') : 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="timeline-block mb-3">
                                    <span class="timeline-step">
                                        @if ($quotation->status === 'approved')
                                            <i class="material-symbols-rounded text-success text-gradient">check_circle</i>
                                        @elseif($quotation->status === 'rejected')
                                            <i class="material-symbols-rounded text-danger text-gradient">cancel</i>
                                        @else
                                            <i class="material-symbols-rounded text-warning text-gradient">pending</i>
                                        @endif
                                    </span>
                                    <div class="timeline-content">
                                        <h6 class="text-dark text-sm font-weight-bold mb-0">Customer Approval</h6>
                                        <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                            @if ($quotation->status === 'approved')
                                                Approved - Ready for Indent
                                            @elseif($quotation->status === 'rejected')
                                                Rejected
                                            @else
                                                Pending Customer Response
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                @if ($quotation->status === 'approved')
                                    <div class="timeline-block mb-3">
                                        <span class="timeline-step">
                                            <i class="material-symbols-rounded text-info text-gradient">shopping_cart</i>
                                        </span>
                                        <div class="timeline-content">
                                            <h6 class="text-dark text-sm font-weight-bold mb-0">Create Indent</h6>
                                            <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                                Click "Create Indent" to continue workflow
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
