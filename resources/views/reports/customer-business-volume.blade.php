@extends('layouts.app')

@section('title', 'Customer Business Volume Report')

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
                        <form method="GET" action="{{ route('reports.customer-business-volume') }}" class="row g-3">
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
                                <a href="{{ route('reports.customer-business-volume') }}"
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
                                <h6>Customer-wise Business Volume Report</h6>
                                <p class="text-sm mb-0">
                                    <i class="fa fa-clock text-success" aria-hidden="true"></i>
                                    <span class="font-weight-bold">Purpose:</span> Show revenue and transaction frequency
                                    per customer
                                </p>
                                <p class="text-sm mb-0">
                                    <span class="font-weight-bold">Period:</span> {{ $data['period']['from'] }} to
                                    {{ $data['period']['to'] }}
                                </p>
                            </div>
                            <div class="col-6 text-end">
                                <h6 class="text-sm font-weight-bold">Report Date: {{ $data['report_date'] }}</h6>
                                <h6 class="text-sm font-weight-bold">Currency: {{ $data['currency'] }}</h6>
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
                                            Customer Name</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Current Period<br>
                                            <small class="text-xs">{{ $data['period']['from'] }} to
                                                {{ $data['period']['to'] }}</small><br>
                                            ({{ $data['currency'] }})
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Previous Year<br>
                                            <small class="text-xs">{{ $comparisonData['previous_year']['period']['from'] }}
                                                to {{ $comparisonData['previous_year']['period']['to'] }}</small><br>
                                            ({{ $data['currency'] }})
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Two Years Ago<br>
                                            <small class="text-xs">{{ $comparisonData['two_years_ago']['period']['from'] }}
                                                to {{ $comparisonData['two_years_ago']['period']['to'] }}</small><br>
                                            ({{ $data['currency'] }})
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
                                    @foreach ($data['customers'] as $index => $customer)
                                        @php
                                            $currentRevenue = $customer['total_revenue'];
                                            $prevYearRevenue =
                                                $comparisonData['previous_year']['data']['customers'][$index][
                                                    'total_revenue'
                                                ] ?? 0;
                                            $twoYearsAgoRevenue =
                                                $comparisonData['two_years_ago']['data']['customers'][$index][
                                                    'total_revenue'
                                                ] ?? 0;

                                            $growthVsPY =
                                                $prevYearRevenue > 0
                                                    ? (($currentRevenue - $prevYearRevenue) / $prevYearRevenue) * 100
                                                    : 0;
                                            $growthVs2YA =
                                                $twoYearsAgoRevenue > 0
                                                    ? (($currentRevenue - $twoYearsAgoRevenue) / $twoYearsAgoRevenue) *
                                                        100
                                                    : 0;
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $customer['customer_name'] }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span
                                                    class="badge badge-sm bg-gradient-primary">{{ number_format($currentRevenue, 2) }}</span>
                                                <br>
                                                <small class="text-secondary">{{ $customer['total_orders'] }}
                                                    orders</small>
                                                <br>
                                                <small
                                                    class="text-secondary">{{ number_format($customer['total_volume']) }}
                                                    units</small>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span
                                                    class="badge badge-sm bg-gradient-success">{{ number_format($prevYearRevenue, 2) }}</span>
                                                <br>
                                                <small
                                                    class="text-secondary">{{ $comparisonData['previous_year']['data']['customers'][$index]['total_orders'] ?? 0 }}
                                                    orders</small>
                                                <br>
                                                <small
                                                    class="text-secondary">{{ number_format($comparisonData['previous_year']['data']['customers'][$index]['total_volume'] ?? 0) }}
                                                    units</small>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span
                                                    class="badge badge-sm bg-gradient-info">{{ number_format($twoYearsAgoRevenue, 2) }}</span>
                                                <br>
                                                <small
                                                    class="text-secondary">{{ $comparisonData['two_years_ago']['data']['customers'][$index]['total_orders'] ?? 0 }}
                                                    orders</small>
                                                <br>
                                                <small
                                                    class="text-secondary">{{ number_format($comparisonData['two_years_ago']['data']['customers'][$index]['total_volume'] ?? 0) }}
                                                    units</small>
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
                                        $currentTotalRevenue = $data['customers']->sum('total_revenue');
                                        $prevYearTotalRevenue = $comparisonData['previous_year']['data'][
                                            'customers'
                                        ]->sum('total_revenue');
                                        $twoYearsAgoTotalRevenue = $comparisonData['two_years_ago']['data'][
                                            'customers'
                                        ]->sum('total_revenue');

                                        $totalGrowthVsPY =
                                            $prevYearTotalRevenue > 0
                                                ? (($currentTotalRevenue - $prevYearTotalRevenue) /
                                                        $prevYearTotalRevenue) *
                                                    100
                                                : 0;
                                        $totalGrowthVs2YA =
                                            $twoYearsAgoTotalRevenue > 0
                                                ? (($currentTotalRevenue - $twoYearsAgoTotalRevenue) /
                                                        $twoYearsAgoTotalRevenue) *
                                                    100
                                                : 0;
                                    @endphp
                                    <tr class="table-dark">
                                        <td class="align-middle">
                                            <strong class="text-white">TOTAL</strong>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="badge badge-sm bg-gradient-primary text-white font-weight-bold">{{ number_format($currentTotalRevenue, 2) }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="badge badge-sm bg-gradient-success text-white font-weight-bold">{{ number_format($prevYearTotalRevenue, 2) }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="badge badge-sm bg-gradient-info text-white font-weight-bold">{{ number_format($twoYearsAgoTotalRevenue, 2) }}</span>
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
                                                        {{ number_format($comparisonData['current_year']['data']['customers']->sum('total_revenue'), 2) }}
                                                        <span
                                                            class="text-white text-sm font-weight-bolder">{{ $data['currency'] }}</span>
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
                                                        {{ number_format($comparisonData['previous_year']['data']['customers']->sum('total_revenue'), 2) }}
                                                        <span
                                                            class="text-white text-sm font-weight-bolder">{{ $data['currency'] }}</span>
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
                                                        {{ number_format($comparisonData['two_years_ago']['data']['customers']->sum('total_revenue'), 2) }}
                                                        <span
                                                            class="text-white text-sm font-weight-bolder">{{ $data['currency'] }}</span>
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

                        <!-- Growth Metrics Table -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Metric</th>
                                                <th class="text-center">Current vs Previous Year</th>
                                                <th class="text-center">Current vs Two Years Ago</th>
                                                <th class="text-center">Previous vs Two Years Ago</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong>Total Revenue</strong></td>
                                                <td class="text-center">
                                                    @php
                                                        $currentRevenue = $comparisonData['current_year']['data'][
                                                            'customers'
                                                        ]->sum('total_revenue');
                                                        $prevRevenue = $comparisonData['previous_year']['data'][
                                                            'customers'
                                                        ]->sum('total_revenue');
                                                        $growth =
                                                            $prevRevenue > 0
                                                                ? (($currentRevenue - $prevRevenue) / $prevRevenue) *
                                                                    100
                                                                : 0;
                                                    @endphp
                                                    <span
                                                        class="badge badge-sm {{ $growth >= 0 ? 'bg-gradient-success' : 'bg-gradient-danger' }}">
                                                        {{ $growth >= 0 ? '+' : '' }}{{ number_format($growth, 1) }}%
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    @php
                                                        $twoYearsRevenue = $comparisonData['two_years_ago']['data'][
                                                            'customers'
                                                        ]->sum('total_revenue');
                                                        $growth2 =
                                                            $twoYearsRevenue > 0
                                                                ? (($currentRevenue - $twoYearsRevenue) /
                                                                        $twoYearsRevenue) *
                                                                    100
                                                                : 0;
                                                    @endphp
                                                    <span
                                                        class="badge badge-sm {{ $growth2 >= 0 ? 'bg-gradient-success' : 'bg-gradient-danger' }}">
                                                        {{ $growth2 >= 0 ? '+' : '' }}{{ number_format($growth2, 1) }}%
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    @php
                                                        $growth3 =
                                                            $twoYearsRevenue > 0
                                                                ? (($prevRevenue - $twoYearsRevenue) /
                                                                        $twoYearsRevenue) *
                                                                    100
                                                                : 0;
                                                    @endphp
                                                    <span
                                                        class="badge badge-sm {{ $growth3 >= 0 ? 'bg-gradient-success' : 'bg-gradient-danger' }}">
                                                        {{ $growth3 >= 0 ? '+' : '' }}{{ number_format($growth3, 1) }}%
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Total Orders</strong></td>
                                                <td class="text-center">
                                                    @php
                                                        $currentOrders = $comparisonData['current_year']['data'][
                                                            'customers'
                                                        ]->sum('total_orders');
                                                        $prevOrders = $comparisonData['previous_year']['data'][
                                                            'customers'
                                                        ]->sum('total_orders');
                                                        $orderGrowth =
                                                            $prevOrders > 0
                                                                ? (($currentOrders - $prevOrders) / $prevOrders) * 100
                                                                : 0;
                                                    @endphp
                                                    <span
                                                        class="badge badge-sm {{ $orderGrowth >= 0 ? 'bg-gradient-success' : 'bg-gradient-danger' }}">
                                                        {{ $orderGrowth >= 0 ? '+' : '' }}{{ number_format($orderGrowth, 1) }}%
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    @php
                                                        $twoYearsOrders = $comparisonData['two_years_ago']['data'][
                                                            'customers'
                                                        ]->sum('total_orders');
                                                        $orderGrowth2 =
                                                            $twoYearsOrders > 0
                                                                ? (($currentOrders - $twoYearsOrders) /
                                                                        $twoYearsOrders) *
                                                                    100
                                                                : 0;
                                                    @endphp
                                                    <span
                                                        class="badge badge-sm {{ $orderGrowth2 >= 0 ? 'bg-gradient-success' : 'bg-gradient-danger' }}">
                                                        {{ $orderGrowth2 >= 0 ? '+' : '' }}{{ number_format($orderGrowth2, 1) }}%
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    @php
                                                        $orderGrowth3 =
                                                            $twoYearsOrders > 0
                                                                ? (($prevOrders - $twoYearsOrders) / $twoYearsOrders) *
                                                                    100
                                                                : 0;
                                                    @endphp
                                                    <span
                                                        class="badge badge-sm {{ $orderGrowth3 >= 0 ? 'bg-gradient-success' : 'bg-gradient-danger' }}">
                                                        {{ $orderGrowth3 >= 0 ? '+' : '' }}{{ number_format($orderGrowth3, 1) }}%
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Customer Count</strong></td>
                                                <td class="text-center">
                                                    {{ count($comparisonData['current_year']['data']['customers']) }} vs
                                                    {{ count($comparisonData['previous_year']['data']['customers']) }}
                                                </td>
                                                <td class="text-center">
                                                    {{ count($comparisonData['current_year']['data']['customers']) }} vs
                                                    {{ count($comparisonData['two_years_ago']['data']['customers']) }}
                                                </td>
                                                <td class="text-center">
                                                    {{ count($comparisonData['previous_year']['data']['customers']) }} vs
                                                    {{ count($comparisonData['two_years_ago']['data']['customers']) }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
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

        <!-- Charts Row -->
        <div class="row">
            <!-- Pie Chart for Revenue Share -->
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Revenue Share by Customer - {{ $data['period']['from'] }} to {{ $data['period']['to'] }}</h6>
                        <p class="text-sm mb-0">Pie chart for revenue distribution</p>
                    </div>
                    <div class="card-body">
                        <canvas id="revenueChart" height="200"></canvas>
                    </div>
                </div>
            </div>

            <!-- Bar Chart for Volume Comparison -->
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Volume Comparison by Customer - {{ $data['period']['from'] }} to {{ $data['period']['to'] }}
                        </h6>
                        <p class="text-sm mb-0">Bar chart for volume comparison</p>
                    </div>
                    <div class="card-body">
                        <canvas id="volumeChart" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Business Metrics -->
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Customers</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $data['total_customers'] }}
                                        <span class="text-success text-sm font-weight-bolder">Customers</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                    <i class="material-symbols-rounded text-lg opacity-10" aria-hidden="true">people</i>
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
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Revenue</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ number_format($data['customers']->sum('total_revenue'), 2) }}
                                        <span
                                            class="text-success text-sm font-weight-bolder">{{ $data['currency'] }}</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                    <i class="material-symbols-rounded text-lg opacity-10"
                                        aria-hidden="true">account_balance</i>
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
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Volume</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ number_format($data['customers']->sum('total_volume')) }}
                                        <span class="text-success text-sm font-weight-bolder">Units</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
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
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Avg Lead Time</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ round($data['customers']->avg('avg_lead_time'), 1) }}
                                        <span class="text-success text-sm font-weight-bolder">Days</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-info shadow-info text-center rounded-circle">
                                    <i class="material-symbols-rounded text-lg opacity-10" aria-hidden="true">schedule</i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Performance Summary -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Customer Performance Summary</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <h6 class="text-sm font-weight-bold">Top Revenue Customer</h6>
                                <p class="text-sm">
                                    {{ $data['customers']->sortByDesc('total_revenue')->first()['customer_name'] }}
                                    ({{ number_format($data['customers']->sortByDesc('total_revenue')->first()['total_revenue'], 2) }}
                                    {{ $data['currency'] }})</p>
                            </div>
                            <div class="col-md-4">
                                <h6 class="text-sm font-weight-bold">Highest Volume Customer</h6>
                                <p class="text-sm">
                                    {{ $data['customers']->sortByDesc('total_volume')->first()['customer_name'] }}
                                    ({{ number_format($data['customers']->sortByDesc('total_volume')->first()['total_volume']) }}
                                    units)</p>
                            </div>
                            <div class="col-md-4">
                                <h6 class="text-sm font-weight-bold">Most Orders Customer</h6>
                                <p class="text-sm">
                                    {{ $data['customers']->sortByDesc('total_orders')->first()['customer_name'] }}
                                    ({{ $data['customers']->sortByDesc('total_orders')->first()['total_orders'] }} orders)
                                </p>
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
        // Revenue Pie Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'pie',
            data: {
                labels: @json($data['customers']->map(fn($c) => $c['customer_name'])),
                datasets: [{
                    data: @json($data['customers']->map(fn($c) => $c['total_revenue'])),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                        'rgba(255, 159, 64, 0.8)',
                        'rgba(199, 199, 199, 0.8)',
                        'rgba(83, 102, 255, 0.8)',
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    title: {
                        display: true,
                        text: 'Revenue Distribution'
                    }
                }
            }
        });

        // Volume Bar Chart
        const volumeCtx = document.getElementById('volumeChart').getContext('2d');
        new Chart(volumeCtx, {
            type: 'bar',
            data: {
                labels: @json($data['customers']->map(fn($c) => $c['customer_name'])),
                datasets: [{
                    label: 'Volume (Units)',
                    data: @json($data['customers']->map(fn($c) => $c['total_volume'])),
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
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
                            text: 'Volume (Units)'
                        }
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Customer Volume Comparison'
                    }
                }
            }
        });

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
                    label: 'Total Revenue ({{ $data['currency'] }})',
                    data: [
                        {{ $comparisonData['two_years_ago']['data']['customers']->sum('total_revenue') }},
                        {{ $comparisonData['previous_year']['data']['customers']->sum('total_revenue') }},
                        {{ $comparisonData['current_year']['data']['customers']->sum('total_revenue') }}
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
                            text: 'Revenue ({{ $data['currency'] }})'
                        }
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Revenue Comparison Chart'
                    }
                }
            }
        });
    </script>
@endpush
