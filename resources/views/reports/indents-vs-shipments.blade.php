@extends('layouts.app')

@section('title', 'Indents vs Shipments Report')

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
                        <form method="GET" action="{{ route('reports.indents-vs-shipments') }}" class="row g-3">
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
                                <a href="{{ route('reports.indents-vs-shipments') }}" class="btn btn-secondary">Reset</a>
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
                                <h6>Indents vs Shipments by Month Report</h6>
                                <p class="text-sm mb-0">
                                    <i class="fa fa-clock text-success" aria-hidden="true"></i>
                                    <span class="font-weight-bold">Purpose:</span> Track operational efficiency over time
                                </p>
                                <p class="text-sm mb-0">
                                    <span class="font-weight-bold">Period:</span> {{ $data['period']['from'] }} to
                                    {{ $data['period']['to'] }}
                                </p>
                            </div>
                            <div class="col-6 text-end">
                                <h6 class="text-sm font-weight-bold">Report Date: {{ $data['report_date'] }}</h6>
                                <h6 class="text-sm font-weight-bold">Total Months: {{ $data['total_months'] }}</h6>
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
                                            Month</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Current Period<br>
                                            <small class="text-xs">{{ $data['period']['from'] }} to
                                                {{ $data['period']['to'] }}</small><br>
                                            Total Indents
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Previous Year<br>
                                            <small class="text-xs">{{ $comparisonData['previous_year']['period']['from'] }}
                                                to {{ $comparisonData['previous_year']['period']['to'] }}</small><br>
                                            Total Indents
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Two Years Ago<br>
                                            <small class="text-xs">{{ $comparisonData['two_years_ago']['period']['from'] }}
                                                to {{ $comparisonData['two_years_ago']['period']['to'] }}</small><br>
                                            Total Indents
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
                                    @foreach ($data['monthly_data'] as $index => $month)
                                        @php
                                            $currentIndents = $month['total_indents'];
                                            $prevYearIndents =
                                                $comparisonData['previous_year']['data']['monthly_data'][$index][
                                                    'total_indents'
                                                ] ?? 0;
                                            $twoYearsAgoIndents =
                                                $comparisonData['two_years_ago']['data']['monthly_data'][$index][
                                                    'total_indents'
                                                ] ?? 0;

                                            $growthVsPY =
                                                $prevYearIndents > 0
                                                    ? (($currentIndents - $prevYearIndents) / $prevYearIndents) * 100
                                                    : 0;
                                            $growthVs2YA =
                                                $twoYearsAgoIndents > 0
                                                    ? (($currentIndents - $twoYearsAgoIndents) / $twoYearsAgoIndents) *
                                                        100
                                                    : 0;
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $month['month'] }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span
                                                    class="badge badge-sm bg-gradient-primary">{{ $currentIndents }}</span>
                                                <br>
                                                <small class="text-secondary">{{ $month['shipped_on_time'] }} on
                                                    time</small>
                                                <br>
                                                <small class="text-secondary">{{ $month['delayed_shipments'] }}
                                                    delayed</small>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span
                                                    class="badge badge-sm bg-gradient-success">{{ $prevYearIndents }}</span>
                                                <br>
                                                <small
                                                    class="text-secondary">{{ $comparisonData['previous_year']['data']['monthly_data'][$index]['shipped_on_time'] ?? 0 }}
                                                    on time</small>
                                                <br>
                                                <small
                                                    class="text-secondary">{{ $comparisonData['previous_year']['data']['monthly_data'][$index]['delayed_shipments'] ?? 0 }}
                                                    delayed</small>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span
                                                    class="badge badge-sm bg-gradient-info">{{ $twoYearsAgoIndents }}</span>
                                                <br>
                                                <small
                                                    class="text-secondary">{{ $comparisonData['two_years_ago']['data']['monthly_data'][$index]['shipped_on_time'] ?? 0 }}
                                                    on time</small>
                                                <br>
                                                <small
                                                    class="text-secondary">{{ $comparisonData['two_years_ago']['data']['monthly_data'][$index]['delayed_shipments'] ?? 0 }}
                                                    delayed</small>
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
                                        $currentTotalIndents = $data['monthly_data']->sum('total_indents');
                                        $prevYearTotalIndents = $comparisonData['previous_year']['data'][
                                            'monthly_data'
                                        ]->sum('total_indents');
                                        $twoYearsAgoTotalIndents = $comparisonData['two_years_ago']['data'][
                                            'monthly_data'
                                        ]->sum('total_indents');

                                        $totalGrowthVsPY =
                                            $prevYearTotalIndents > 0
                                                ? (($currentTotalIndents - $prevYearTotalIndents) /
                                                        $prevYearTotalIndents) *
                                                    100
                                                : 0;
                                        $totalGrowthVs2YA =
                                            $twoYearsAgoTotalIndents > 0
                                                ? (($currentTotalIndents - $twoYearsAgoTotalIndents) /
                                                        $twoYearsAgoTotalIndents) *
                                                    100
                                                : 0;
                                    @endphp
                                    <tr class="table-dark">
                                        <td class="align-middle">
                                            <strong class="text-white">TOTAL</strong>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="badge badge-sm bg-gradient-primary text-white font-weight-bold">{{ $currentTotalIndents }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="badge badge-sm bg-gradient-success text-white font-weight-bold">{{ $prevYearTotalIndents }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="badge badge-sm bg-gradient-info text-white font-weight-bold">{{ $twoYearsAgoTotalIndents }}</span>
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
                                                        {{ number_format($comparisonData['current_year']['data']['monthly_data']->sum('total_indents')) }}
                                                        <span class="text-white text-sm font-weight-bolder">Indents</span>
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
                                                        {{ number_format($comparisonData['previous_year']['data']['monthly_data']->sum('total_indents')) }}
                                                        <span class="text-white text-sm font-weight-bolder">Indents</span>
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
                                                        {{ number_format($comparisonData['two_years_ago']['data']['monthly_data']->sum('total_indents')) }}
                                                        <span class="text-white text-sm font-weight-bolder">Indents</span>
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

        <!-- Line Chart -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Operational Efficiency Trend</h6>
                        <p class="text-sm mb-0">Line graph for total indents vs shipped on time, with bar overlay for
                            delayed shipments</p>
                    </div>
                    <div class="card-body">
                        <canvas id="efficiencyChart" height="100"></canvas>
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
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Indents</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $data['monthly_data']->sum('total_indents') }}
                                        <span class="text-success text-sm font-weight-bolder">Orders</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
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
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Shipped on Time</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $data['monthly_data']->sum('shipped_on_time') }}
                                        <span class="text-success text-sm font-weight-bolder">Orders</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                    <i class="material-symbols-rounded text-lg opacity-10"
                                        aria-hidden="true">check_circle</i>
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
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Delayed Shipments</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $data['monthly_data']->sum('delayed_shipments') }}
                                        <span class="text-success text-sm font-weight-bolder">Orders</span>
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
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Avg On-Time %</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ round($data['monthly_data']->avg('on_time_percentage'), 1) }}%
                                        <span class="text-success text-sm font-weight-bolder">Performance</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-info shadow-info text-center rounded-circle">
                                    <i class="material-symbols-rounded text-lg opacity-10"
                                        aria-hidden="true">trending_up</i>
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
                            <div class="col-md-4">
                                <h6 class="text-sm font-weight-bold">Best Performing Month</h6>
                                <p class="text-sm">
                                    {{ $data['monthly_data']->sortByDesc('on_time_percentage')->first()['month'] }}
                                    ({{ $data['monthly_data']->sortByDesc('on_time_percentage')->first()['on_time_percentage'] }}%)
                                </p>
                            </div>
                            <div class="col-md-4">
                                <h6 class="text-sm font-weight-bold">Highest Volume Month</h6>
                                <p class="text-sm">
                                    {{ $data['monthly_data']->sortByDesc('total_indents')->first()['month'] }}
                                    ({{ $data['monthly_data']->sortByDesc('total_indents')->first()['total_indents'] }}
                                    indents)</p>
                            </div>
                            <div class="col-md-4">
                                <h6 class="text-sm font-weight-bold">Most Delayed Month</h6>
                                <p class="text-sm">
                                    {{ $data['monthly_data']->sortByDesc('delayed_shipments')->first()['month'] }}
                                    ({{ $data['monthly_data']->sortByDesc('delayed_shipments')->first()['delayed_shipments'] }}
                                    delays)</p>
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
                    label: 'Total Indents',
                    data: [
                        {{ $comparisonData['two_years_ago']['data']['monthly_data']->sum('total_indents') }},
                        {{ $comparisonData['previous_year']['data']['monthly_data']->sum('total_indents') }},
                        {{ $comparisonData['current_year']['data']['monthly_data']->sum('total_indents') }}
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
                            text: 'Total Indents'
                        }
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Indents Comparison Chart'
                    }
                }
            }
        });
    </script>

    <script>
        // Efficiency Chart
        const efficiencyCtx = document.getElementById('efficiencyChart').getContext('2d');
        new Chart(efficiencyCtx, {
            type: 'line',
            data: {
                labels: @json($data['monthly_data']->map(fn($m) => $m['month'])),
                datasets: [{
                    label: 'Total Indents',
                    data: @json($data['monthly_data']->map(fn($m) => $m['total_indents'])),
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.1,
                    fill: false
                }, {
                    label: 'Shipped on Time',
                    data: @json($data['monthly_data']->map(fn($m) => $m['shipped_on_time'])),
                    borderColor: 'rgb(34, 197, 94)',
                    backgroundColor: 'rgba(34, 197, 94, 0.2)',
                    tension: 0.1,
                    fill: false
                }, {
                    label: 'Delayed Shipments',
                    data: @json($data['monthly_data']->map(fn($m) => $m['delayed_shipments'])),
                    type: 'bar',
                    backgroundColor: 'rgba(255, 193, 7, 0.6)',
                    borderColor: 'rgba(255, 193, 7, 1)',
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
                            text: 'Number of Orders'
                        }
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Monthly Operational Efficiency'
                    }
                }
            }
        });
    </script>
@endpush
