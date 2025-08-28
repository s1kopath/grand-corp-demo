@extends('layouts.app')

@section('title', 'Data Bank & Sourcing')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Data Bank & Sourcing</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <!-- Search and Filters -->
                    <div class="p-3">
                        <form method="GET" action="{{ route('dataBank.index') }}" class="row g-3">
                            <div class="col-md-4">
                                <div class="input-group input-group-outline">
                                    <label class="form-label">Search Products/Principals</label>
                                    <input type="text" class="form-control" name="search"
                                        value="{{ request('search') }}" title="Search by name, region, or aliases...">
                                </div>
                            </div>
                            <div class="col-md-2">
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
                            <div class="col-md-2">
                                <div class="input-group input-group-outline">
                                    <label class="form-label">Min Price (USD)</label>
                                    <input type="number" class="form-control" name="price_min"
                                        value="{{ request('price_min') }}" title="0">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group input-group-outline">
                                    <label class="form-label">Max Price (USD)</label>
                                    <input type="number" class="form-control" name="price_max"
                                        value="{{ request('price_max') }}" title="10000">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group input-group-outline">
                                    <label class="form-label">Min Reliability</label>
                                    <select class="form-control" name="reliability">
                                        <option value="" selected disabled></option>
                                        <option value="5" {{ request('reliability') == '5' ? 'selected' : '' }}>5 Stars
                                        </option>
                                        <option value="4" {{ request('reliability') == '4' ? 'selected' : '' }}>4+
                                            Stars</option>
                                        <option value="3" {{ request('reliability') == '3' ? 'selected' : '' }}>3+
                                            Stars</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Search</button>
                                <a href="{{ route('dataBank.index') }}" class="btn btn-secondary">Clear</a>
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
                                        Principal</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Price (USD)</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Year</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Region</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Reliability</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($records as $record)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $record->product_name }}</h6>
                                                    @if ($record->aliases)
                                                        <p class="text-xs text-secondary mb-0">
                                                            Aliases:
                                                            {{ implode(', ', array_slice($record->aliases, 0, 2)) }}
                                                            @if (count($record->aliases) > 2)
                                                                +{{ count($record->aliases) - 2 }} more
                                                            @endif
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $record->principal_name }}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span
                                                class="badge badge-sm bg-gradient-success">${{ number_format($record->price_usd, 2) }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $record->year }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $record->region }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="d-flex align-items-center justify-content-center">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i
                                                        class="fas fa-star {{ $i <= $record->reliability_score ? 'text-warning' : 'text-secondary' }}"></i>
                                                @endfor
                                                <span
                                                    class="text-secondary text-xs font-weight-bold ms-1">({{ $record->reliability_score }})</span>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <a href="{{ route('quotations.show', 1) }}"
                                                class="btn btn-link text-dark px-3 mb-0" title="Prepare Offer (Demo)">
                                                <i class="material-symbols-rounded text-sm me-2">shopping_cart</i>Prepare
                                                Offer
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <p class="text-secondary">No records found matching your criteria.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center py-3">
                        {{ $records->links() }}
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
                                <li>Fuzzy search across product names, principal names, and regions</li>
                                <li>Search through product aliases (JSON field)</li>
                                <li>Filter by price range and reliability score</li>
                                <li>Sort by reliability and year</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <p class="text-sm mb-2"><strong>Demo Workflow:</strong></p>
                            <ul class="text-sm text-secondary">
                                <li>Click "Prepare Offer" to simulate creating a quotation</li>
                                <li>This will navigate to a pre-seeded quotation</li>
                                <li>From there, you can follow the complete workflow</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
