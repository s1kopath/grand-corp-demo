@extends('layouts.app')

@section('title', 'Customers')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Customers</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <!-- Search and Filters -->
                    <div class="p-3">
                        <form method="GET" action="{{ route('crm.customers.index') }}" class="row g-3">
                            <div class="col-md-4">
                                <div class="input-group input-group-outline">
                                    <label class="form-label">Search Customers</label>
                                    <input type="text" class="form-control" name="search"
                                        value="{{ request('search') }}" title="Search by name, email, company...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group input-group-outline">
                                    <label class="form-label">Region</label>
                                    <select class="form-control" name="region">
                                        <option value="" selected disabled></option>
                                        @foreach ($regions as $region)
                                            <option value="{{ $region }}"
                                                {{ request('region') == $region ? 'selected' : '' }}>
                                                {{ $region }}
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
                                        <option value="prospect" {{ request('status') == 'prospect' ? 'selected' : '' }}>
                                            Prospect</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">Search</button>
                            </div>
                            <div class="col-12">
                                <a href="{{ route('crm.customers.index') }}" class="btn btn-secondary">Clear Filters</a>
                            </div>
                        </form>
                    </div>

                    <!-- Results -->
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Customer
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Company</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Contact</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Region</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Business</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($customers as $customer)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $customer->name }}</h6>
                                                    <p class="text-xs text-secondary mb-0">ID: {{ $customer->id }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $customer->company }}</p>
                                            <p class="text-xs text-secondary mb-0">{{ $customer->address }}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-xs font-weight-bold mb-0">{{ $customer->email }}</p>
                                            <p class="text-xs text-secondary mb-0">{{ $customer->phone }}</p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $customer->region }}</span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            @if ($customer->status === 'active')
                                                <span class="badge badge-sm bg-gradient-success">Active</span>
                                            @elseif($customer->status === 'inactive')
                                                <span class="badge badge-sm bg-gradient-secondary">Inactive</span>
                                            @else
                                                <span class="badge badge-sm bg-gradient-warning">Prospect</span>
                                            @endif
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="d-flex flex-column">
                                                <span class="text-xs font-weight-bold mb-0">
                                                    {{ $customer->quotations_count ?? 0 }} Quotations
                                                </span>
                                                <span class="text-xs text-secondary">
                                                    {{ $customer->indents_count ?? 0 }} Indents
                                                </span>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <a href="{{ route('crm.customers.show', $customer) }}"
                                                class="btn btn-link text-dark px-3 mb-0" title="View Details">
                                                <i class="material-symbols-rounded text-sm me-2">visibility</i>View
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <p class="text-secondary">No customers found matching your criteria.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center py-3">
                        {{ $customers->links() }}
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
                                <li>Search by customer name, email, phone, or company</li>
                                <li>Filter by region and status</li>
                                <li>View business relationship summary</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <p class="text-sm mb-2"><strong>Demo Data:</strong></p>
                            <ul class="text-sm text-secondary">
                                <li>12 customers across different regions</li>
                                <li>Various statuses (Active, Inactive, Prospect)</li>
                                <li>Click "View" to see detailed customer information</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
