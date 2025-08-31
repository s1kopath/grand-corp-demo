@extends('layouts.app')

@section('title', 'Products')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Products</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <!-- Search and Filters -->
                    <div class="p-3">
                        <form method="GET" action="{{ route('crm.products.index') }}" class="row g-3">
                            <div class="col-md-4">
                                <div class="input-group input-group-outline">
                                    <label class="form-label">Search Products</label>
                                    <input type="text" class="form-control" name="search"
                                        value="{{ request('search') }}" title="Search by name, description, category...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group input-group-outline">
                                    <label class="form-label">Category</label>
                                    <select class="form-control" name="category">
                                        <option value="" selected disabled></option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category }}"
                                                {{ request('category') == $category ? 'selected' : '' }}>
                                                {{ $category }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group input-group-outline">
                                    <label class="form-label">Status</label>
                                    <select class="form-control" name="status">
                                        <option value="" selected disabled></option>
                                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                        <option value="discontinued"
                                            {{ request('status') == 'discontinued' ? 'selected' : '' }}>Discontinued
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">Search</button>
                            </div>
                            <div class="col-12 d-flex justify-content-between">
                                <a href="{{ route('crm.products.index') }}" class="btn btn-secondary">Clear Filters</a>
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Category</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        UOM</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Principals</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Usage</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $product->name }}</h6>
                                                    <p class="text-xs text-secondary mb-0">
                                                        {{ Str::limit($product->description, 50) }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $product->category }}</p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $product->uom }}</span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            @if ($product->status === 'active')
                                                <span class="badge badge-sm bg-gradient-success">Active</span>
                                            @elseif($product->status === 'inactive')
                                                <span class="badge badge-sm bg-gradient-secondary">Inactive</span>
                                            @else
                                                <span class="badge badge-sm bg-gradient-danger">Discontinued</span>
                                            @endif
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="d-flex flex-column">
                                                <span class="text-xs font-weight-bold mb-0">
                                                    {{ $product->principals->count() }} Principals
                                                </span>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="d-flex flex-column">
                                                <span class="text-xs font-weight-bold mb-0">
                                                    {{ $product->quotationItems->count() }} Quotations
                                                </span>
                                                <span class="text-xs text-secondary">
                                                    {{ $product->principals->count() }} Principals
                                                </span>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <a href="{{ route('crm.products.show', $product) }}"
                                                class="btn btn-link text-dark px-3 mb-0" title="View Details">
                                                <i class="material-symbols-rounded text-sm me-2">visibility</i>View
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <p class="text-secondary">No products found matching your criteria.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center py-3">
                        {{ $products->links() }}
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
                                <li>Search by product name, description, or category</li>
                                <li>Filter by category and status</li>
                                <li>View principal relationships and usage statistics</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <p class="text-sm mb-2"><strong>Demo Data:</strong></p>
                            <ul class="text-sm text-secondary">
                                <li>40 products across 6 categories</li>
                                <li>Various statuses (Active, Inactive, Discontinued)</li>
                                <li>Click "View" to see detailed product information</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
