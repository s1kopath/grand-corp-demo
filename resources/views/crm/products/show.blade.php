@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <div class="row">
                            <div class="col-6">
                                <h6 class="text-white text-capitalize ps-3">Product Details</h6>
                            </div>
                            <div class="col-6 text-end">
                                <a href="{{ route('crm.products.index') }}" class="btn btn-sm btn-outline-light me-3">
                                    <i class="material-symbols-rounded text-sm me-1">arrow_back</i>Back to List
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Product Information -->
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="mb-3">Basic Information</h6>
                            <div class="row">
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Name:</strong></p>
                                    <p class="text-sm text-secondary mb-3">{{ $product->name }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Category:</strong></p>
                                    <p class="text-sm text-secondary mb-3">{{ $product->category }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>UOM:</strong></p>
                                    <p class="text-sm text-secondary mb-3">{{ $product->uom }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="text-sm mb-1"><strong>Status:</strong></p>
                                    <p class="text-sm mb-3">
                                        @if ($product->status === 'active')
                                            <span class="badge badge-sm bg-gradient-success">Active</span>
                                        @elseif($product->status === 'inactive')
                                            <span class="badge badge-sm bg-gradient-secondary">Inactive</span>
                                        @else
                                            <span class="badge badge-sm bg-gradient-danger">Discontinued</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <p class="text-sm mb-1"><strong>Description:</strong></p>
                                    <p class="text-sm text-secondary mb-3">{{ $product->description }}</p>
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
                                                <h4 class="text-white mb-0">{{ $product->principals->count() }}</h4>
                                                <p class="text-white text-sm mb-0">Principals</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card bg-gradient-success">
                                        <div class="card-body p-3">
                                            <div class="text-center">
                                                <h4 class="text-white mb-0">{{ $product->quotationItems->count() }}</h4>
                                                <p class="text-white text-sm mb-0">Quotations</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 mt-3">
                                    <div class="card bg-gradient-warning">
                                        <div class="card-body p-3">
                                            <div class="text-center">
                                                <h4 class="text-white mb-0">{{ $product->indentItems->count() }}</h4>
                                                <p class="text-white text-sm mb-0">Indents</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 mt-3">
                                    <div class="card bg-gradient-primary">
                                        <div class="card-body p-3">
                                            <div class="text-center">
                                                <h4 class="text-white mb-0">{{ $product->created_at->format('M Y') }}</h4>
                                                <p class="text-white text-sm mb-0">Since</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Principal Suppliers -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="mb-3">Principal Suppliers</h6>
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Principal</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Company</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Country</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Status</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($product->principals as $principal)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{ $principal->name }}</h6>
                                                            <p class="text-xs text-secondary mb-0">{{ $principal->email }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">{{ $principal->company }}</p>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold">{{ $principal->country }}</span>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    @if ($principal->pivot->active)
                                                        <span class="badge badge-sm bg-gradient-success">Active</span>
                                                    @else
                                                        <span class="badge badge-sm bg-gradient-secondary">Inactive</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center">
                                                    <a href="{{ route('crm.principals.show', $principal) }}"
                                                        class="btn btn-link text-dark px-3 mb-0" title="View Principal">
                                                        <i class="material-symbols-rounded text-sm me-2">visibility</i>View
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-4">
                                                    <p class="text-secondary">No principals found for this product.</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Quotation Items -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="mb-3">Recent Quotation Items</h6>
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Quotation</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Customer</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Quantity</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Unit Price</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Total</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($product->quotationItems->take(5) as $item)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">
                                                                {{ $item->quotation->quotation_number ?? 'N/A' }}</h6>
                                                            <p class="text-xs text-secondary mb-0">
                                                                {{ $item->quotation->quotation_date->format('M d, Y') ?? 'N/A' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $item->quotation->customer->name ?? 'N/A' }}</p>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">
                                                        {{ number_format($item->quantity) }} {{ $product->uom }}
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
                                                    @if ($item->quotation)
                                                        <a href="{{ route('quotations.show', $item->quotation) }}"
                                                            class="btn btn-link text-dark px-3 mb-0"
                                                            title="View Quotation">
                                                            <i
                                                                class="material-symbols-rounded text-sm me-2">visibility</i>View
                                                        </a>
                                                    @else
                                                        <span class="text-secondary text-xs">N/A</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-4">
                                                    <p class="text-secondary">No quotation items found for this product.
                                                    </p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Indent Items -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="mb-3">Recent Indent Items</h6>
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Indent</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Customer</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Quantity</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Unit Price</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Total</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($product->indentItems->take(5) as $item)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">
                                                                {{ $item->indent->indent_number ?? 'N/A' }}</h6>
                                                            <p class="text-xs text-secondary mb-0">
                                                                {{ $item->indent->indent_date->format('M d, Y') ?? 'N/A' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $item->indent->customer->name ?? 'N/A' }}</p>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">
                                                        {{ number_format($item->quantity) }} {{ $product->uom }}
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
                                                    @if ($item->indent)
                                                        <a href="{{ route('indents.show', $item->indent) }}"
                                                            class="btn btn-link text-dark px-3 mb-0" title="View Indent">
                                                            <i
                                                                class="material-symbols-rounded text-sm me-2">visibility</i>View
                                                        </a>
                                                    @else
                                                        <span class="text-secondary text-xs">N/A</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-4">
                                                    <p class="text-secondary">No indent items found for this product.</p>
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
