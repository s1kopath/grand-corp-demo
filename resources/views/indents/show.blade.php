@extends('layouts.app')

@section('title', 'Indent ' . $indent->indent_number)

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <div class="row">
                            <div class="col-6">
                                <h6 class="text-white text-capitalize ps-3">Indent Details</h6>
                            </div>
                            <div class="col-6 text-end">
                                <a href="{{ route('indents.index') }}" class="btn btn-sm btn-outline-light me-3">
                                    <i class="material-symbols-rounded text-sm me-1">arrow_back</i>Back to List
                                </a>
                                @if ($indent->status === 'approved')
                                    <a href="{{ route('indents.goToLc', $indent) }}" class="btn btn-sm btn-info me-3">
                                        <i class="material-symbols-rounded text-sm me-1">account_balance</i>Issue L/C
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Indent Information -->
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="mb-3">Basic Information</h6>
                            <div class="row">
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Indent Number:</strong></p>
                                    <p class="text-sm text-secondary mb-3">{{ $indent->indent_number }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Status:</strong></p>
                                    <p class="text-sm mb-3">
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
                                    </p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Indent Date:</strong></p>
                                    <p class="text-sm text-secondary mb-3">
                                        {{ $indent->indent_date ? $indent->indent_date->format('M d, Y') : 'N/A' }}
                                    </p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Delivery Date:</strong></p>
                                    <p class="text-sm text-secondary mb-3">
                                        {{ $indent->delivery_date ? $indent->delivery_date->format('M d, Y') : 'N/A' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="mb-3">Customer Information</h6>
                            <div class="row">
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Customer:</strong></p>
                                    <p class="text-sm text-secondary mb-3">{{ $indent->customer->name }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Company:</strong></p>
                                    <p class="text-sm text-secondary mb-3">{{ $indent->customer->company }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Email:</strong></p>
                                    <p class="text-sm text-secondary mb-3">{{ $indent->customer->email }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Phone:</strong></p>
                                    <p class="text-sm text-secondary mb-3">{{ $indent->customer->phone }}</p>
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
                                        <h4 class="text-white mb-0">{{ $indent->items->count() }}</h4>
                                        <p class="text-white text-sm mb-0">Items</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-gradient-success">
                                <div class="card-body p-3">
                                    <div class="text-center">
                                        <h4 class="text-white mb-0">${{ number_format($indent->subtotal, 2) }}</h4>
                                        <p class="text-white text-sm mb-0">Subtotal</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-gradient-warning">
                                <div class="card-body p-3">
                                    <div class="text-center">
                                        <h4 class="text-white mb-0">${{ number_format($indent->tax_amount, 2) }}</h4>
                                        <p class="text-white text-sm mb-0">Tax</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-gradient-primary">
                                <div class="card-body p-3">
                                    <div class="text-center">
                                        <h4 class="text-white mb-0">${{ number_format($indent->total_amount, 2) }}</h4>
                                        <p class="text-white text-sm mb-0">Total</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Indent Items -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="mb-3">Indent Items</h6>
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
                                        @forelse($indent->items as $item)
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
                                                    <p class="text-secondary">No items found for this indent.</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Related L/Cs -->
                    @if ($indent->letterOfCredits->count() > 0)
                        <div class="row mt-4">
                            <div class="col-12">
                                <h6 class="mb-3">Related Letters of Credit</h6>
                                <div class="table-responsive">
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    L/C Number</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
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
                                                    Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($indent->letterOfCredits as $lc)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex px-2 py-1">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">{{ $lc->lc_number }}</h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0">{{ $lc->issuing_bank }}
                                                        </p>
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
                                                        @if ($lc->status === 'active')
                                                            <span class="badge badge-sm bg-gradient-success">Active</span>
                                                        @elseif($lc->status === 'expired')
                                                            <span class="badge badge-sm bg-gradient-danger">Expired</span>
                                                        @else
                                                            <span
                                                                class="badge badge-sm bg-gradient-secondary">{{ ucfirst($lc->status) }}</span>
                                                        @endif
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <a href="{{ route('lcs.show', $lc) }}"
                                                            class="btn btn-link text-dark px-3 mb-0" title="View L/C">
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

                    <!-- Terms and Conditions -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="mb-3">Terms & Conditions</h6>
                            <div class="card">
                                <div class="card-body">
                                    <p class="text-sm text-secondary mb-0">
                                        {{ $indent->terms_conditions ?? 'Standard terms and conditions apply. Payment terms: As per L/C. Delivery: As per agreed schedule.' }}
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
                                            {{ $indent->indent_date ? $indent->indent_date->format('M d, Y') : 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="timeline-block mb-3">
                                    <span class="timeline-step">
                                        @if ($indent->status === 'approved')
                                            <i class="material-symbols-rounded text-success text-gradient">check_circle</i>
                                        @elseif($indent->status === 'cancelled')
                                            <i class="material-symbols-rounded text-danger text-gradient">cancel</i>
                                        @else
                                            <i class="material-symbols-rounded text-warning text-gradient">pending</i>
                                        @endif
                                    </span>
                                    <div class="timeline-content">
                                        <h6 class="text-dark text-sm font-weight-bold mb-0">Indent Approval</h6>
                                        <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                            @if ($indent->status === 'approved')
                                                Approved - Ready for L/C
                                            @elseif($indent->status === 'cancelled')
                                                Cancelled
                                            @else
                                                Pending Approval
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                @if ($indent->status === 'approved')
                                    <div class="timeline-block mb-3">
                                        <span class="timeline-step">
                                            <i class="material-symbols-rounded text-info text-gradient">account_balance</i>
                                        </span>
                                        <div class="timeline-content">
                                            <h6 class="text-dark text-sm font-weight-bold mb-0">Issue L/C</h6>
                                            <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                                Click "Issue L/C" to continue workflow
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
