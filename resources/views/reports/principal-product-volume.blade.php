@extends('layouts.app')

@section('title', 'Principal-wise Product Volume Report')

@section('content')
    <div class="container-fluid py-4">
        <!-- Date Filter Form -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Date Range Filter</h6>
                        <p class="text-sm mb-0">Select date range to analyze principal product volume data</p>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('reports.principal-product-volume') }}" class="row g-3">
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
                                <a href="{{ route('reports.principal-product-volume') }}" class="btn btn-secondary">
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
                                <h6>Principal-wise Product Volume Report</h6>
                                <p class="text-sm mb-0">
                                    <i class="fa fa-clock text-success" aria-hidden="true"></i>
                                    <span class="font-weight-bold">Purpose:</span> Show which foreign suppliers' products
                                    are performing best
                                </p>
                                <p class="text-sm mb-0">
                                    <span class="font-weight-bold">Period:</span> {{ $data['period']['from'] }} to
                                    {{ $data['period']['to'] }}
                                </p>
                            </div>
                            <div class="col-6 text-end">
                                <h6 class="text-sm font-weight-bold">Report Date: {{ $data['report_date'] }}</h6>
                                <h6 class="text-sm font-weight-bold">Total Principals: {{ $data['total_principals'] }}</h6>
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
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Principal Name</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Current Period<br>
                                            <small class="text-xs">{{ $data['period']['from'] }} to
                                                {{ $data['period']['to'] }}</small>
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Previous Year<br>
                                            <small class="text-xs">{{ $comparisonData['previous_year']['period']['from'] }}
                                                to {{ $comparisonData['previous_year']['period']['to'] }}</small>
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Two Years Ago<br>
                                            <small class="text-xs">{{ $comparisonData['two_years_ago']['period']['from'] }}
                                                to {{ $comparisonData['two_years_ago']['period']['to'] }}</small>
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
                                    @foreach ($data['principals'] as $index => $principal)
                                        @php
                                            $currentIndentVolume = $principal['total_indent_volume'];
                                            $prevYearIndentVolume =
                                                $comparisonData['previous_year']['data']['principals'][$index][
                                                    'total_indent_volume'
                                                ] ?? 0;
                                            $twoYearsAgoIndentVolume =
                                                $comparisonData['two_years_ago']['data']['principals'][$index][
                                                    'total_indent_volume'
                                                ] ?? 0;

                                            $growthVsPY =
                                                $prevYearIndentVolume > 0
                                                    ? (($currentIndentVolume - $prevYearIndentVolume) /
                                                            $prevYearIndentVolume) *
                                                        100
                                                    : 0;
                                            $growthVs2YA =
                                                $twoYearsAgoIndentVolume > 0
                                                    ? (($currentIndentVolume - $twoYearsAgoIndentVolume) /
                                                            $twoYearsAgoIndentVolume) *
                                                        100
                                                    : 0;
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $principal['principal_name'] }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span
                                                    class="badge badge-sm bg-gradient-primary">{{ number_format($currentIndentVolume) }}
                                                    units</span>
                                                <br>
                                                <small class="text-secondary">{{ $principal['product_count'] }}
                                                    products</small>
                                                <br>
                                                <small
                                                    class="text-secondary">{{ $principal['shipped_on_time_percentage'] }}%
                                                    on-time</small>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span
                                                    class="badge badge-sm bg-gradient-success">{{ number_format($prevYearIndentVolume) }}
                                                    units</span>
                                                <br>
                                                <small
                                                    class="text-secondary">{{ $comparisonData['previous_year']['data']['principals'][$index]['product_count'] ?? 0 }}
                                                    products</small>
                                                <br>
                                                <small
                                                    class="text-secondary">{{ $comparisonData['previous_year']['data']['principals'][$index]['shipped_on_time_percentage'] ?? 0 }}%
                                                    on-time</small>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span
                                                    class="badge badge-sm bg-gradient-info">{{ number_format($twoYearsAgoIndentVolume) }}
                                                    units</span>
                                                <br>
                                                <small
                                                    class="text-secondary">{{ $comparisonData['two_years_ago']['data']['principals'][$index]['product_count'] ?? 0 }}
                                                    products</small>
                                                <br>
                                                <small
                                                    class="text-secondary">{{ $comparisonData['two_years_ago']['data']['principals'][$index]['shipped_on_time_percentage'] ?? 0 }}%
                                                    on-time</small>
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
                                        $currentTotalIndent = $data['principals']->sum('total_indent_volume');
                                        $prevYearTotalIndent = $comparisonData['previous_year']['data'][
                                            'principals'
                                        ]->sum('total_indent_volume');
                                        $twoYearsAgoTotalIndent = $comparisonData['two_years_ago']['data'][
                                            'principals'
                                        ]->sum('total_indent_volume');

                                        $totalGrowthVsPY =
                                            $prevYearTotalIndent > 0
                                                ? (($currentTotalIndent - $prevYearTotalIndent) /
                                                        $prevYearTotalIndent) *
                                                    100
                                                : 0;
                                        $totalGrowthVs2YA =
                                            $twoYearsAgoTotalIndent > 0
                                                ? (($currentTotalIndent - $twoYearsAgoTotalIndent) /
                                                        $twoYearsAgoTotalIndent) *
                                                    100
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
                                        <td class="align-middle text-center text-sm">
                                            <span class="badge badge-sm bg-gradient-primary text-white font-weight-bold">
                                                {{ number_format($currentTotalIndent) }} units
                                            </span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="badge badge-sm bg-gradient-success text-white font-weight-bold">
                                                {{ number_format($prevYearTotalIndent) }} units
                                            </span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="badge badge-sm bg-gradient-info text-white font-weight-bold">
                                                {{ number_format($twoYearsAgoTotalIndent) }} units
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

        <!-- Stacked Bar Chart -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Product Volume Comparison - Indent vs Shipment</h6>
                        <p class="text-sm mb-0">Stacked bar chart showing volume performance per principal for selected
                            period</p>
                    </div>
                    <div class="card-body">
                        <canvas id="volumeChart" height="100"></canvas>
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
                        <p class="text-sm mb-0">Compare volume performance across the last 3 years for the same period</p>
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
                                                        {{ number_format($comparisonData['current_year']['data']['principals']->sum('total_indent_volume')) }}
                                                        <span class="text-white text-sm font-weight-bolder">Units</span>
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
                                                        {{ number_format($comparisonData['previous_year']['data']['principals']->sum('total_indent_volume')) }}
                                                        <span class="text-white text-sm font-weight-bolder">Units</span>
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
                                                        {{ number_format($comparisonData['two_years_ago']['data']['principals']->sum('total_indent_volume')) }}
                                                        <span class="text-white text-sm font-weight-bolder">Units</span>
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
                                                <td><strong>Volume Growth</strong></td>
                                                <td class="text-center">
                                                    @php
                                                        $currentVolume = $comparisonData['current_year']['data'][
                                                            'principals'
                                                        ]->sum('total_indent_volume');
                                                        $prevVolume = $comparisonData['previous_year']['data'][
                                                            'principals'
                                                        ]->sum('total_indent_volume');
                                                        $growth =
                                                            $prevVolume > 0
                                                                ? (($currentVolume - $prevVolume) / $prevVolume) * 100
                                                                : 0;
                                                    @endphp
                                                    <span
                                                        class="badge badge-sm {{ $growth >= 0 ? 'bg-gradient-success' : 'bg-gradient-danger' }}">
                                                        {{ $growth >= 0 ? '+' : '' }}{{ number_format($growth, 1) }}%
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    @php
                                                        $twoYearsVolume = $comparisonData['two_years_ago']['data'][
                                                            'principals'
                                                        ]->sum('total_indent_volume');
                                                        $growth2 =
                                                            $twoYearsVolume > 0
                                                                ? (($currentVolume - $twoYearsVolume) /
                                                                        $twoYearsVolume) *
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
                                                            $twoYearsVolume > 0
                                                                ? (($prevVolume - $twoYearsVolume) / $twoYearsVolume) *
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
                                                <td><strong>Principal Count</strong></td>
                                                <td class="text-center">
                                                    {{ count($comparisonData['current_year']['data']['principals']) }} vs
                                                    {{ count($comparisonData['previous_year']['data']['principals']) }}
                                                </td>
                                                <td class="text-center">
                                                    {{ count($comparisonData['current_year']['data']['principals']) }} vs
                                                    {{ count($comparisonData['two_years_ago']['data']['principals']) }}
                                                </td>
                                                <td class="text-center">
                                                    {{ count($comparisonData['previous_year']['data']['principals']) }} vs
                                                    {{ count($comparisonData['two_years_ago']['data']['principals']) }}
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
                        <h6>Volume Comparison Chart</h6>
                        <p class="text-sm mb-0">Visual comparison of total volume across the last 3 years</p>
                    </div>
                    <div class="card-body">
                        <canvas id="comparisonChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Metrics -->
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Principals</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $data['total_principals'] }}
                                        <span class="text-success text-sm font-weight-bolder">Suppliers</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                    <i class="material-symbols-rounded text-lg opacity-10" aria-hidden="true">business</i>
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
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Products</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $data['principals']->sum('product_count') }}
                                        <span class="text-success text-sm font-weight-bolder">Products</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
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
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Indent Volume</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ number_format($data['principals']->sum('total_indent_volume')) }}
                                        <span class="text-success text-sm font-weight-bolder">Units</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
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
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Avg On-Time %</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ round($data['principals']->avg('shipped_on_time_percentage'), 1) }}%
                                        <span class="text-success text-sm font-weight-bolder">Performance</span>
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

        <!-- Performance Summary -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Performance Summary</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-sm font-weight-bold">Top Performers (≥95% On-Time)</h6>
                                <p class="text-sm">
                                    {{ $data['principals']->where('shipped_on_time_percentage', '>=', 95)->count() }}
                                    principals</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-sm font-weight-bold">Needs Improvement (<90% On-Time)</h6>
                                        <p class="text-sm">
                                            {{ $data['principals']->where('shipped_on_time_percentage', '<', 90)->count() }}
                                            principals</p>
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
        // Volume Chart
        const volumeCtx = document.getElementById('volumeChart').getContext('2d');
        new Chart(volumeCtx, {
            type: 'bar',
            data: {
                labels: @json($data['principals']->map(fn($p) => $p['principal_name'])),
                datasets: [{
                    label: 'Indent Volume',
                    data: @json($data['principals']->map(fn($p) => $p['total_indent_volume'])),
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }, {
                    label: 'Shipment Volume',
                    data: @json($data['principals']->map(fn($p) => $p['total_shipment_volume'])),
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        stacked: true,
                        title: {
                            display: true,
                            text: 'Volume (Units)'
                        }
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Principal-wise Product Volume Analysis ({{ $data['period']['from'] }} to {{ $data['period']['to'] }})'
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
                    label: 'Total Indent Volume (Units)',
                    data: [
                        {{ $comparisonData['two_years_ago']['data']['principals']->sum('total_indent_volume') }},
                        {{ $comparisonData['previous_year']['data']['principals']->sum('total_indent_volume') }},
                        {{ $comparisonData['current_year']['data']['principals']->sum('total_indent_volume') }}
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
                            text: 'Volume (Units)'
                        }
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Year-over-Year Volume Comparison'
                    }
                }
            }
        });
    </script>
@endpush
