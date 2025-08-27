@extends('layouts.app')

@section('title', $principal->name)

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <div class="row">
                            <div class="col-6">
                                <h6 class="text-white text-capitalize ps-3">Principal Details</h6>
                            </div>
                            <div class="col-6 text-end">
                                <a href="{{ route('crm.principals.index') }}" class="btn btn-sm btn-outline-light me-3">
                                    <i class="material-icons text-sm me-1">arrow_back</i>Back to List
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Principal Information -->
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="mb-3">Basic Information</h6>
                            <div class="row">
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Name:</strong></p>
                                    <p class="text-sm text-secondary mb-3">{{ $principal->name }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Company:</strong></p>
                                    <p class="text-sm text-secondary mb-3">{{ $principal->company }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Email:</strong></p>
                                    <p class="text-sm text-secondary mb-3">{{ $principal->email }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Phone:</strong></p>
                                    <p class="text-sm text-secondary mb-3">{{ $principal->phone }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Country:</strong></p>
                                    <p class="text-sm text-secondary mb-3">{{ $principal->country }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Status:</strong></p>
                                    <p class="text-sm mb-3">
                                        @if($principal->status === 'active')
                                            <span class="badge badge-sm bg-gradient-success">Active</span>
                                        @elseif($principal->status === 'inactive')
                                            <span class="badge badge-sm bg-gradient-secondary">Inactive</span>
                                        @else
                                            <span class="badge badge-sm bg-gradient-warning">Pending</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <p class="text-sm mb-1"><strong>Address:</strong></p>
                                    <p class="text-sm text-secondary mb-3">{{ $principal->address }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="mb-3">Business Summary</h6>
                            <div class="row">
                                <div class="col-6">
                                    <div class="card bg-gradient-info">
                                        <div class="card-body p-3">
                                            <div class="text-center">
                                                <h4 class="text-white mb-0">{{ $principal->products->count() }}</h4>
                                                <p class="text-white text-sm mb-0">Products</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card bg-gradient-success">
                                        <div class="card-body p-3">
                                            <div class="text-center">
                                                <h4 class="text-white mb-0">{{ $principal->quotations->count() }}</h4>
                                                <p class="text-white text-sm mb-0">Quotations</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 mt-3">
                                    <div class="card bg-gradient-warning">
                                        <div class="card-body p-3">
                                            <div class="text-center">
                                                <h4 class="text-white mb-0">{{ $principal->indents->count() }}</h4>
                                                <p class="text-white text-sm mb-0">Indents</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 mt-3">
                                    <div class="card bg-gradient-primary">
                                        <div class="card-body p-3">
                                            <div class="text-center">
                                                <h4 class="text-white mb-0">{{ $principal->created_at->format('M Y') }}</h4>
                                                <p class="text-white text-sm mb-0">Since</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Portfolio -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="mb-3">Product Portfolio</h6>
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Category</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">UOM</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($principal->products as $product)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{ $product->name }}</h6>
                                                            <p class="text-xs text-secondary mb-0">{{ $product->description }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">{{ $product->category }}</p>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">{{ $product->uom }}</span>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    @if($product->pivot->active)
                                                        <span class="badge badge-sm bg-gradient-success">Active</span>
                                                    @else
                                                        <span class="badge badge-sm bg-gradient-secondary">Inactive</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center">
                                                    <a href="{{ route('crm.products.show', $product) }}" 
                                                       class="btn btn-link text-dark px-3 mb-0" title="View Product">
                                                        <i class="material-icons text-sm me-2">visibility</i>View
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-4">
                                                    <p class="text-secondary">No products found for this principal.</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Quotations -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="mb-3">Recent Quotations</h6>
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Quotation</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Customer</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Amount</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($principal->quotations->take(5) as $quotation)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{ $quotation->quotation_number }}</h6>
                                                            <p class="text-xs text-secondary mb-0">{{ $quotation->items->count() }} items</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">{{ $quotation->customer->name ?? 'N/A' }}</p>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">
                                                        {{ $quotation->quotation_date->format('M d, Y') }}
                                                    </span>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    @if($quotation->status === 'pending')
                                                        <span class="badge badge-sm bg-gradient-warning">Pending</span>
                                                    @elseif($quotation->status === 'approved')
                                                        <span class="badge badge-sm bg-gradient-success">Approved</span>
                                                    @elseif($quotation->status === 'rejected')
                                                        <span class="badge badge-sm bg-gradient-danger">Rejected</span>
                                                    @else
                                                        <span class="badge badge-sm bg-gradient-secondary">{{ ucfirst($quotation->status) }}</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">
                                                        ${{ number_format($quotation->total_amount, 2) }}
                                                    </span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <a href="{{ route('quotations.show', $quotation) }}" 
                                                       class="btn btn-link text-dark px-3 mb-0" title="View Quotation">
                                                        <i class="material-icons text-sm me-2">visibility</i>View
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-4">
                                                    <p class="text-secondary">No quotations found for this principal.</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
