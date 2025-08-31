@extends('layouts.app')

@section('title', '80/20 Analysis Report')

@section('content')
    <div class="container-fluid py-4">
        <!-- Date Filter Form -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Date Range Filter</h6>
                        <p class="text-sm mb-0">Select date range to analyze customer revenue data</p>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('reports.pareto-analysis') }}" class="row g-3">
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
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="fa fa-search me-1"></i> Generate Report
                                </button>
                                <a href="{{ route('reports.pareto-analysis') }}" class="btn btn-secondary">
                                    <i class="fa fa-refresh me-1"></i> Reset
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Current Period Report -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-6">
                                <h6>80/20 Analysis Report</h6>
                                <p class="text-sm mb-0">
                                    <i class="fa fa-clock text-success" aria-hidden="true"></i>
                                    <span class="font-weight-bold">Purpose:</span> Identify top customers that generate 80%
                                    of business
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
                                        <small class="text-secondary">Positive Growth</small>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="badge badge-sm bg-gradient-danger me-2"></span>
                                        <small class="text-secondary">Negative Growth</small>
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
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Rank
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Customer</th>
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
                                    @foreach ($data['pareto_data'] as $index => $item)
                                        @php
                                            $currentRevenue = $item['total_value'];
                                            $prevYearRevenue =
                                                $comparisonData['previous_year']['data']['pareto_data'][$index][
                                                    'total_value'
                                                ] ?? 0;
                                            $twoYearsAgoRevenue =
                                                $comparisonData['two_years_ago']['data']['pareto_data'][$index][
                                                    'total_value'
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
                                                        <h6 class="mb-0 text-sm">{{ $item['rank'] }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $item['name'] }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span
                                                    class="badge badge-sm bg-gradient-primary">{{ number_format($currentRevenue, 2) }}</span>
                                                <br>
                                                <small class="text-secondary">{{ $item['percentage'] }}%</small>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span
                                                    class="badge badge-sm bg-gradient-success">{{ number_format($prevYearRevenue, 2) }}</span>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span
                                                    class="badge badge-sm bg-gradient-info">{{ number_format($twoYearsAgoRevenue, 2) }}</span>
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
                                        $currentTotal = $data['total_revenue'];
                                        $prevYearTotal = $comparisonData['previous_year']['data']['total_revenue'];
                                        $twoYearsAgoTotal = $comparisonData['two_years_ago']['data']['total_revenue'];

                                        $totalGrowthVsPY =
                                            $prevYearTotal > 0
                                                ? (($currentTotal - $prevYearTotal) / $prevYearTotal) * 100
                                                : 0;
                                        $totalGrowthVs2YA =
                                            $twoYearsAgoTotal > 0
                                                ? (($currentTotal - $twoYearsAgoTotal) / $twoYearsAgoTotal) * 100
                                                : 0;
                                    @endphp
                                    <tr class="table-dark">
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm text-white font-weight-bold">TOTAL</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0 text-white">All Customers</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="badge badge-sm bg-gradient-primary text-white font-weight-bold">
                                                {{ number_format($currentTotal, 2) }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="badge badge-sm bg-gradient-success text-white font-weight-bold">
                                                {{ number_format($prevYearTotal, 2) }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="badge badge-sm bg-gradient-info text-white font-weight-bold">
                                                {{ number_format($twoYearsAgoTotal, 2) }}
                                            </span>
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

        <!-- Pareto Chart -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Pareto Chart - Customer Revenue vs Cumulative %</h6>
                        <p class="text-sm mb-0">Visual representation of 80/20 principle for selected period</p>
                    </div>
                    <div class="card-body">
                        <canvas id="paretoChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Revenue</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ number_format($data['total_revenue'], 2) }}
                                        <span class="text-success text-sm font-weight-bolder">BDT</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
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
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Top 20% Revenue</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ number_format($data['total_revenue'] * 0.8, 2) }}
                                        <span class="text-success text-sm font-weight-bolder">BDT</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                    <i class="material-symbols-rounded text-lg opacity-10"
                                        aria-hidden="true">trending_up</i>
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
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Customers Analyzed</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ count($data['pareto_data']) }}
                                        <span class="text-success text-sm font-weight-bolder">Customers</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
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
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">80% Threshold</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $data['pareto_data']->where('cumulative_percentage', '<=', 80)->count() }}
                                        <span class="text-success text-sm font-weight-bolder">Customers</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-info shadow-info text-center rounded-circle">
                                    <i class="material-symbols-rounded text-lg opacity-10"
                                        aria-hidden="true">analytics</i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Year-over-Year Comparison -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Year-over-Year Comparison</h6>
                        <p class="text-sm mb-0">Compare revenue performance across the last 3 years for the same period</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Current Year -->
                            <div class="col-md-4">
                                <div class="card bg-gradient-primary text-white">
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="numbers">
                                                    <p class="text-sm mb-0 text-white">Current Year
                                                        ({{ $comparisonData['current_year']['year'] }})</p>
                                                    <h5 class="font-weight-bolder mb-0 text-white">
                                                        {{ number_format($comparisonData['current_year']['data']['total_revenue'], 2) }}
                                                        <span class="text-white text-sm font-weight-bolder">BDT</span>
                                                    </h5>
                                                    <p class="text-xs mb-0 text-white">
                                                        {{ $comparisonData['current_year']['period']['from'] }} -
                                                        {{ $comparisonData['current_year']['period']['to'] }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-4 text-end">
                                                <div class="icon icon-shape bg-white shadow text-center rounded-circle">
                                                    <i class="material-symbols-rounded text-lg text-primary opacity-10"
                                                        aria-hidden="true">trending_up</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Previous Year -->
                            <div class="col-md-4">
                                <div class="card bg-gradient-success text-white">
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="numbers">
                                                    <p class="text-sm mb-0 text-white">Previous Year
                                                        ({{ $comparisonData['previous_year']['year'] }})</p>
                                                    <h5 class="font-weight-bolder mb-0 text-white">
                                                        {{ number_format($comparisonData['previous_year']['data']['total_revenue'], 2) }}
                                                        <span class="text-white text-sm font-weight-bolder">BDT</span>
                                                    </h5>
                                                    <p class="text-xs mb-0 text-white">
                                                        {{ $comparisonData['previous_year']['period']['from'] }} -
                                                        {{ $comparisonData['previous_year']['period']['to'] }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-4 text-end">
                                                <div class="icon icon-shape bg-white shadow text-center rounded-circle">
                                                    <i class="material-symbols-rounded text-lg text-success opacity-10"
                                                        aria-hidden="true">compare</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Two Years Ago -->
                            <div class="col-md-4">
                                <div class="card bg-gradient-info text-white">
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="numbers">
                                                    <p class="text-sm mb-0 text-white">Two Years Ago
                                                        ({{ $comparisonData['two_years_ago']['year'] }})</p>
                                                    <h5 class="font-weight-bolder mb-0 text-white">
                                                        {{ number_format($comparisonData['two_years_ago']['data']['total_revenue'], 2) }}
                                                        <span class="text-white text-sm font-weight-bolder">BDT</span>
                                                    </h5>
                                                    <p class="text-xs mb-0 text-white">
                                                        {{ $comparisonData['two_years_ago']['period']['from'] }} -
                                                        {{ $comparisonData['two_years_ago']['period']['to'] }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-4 text-end">
                                                <div class="icon icon-shape bg-white shadow text-center rounded-circle">
                                                    <i class="material-symbols-rounded text-lg text-info opacity-10"
                                                        aria-hidden="true">history</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Growth Metrics -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Metric</th>
                                                <th class="text-center">Current vs Previous Year</th>
                                                <th class="text-center">Current vs Two Years Ago</th>
                                                <th class="text-center">Previous vs Two Years Ago</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong>Revenue Growth</strong></td>
                                                <td class="text-center">
                                                    @php
                                                        $currentRevenue =
                                                            $comparisonData['current_year']['data']['total_revenue'];
                                                        $prevRevenue =
                                                            $comparisonData['previous_year']['data']['total_revenue'];
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
                                                        $twoYearsRevenue =
                                                            $comparisonData['two_years_ago']['data']['total_revenue'];
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
                                                <td><strong>Top Customer Count</strong></td>
                                                <td class="text-center">
                                                    {{ count($comparisonData['current_year']['data']['pareto_data']) }} vs
                                                    {{ count($comparisonData['previous_year']['data']['pareto_data']) }}
                                                </td>
                                                <td class="text-center">
                                                    {{ count($comparisonData['current_year']['data']['pareto_data']) }} vs
                                                    {{ count($comparisonData['two_years_ago']['data']['pareto_data']) }}
                                                </td>
                                                <td class="text-center">
                                                    {{ count($comparisonData['previous_year']['data']['pareto_data']) }} vs
                                                    {{ count($comparisonData['two_years_ago']['data']['pareto_data']) }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
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
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Revenue Comparison Chart</h6>
                        <p class="text-sm mb-0">Visual comparison of revenue across the last 3 years</p>
                    </div>
                    <div class="card-body">
                        <canvas id="comparisonChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Pareto Chart
        const paretoCtx = document.getElementById('paretoChart').getContext('2d');
        new Chart(paretoCtx, {
            type: 'bar',
            data: {
                labels: @json($data['pareto_data']->map(fn($p) => $p['name'])),
                datasets: [{
                    label: 'Revenue (BDT)',
                    data: @json($data['pareto_data']->map(fn($p) => $p['total_value'])),
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    yAxisID: 'y'
                }, {
                    label: 'Cumulative %',
                    data: @json($data['pareto_data']->map(fn($p) => $p['cumulative_percentage'])),
                    type: 'line',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderWidth: 2,
                    fill: false,
                    yAxisID: 'y1'
                }]
            },
            options: {
                responsive: true,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Revenue (BDT)'
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Cumulative %'
                        },
                        grid: {
                            drawOnChartArea: false,
                        },
                        max: 100
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Pareto Chart - 80/20 Analysis ({{ $data['period']['from'] }} to {{ $data['period']['to'] }})'
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
                    label: 'Total Revenue (BDT)',
                    data: [
                        {{ $comparisonData['two_years_ago']['data']['total_revenue'] }},
                        {{ $comparisonData['previous_year']['data']['total_revenue'] }},
                        {{ $comparisonData['current_year']['data']['total_revenue'] }}
                    ],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(255, 99, 132, 0.6)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)'
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
                            text: 'Revenue (BDT)'
                        }
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Year-over-Year Revenue Comparison'
                    }
                }
            }
        });
    </script>
@endpush
