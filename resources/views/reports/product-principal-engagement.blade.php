@extends('layouts.app')

@section('title', 'Product-Principal Engagement Report')

@section('content')
    <div class="container-fluid py-4">
        <!-- Date Filter Form -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Date Filter</h6>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('reports.product-principal-engagement') }}" class="row g-3">
                            <div class="col-md-4">
                                <label for="from_date" class="form-label">From Date</label>
                                <input type="date" class="form-control" id="from_date" name="from_date"
                                    value="{{ $fromDate }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="to_date" class="form-label">To Date</label>
                                <input type="date" class="form-control" id="to_date" name="to_date"
                                    value="{{ $toDate }}" required>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary me-2">Generate Report</button>
                                <a href="{{ route('reports.product-principal-engagement') }}"
                                    class="btn btn-secondary">Reset</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-6">
                                <h6>Product-Principal Engagement Report</h6>
                                <p class="text-sm mb-0">
                                    <i class="fa fa-clock text-success" aria-hidden="true"></i>
                                    <span class="font-weight-bold">Purpose:</span> Map which products are linked to which
                                    principals and their activity
                                </p>
                                <p class="text-sm mb-0">
                                    <span class="font-weight-bold">Period:</span> {{ $data['period']['from'] }} to
                                    {{ $data['period']['to'] }}
                                </p>
                            </div>
                            <div class="col-6 text-end">
                                <h6 class="text-sm font-weight-bold">Report Date: {{ $data['report_date'] }}</h6>
                                <h6 class="text-sm font-weight-bold">Total Products: {{ $data['total_products'] }}</h6>
                            </div>
                        </div>

                        <!-- Legend -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="d-flex flex-wrap gap-3">
                                    <div class="d-flex align-items-center">
                                        <span class="badge badge-sm bg-gradient-primary me-2"></span>
                                        <small class="text-secondary">Current Period ({{ $data['period']['from'] }} to
                                            {{ $data['period']['to'] }})</small>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="badge badge-sm bg-gradient-success me-2"></span>
                                        <small class="text-secondary">Previous Year
                                            ({{ $comparisonData['previous_year']['period']['from'] }} to
                                            {{ $comparisonData['previous_year']['period']['to'] }})</small>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="badge badge-sm bg-gradient-info me-2"></span>
                                        <small class="text-secondary">Two Years Ago
                                            ({{ $comparisonData['two_years_ago']['period']['from'] }} to
                                            {{ $comparisonData['two_years_ago']['period']['to'] }})</small>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="badge badge-sm bg-gradient-success me-2"></span>
                                        <small class="text-secondary">Growth (Positive)</small>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="badge badge-sm bg-gradient-danger me-2"></span>
                                        <small class="text-secondary">Growth (Negative)</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Product Name</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Principal</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Current Period<br>
                                            <small class="text-xs">{{ $data['period']['from'] }} to
                                                {{ $data['period']['to'] }}</small><br>
                                            Orders
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Previous Year<br>
                                            <small class="text-xs">{{ $comparisonData['previous_year']['period']['from'] }}
                                                to {{ $comparisonData['previous_year']['period']['to'] }}</small><br>
                                            Orders
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Two Years Ago<br>
                                            <small class="text-xs">{{ $comparisonData['two_years_ago']['period']['from'] }}
                                                to {{ $comparisonData['two_years_ago']['period']['to'] }}</small><br>
                                            Orders
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Growth vs PY</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Growth vs 2YA</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['products'] as $index => $product)
                                        @php
                                            $currentOrders = $product['total_orders'];
                                            $prevYearOrders =
                                                $comparisonData['previous_year']['data']['products'][$index][
                                                    'total_orders'
                                                ] ?? 0;
                                            $twoYearsAgoOrders =
                                                $comparisonData['two_years_ago']['data']['products'][$index][
                                                    'total_orders'
                                                ] ?? 0;

                                            $growthVsPY =
                                                $prevYearOrders > 0
                                                    ? (($currentOrders - $prevYearOrders) / $prevYearOrders) * 100
                                                    : 0;
                                            $growthVs2YA =
                                                $twoYearsAgoOrders > 0
                                                    ? (($currentOrders - $twoYearsAgoOrders) / $twoYearsAgoOrders) * 100
                                                    : 0;
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $product['product_name'] }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span
                                                    class="badge badge-sm bg-gradient-info">{{ $product['principal'] }}</span>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span
                                                    class="badge badge-sm bg-gradient-primary">{{ $currentOrders }}</span>
                                                <br>
                                                <small class="text-secondary">{{ $product['avg_shipment_delay'] }} days
                                                    delay</small>
                                                <br>
                                                <small class="text-secondary">{{ $product['outstanding_indent'] }}
                                                    outstanding</small>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span
                                                    class="badge badge-sm bg-gradient-success">{{ $prevYearOrders }}</span>
                                                <br>
                                                <small
                                                    class="text-secondary">{{ $comparisonData['previous_year']['data']['products'][$index]['avg_shipment_delay'] ?? 0 }}
                                                    days delay</small>
                                                <br>
                                                <small
                                                    class="text-secondary">{{ $comparisonData['previous_year']['data']['products'][$index]['outstanding_indent'] ?? 0 }}
                                                    outstanding</small>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span
                                                    class="badge badge-sm bg-gradient-info">{{ $twoYearsAgoOrders }}</span>
                                                <br>
                                                <small
                                                    class="text-secondary">{{ $comparisonData['two_years_ago']['data']['products'][$index]['avg_shipment_delay'] ?? 0 }}
                                                    days delay</small>
                                                <br>
                                                <small
                                                    class="text-secondary">{{ $comparisonData['two_years_ago']['data']['products'][$index]['outstanding_indent'] ?? 0 }}
                                                    outstanding</small>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="badge badge-sm {{ $growthVsPY >= 0 ? 'bg-gradient-success' : 'bg-gradient-danger' }}">
                                                    {{ $growthVsPY >= 0 ? '+' : '' }}{{ number_format($growthVsPY, 1) }}%
                                                </span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="badge badge-sm {{ $growthVs2YA >= 0 ? 'bg-gradient-success' : 'bg-gradient-danger' }}">
                                                    {{ $growthVs2YA >= 0 ? '+' : '' }}{{ number_format($growthVs2YA, 1) }}%
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach

                                    <!-- Summary Row -->
                                    @php
                                        $currentTotalOrders = $data['products']->sum('total_orders');
                                        $prevYearTotalOrders = $comparisonData['previous_year']['data'][
                                            'products'
                                        ]->sum('total_orders');
                                        $twoYearsAgoTotalOrders = $comparisonData['two_years_ago']['data'][
                                            'products'
                                        ]->sum('total_orders');

                                        $totalGrowthVsPY =
                                            $prevYearTotalOrders > 0
                                                ? (($currentTotalOrders - $prevYearTotalOrders) /
                                                        $prevYearTotalOrders) *
                                                    100
                                                : 0;
                                        $totalGrowthVs2YA =
                                            $twoYearsAgoTotalOrders > 0
                                                ? (($currentTotalOrders - $twoYearsAgoTotalOrders) /
                                                        $twoYearsAgoTotalOrders) *
                                                    100
                                                : 0;
                                    @endphp
                                    <tr class="table-dark">
                                        <td class="align-middle">
                                            <strong class="text-white">TOTAL</strong>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="badge badge-sm bg-gradient-info text-white font-weight-bold">All
                                                Principals</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="badge badge-sm bg-gradient-primary text-white font-weight-bold">{{ $currentTotalOrders }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="badge badge-sm bg-gradient-success text-white font-weight-bold">{{ $prevYearTotalOrders }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="badge badge-sm bg-gradient-info text-white font-weight-bold">{{ $twoYearsAgoTotalOrders }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="badge badge-sm {{ $totalGrowthVsPY >= 0 ? 'bg-gradient-success' : 'bg-gradient-danger' }} text-white font-weight-bold">
                                                {{ $totalGrowthVsPY >= 0 ? '+' : '' }}{{ number_format($totalGrowthVsPY, 1) }}%
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="badge badge-sm {{ $totalGrowthVs2YA >= 0 ? 'bg-gradient-success' : 'bg-gradient-danger' }} text-white font-weight-bold">
                                                {{ $totalGrowthVs2YA >= 0 ? '+' : '' }}{{ number_format($totalGrowthVs2YA, 1) }}%
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Date Range Note -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="alert alert-info alert-dismissible fade show" role="alert">
                                    <i class="fa fa-info-circle me-2"></i>
                                    <strong>Date Range Comparison:</strong> The table compares the same date range across
                                    different years.
                                    For example, if you selected Jan 1 - Mar 31, 2024, it shows data for Jan 1 - Mar 31,
                                    2023 (Previous Year)
                                    and Jan 1 - Mar 31, 2022 (Two Years Ago) for accurate year-over-year comparison.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Year-over-Year Comparison -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Year-over-Year Comparison</h6>
                    </div>
                    <div class="card-body">
                        <!-- Summary Cards -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="card bg-gradient-primary text-white">
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="numbers">
                                                    <p class="text-sm mb-0 text-white">Current Year
                                                        ({{ $comparisonData['current_year']['year'] }})</p>
                                                    <h5 class="font-weight-bolder mb-0 text-white">
                                                        {{ $comparisonData['current_year']['data']['products']->sum('total_orders') }}
                                                        <span class="text-white text-sm font-weight-bolder">Orders</span>
                                                    </h5>
                                                    <p class="text-xs mb-0 text-white">
                                                        {{ $comparisonData['current_year']['period']['from'] }} -
                                                        {{ $comparisonData['current_year']['period']['to'] }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-4 text-end">
                                                <div class="icon icon-shape bg-white shadow text-center rounded-circle">
                                                    <i class="material-symbols-rounded text-lg opacity-10 text-primary"
                                                        aria-hidden="true">trending_up</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-gradient-success text-white">
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="numbers">
                                                    <p class="text-sm mb-0 text-white">Previous Year
                                                        ({{ $comparisonData['previous_year']['year'] }})</p>
                                                    <h5 class="font-weight-bolder mb-0 text-white">
                                                        {{ $comparisonData['previous_year']['data']['products']->sum('total_orders') }}
                                                        <span class="text-white text-sm font-weight-bolder">Orders</span>
                                                    </h5>
                                                    <p class="text-xs mb-0 text-white">
                                                        {{ $comparisonData['previous_year']['period']['from'] }} -
                                                        {{ $comparisonData['previous_year']['period']['to'] }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-4 text-end">
                                                <div class="icon icon-shape bg-white shadow text-center rounded-circle">
                                                    <i class="material-symbols-rounded text-lg opacity-10 text-success"
                                                        aria-hidden="true">history</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-gradient-info text-white">
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="numbers">
                                                    <p class="text-sm mb-0 text-white">Two Years Ago
                                                        ({{ $comparisonData['two_years_ago']['year'] }})</p>
                                                    <h5 class="font-weight-bolder mb-0 text-white">
                                                        {{ $comparisonData['two_years_ago']['data']['products']->sum('total_orders') }}
                                                        <span class="text-white text-sm font-weight-bolder">Orders</span>
                                                    </h5>
                                                    <p class="text-xs mb-0 text-white">
                                                        {{ $comparisonData['two_years_ago']['period']['from'] }} -
                                                        {{ $comparisonData['two_years_ago']['period']['to'] }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-4 text-end">
                                                <div class="icon icon-shape bg-white shadow text-center rounded-circle">
                                                    <i class="material-symbols-rounded text-lg opacity-10 text-info"
                                                        aria-hidden="true">schedule</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Comparison Chart -->
                        <div class="row">
                            <div class="col-12">
                                <canvas id="comparisonChart" height="100"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Engagement Heatmap -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Engagement Intensity Heatmap</h6>
                        <p class="text-sm mb-0">Color intensity based on total orders and delay performance</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($data['products']->take(12) as $product)
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body p-3 text-center">
                                            <h6 class="text-sm font-weight-bold mb-1">{{ $product['product_name'] }}</h6>
                                            <p class="text-xs text-secondary mb-2">{{ $product['principal'] }}</p>
                                            <div class="d-flex justify-content-between">
                                                <span class="text-xs">Orders: {{ $product['total_orders'] }}</span>
                                                <span class="text-xs">Delay: {{ $product['avg_shipment_delay'] }}d</span>
                                            </div>
                                            <div class="mt-2">
                                                @if ($product['total_orders'] > 100)
                                                    <span class="badge badge-sm bg-gradient-success">High Engagement</span>
                                                @elseif($product['total_orders'] > 50)
                                                    <span class="badge badge-sm bg-gradient-warning">Medium
                                                        Engagement</span>
                                                @else
                                                    <span class="badge badge-sm bg-gradient-secondary">Low
                                                        Engagement</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Metrics -->
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Products</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $data['total_products'] }}
                                        <span class="text-success text-sm font-weight-bolder">Products</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                    <i class="material-symbols-rounded text-lg opacity-10"
                                        aria-hidden="true">inventory</i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Orders</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $data['products']->sum('total_orders') }}
                                        <span class="text-success text-sm font-weight-bolder">Orders</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                    <i class="material-symbols-rounded text-lg opacity-10"
                                        aria-hidden="true">shopping_cart</i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Avg Delay</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ round($data['products']->avg('avg_shipment_delay'), 1) }}
                                        <span class="text-success text-sm font-weight-bolder">Days</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                    <i class="material-symbols-rounded text-lg opacity-10" aria-hidden="true">schedule</i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Outstanding Indents</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $data['products']->sum('outstanding_indent') }}
                                        <span class="text-success text-sm font-weight-bolder">Items</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-info shadow-info text-center rounded-circle">
                                    <i class="material-symbols-rounded text-lg opacity-10" aria-hidden="true">pending</i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Comparison Chart
        const comparisonCtx = document.getElementById('comparisonChart').getContext('2d');
        new Chart(comparisonCtx, {
            type: 'bar',
            data: {
                labels: ['{{ $comparisonData['two_years_ago']['year'] }}',
                    '{{ $comparisonData['previous_year']['year'] }}',
                    '{{ $comparisonData['current_year']['year'] }}'
                ],
                datasets: [{
                    label: 'Total Orders',
                    data: [
                        {{ $comparisonData['two_years_ago']['data']['products']->sum('total_orders') }},
                        {{ $comparisonData['previous_year']['data']['products']->sum('total_orders') }},
                        {{ $comparisonData['current_year']['data']['products']->sum('total_orders') }}
                    ],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(34, 197, 94, 0.6)',
                        'rgba(75, 192, 192, 0.6)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(34, 197, 94, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Total Orders'
                        }
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Orders Comparison Chart'
                    }
                }
            }
        });
    </script>
@endpush
