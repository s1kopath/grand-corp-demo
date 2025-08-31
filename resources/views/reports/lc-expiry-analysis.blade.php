@extends('layouts.app')

@section('title', 'L/C Expiry Analysis Report')

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
                        <form method="GET" action="{{ route('reports.lc-expiry-analysis') }}" class="row g-3">
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
                                <a href="{{ route('reports.lc-expiry-analysis') }}" class="btn btn-secondary">Reset</a>
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
                                <h6>L/C Expiry Analysis Report</h6>
                                <p class="text-sm mb-0">
                                    <i class="fa fa-clock text-success" aria-hidden="true"></i>
                                    <span class="font-weight-bold">Purpose:</span> Track all letters of credit and upcoming
                                    expiries
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
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">L/C
                                            No</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Customer</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Principal</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Current Period<br>
                                            <small class="text-xs">{{ $data['period']['from'] }} to
                                                {{ $data['period']['to'] }}</small><br>
                                            Amount ({{ $data['currency'] }})
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Previous Year<br>
                                            <small class="text-xs">{{ $comparisonData['previous_year']['period']['from'] }}
                                                to {{ $comparisonData['previous_year']['period']['to'] }}</small><br>
                                            Amount ({{ $data['currency'] }})
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Two Years Ago<br>
                                            <small class="text-xs">{{ $comparisonData['two_years_ago']['period']['from'] }}
                                                to {{ $comparisonData['two_years_ago']['period']['to'] }}</small><br>
                                            Amount ({{ $data['currency'] }})
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
                                    @foreach ($data['lcs'] as $index => $lc)
                                        @php
                                            $currentAmount = $lc['amount'];
                                            $prevYearAmount =
                                                $comparisonData['previous_year']['data']['lcs'][$index]['amount'] ?? 0;
                                            $twoYearsAgoAmount =
                                                $comparisonData['two_years_ago']['data']['lcs'][$index]['amount'] ?? 0;

                                            $growthVsPY =
                                                $prevYearAmount > 0
                                                    ? (($currentAmount - $prevYearAmount) / $prevYearAmount) * 100
                                                    : 0;
                                            $growthVs2YA =
                                                $twoYearsAgoAmount > 0
                                                    ? (($currentAmount - $twoYearsAgoAmount) / $twoYearsAgoAmount) * 100
                                                    : 0;
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $lc['lc_number'] }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $lc['customer'] }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $lc['principal'] }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span
                                                    class="badge badge-sm bg-gradient-primary">{{ number_format($currentAmount, 2) }}</span>
                                                <br>
                                                <small class="text-secondary">{{ $lc['issue_date'] }} -
                                                    {{ $lc['expiry_date'] }}</small>
                                                <br>
                                                <small class="text-secondary">{{ $lc['days_remaining'] }} days
                                                    remaining</small>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span
                                                    class="badge badge-sm bg-gradient-success">{{ number_format($prevYearAmount, 2) }}</span>
                                                <br>
                                                <small
                                                    class="text-secondary">{{ $comparisonData['previous_year']['data']['lcs'][$index]['issue_date'] ?? 'N/A' }}
                                                    -
                                                    {{ $comparisonData['previous_year']['data']['lcs'][$index]['expiry_date'] ?? 'N/A' }}</small>
                                                <br>
                                                <small
                                                    class="text-secondary">{{ $comparisonData['previous_year']['data']['lcs'][$index]['days_remaining'] ?? 0 }}
                                                    days remaining</small>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span
                                                    class="badge badge-sm bg-gradient-info">{{ number_format($twoYearsAgoAmount, 2) }}</span>
                                                <br>
                                                <small
                                                    class="text-secondary">{{ $comparisonData['two_years_ago']['data']['lcs'][$index]['issue_date'] ?? 'N/A' }}
                                                    -
                                                    {{ $comparisonData['two_years_ago']['data']['lcs'][$index]['expiry_date'] ?? 'N/A' }}</small>
                                                <br>
                                                <small
                                                    class="text-secondary">{{ $comparisonData['two_years_ago']['data']['lcs'][$index]['days_remaining'] ?? 0 }}
                                                    days remaining</small>
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
                                        $currentTotalAmount = $data['lcs']->sum('amount');
                                        $prevYearTotalAmount = $comparisonData['previous_year']['data']['lcs']->sum(
                                            'amount',
                                        );
                                        $twoYearsAgoTotalAmount = $comparisonData['two_years_ago']['data']['lcs']->sum(
                                            'amount',
                                        );

                                        $totalGrowthVsPY =
                                            $prevYearTotalAmount > 0
                                                ? (($currentTotalAmount - $prevYearTotalAmount) /
                                                        $prevYearTotalAmount) *
                                                    100
                                                : 0;
                                        $totalGrowthVs2YA =
                                            $twoYearsAgoTotalAmount > 0
                                                ? (($currentTotalAmount - $twoYearsAgoTotalAmount) /
                                                        $twoYearsAgoTotalAmount) *
                                                    100
                                                : 0;
                                    @endphp
                                    <tr class="table-dark">
                                        <td class="align-middle">
                                            <strong class="text-white">TOTAL</strong>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="badge badge-sm bg-gradient-info text-white font-weight-bold">All
                                                Customers</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="badge badge-sm bg-gradient-info text-white font-weight-bold">All
                                                Principals</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="badge badge-sm bg-gradient-primary text-white font-weight-bold">{{ number_format($currentTotalAmount, 2) }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="badge badge-sm bg-gradient-success text-white font-weight-bold">{{ number_format($prevYearTotalAmount, 2) }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="badge badge-sm bg-gradient-info text-white font-weight-bold">{{ number_format($twoYearsAgoTotalAmount, 2) }}</span>
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
                                                        {{ number_format($comparisonData['current_year']['data']['lcs']->sum('amount'), 2) }}
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
                                                        {{ number_format($comparisonData['previous_year']['data']['lcs']->sum('amount'), 2) }}
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
                                                        {{ number_format($comparisonData['two_years_ago']['data']['lcs']->sum('amount'), 2) }}
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

        <!-- Expiry Countdown Chart -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>L/C Expiry Countdown</h6>
                        <p class="text-sm mb-0">Countdown bar or color-coded expiry alert (green/yellow/red)</p>
                    </div>
                    <div class="card-body">
                        <canvas id="expiryChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- L/C Status Metrics -->
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total L/Cs</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $data['total_lcs'] }}
                                        <span class="text-success text-sm font-weight-bolder">Letters</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                    <i class="material-symbols-rounded text-lg opacity-10"
                                        aria-hidden="true">description</i>
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
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Active L/Cs</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $data['active_lcs'] }}
                                        <span class="text-success text-sm font-weight-bolder">Letters</span>
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
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Expired L/Cs</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $data['expired_lcs'] }}
                                        <span class="text-success text-sm font-weight-bolder">Letters</span>
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
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Amount</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ number_format($data['lcs']->sum('amount'), 2) }}
                                        <span
                                            class="text-success text-sm font-weight-bolder">{{ $data['currency'] }}</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-info shadow-info text-center rounded-circle">
                                    <i class="material-symbols-rounded text-lg opacity-10"
                                        aria-hidden="true">account_balance</i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Expiry Risk Summary -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Expiry Risk Summary</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <h6 class="text-sm font-weight-bold">Critical (< 7 days)</h6>
                                        <p class="text-sm">
                                            {{ $data['lcs']->where('days_remaining', '>', 0)->where('days_remaining', '<', 7)->count() }}
                                            L/Cs</p>
                            </div>
                            <div class="col-md-3">
                                <h6 class="text-sm font-weight-bold">Warning (7-30 days)</h6>
                                <p class="text-sm">
                                    {{ $data['lcs']->where('days_remaining', '>=', 7)->where('days_remaining', '<=', 30)->count() }}
                                    L/Cs</p>
                            </div>
                            <div class="col-md-3">
                                <h6 class="text-sm font-weight-bold">Safe (> 30 days)</h6>
                                <p class="text-sm">{{ $data['lcs']->where('days_remaining', '>', 30)->count() }} L/Cs</p>
                            </div>
                            <div class="col-md-3">
                                <h6 class="text-sm font-weight-bold">Expired</h6>
                                <p class="text-sm">{{ $data['lcs']->where('days_remaining', '<=', 0)->count() }} L/Cs</p>
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
                    label: 'Total L/C Amount ({{ $data['currency'] }})',
                    data: [
                        {{ $comparisonData['two_years_ago']['data']['lcs']->sum('amount') }},
                        {{ $comparisonData['previous_year']['data']['lcs']->sum('amount') }},
                        {{ $comparisonData['current_year']['data']['lcs']->sum('amount') }}
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
                            text: 'L/C Amount ({{ $data['currency'] }})'
                        }
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'L/C Amount Comparison Chart'
                    }
                }
            }
        });
    </script>

    <script>
        // Expiry Chart
        const expiryCtx = document.getElementById('expiryChart').getContext('2d');
        new Chart(expiryCtx, {
            type: 'bar',
            data: {
                labels: @json($data['lcs']->map(fn($l) => $l['lc_number'])),
                datasets: [{
                    label: 'Days Remaining',
                    data: @json($data['lcs']->map(fn($l) => $l['days_remaining'])),
                    backgroundColor: [
                        'rgba(34, 197, 94, 0.8)', // Green for >30 days
                        'rgba(34, 197, 94, 0.8)', // Green for >30 days
                        'rgba(34, 197, 94, 0.8)', // Green for >30 days
                        'rgba(34, 197, 94, 0.8)', // Green for >30 days
                        'rgba(34, 197, 94, 0.8)', // Green for >30 days
                        'rgba(34, 197, 94, 0.8)', // Green for >30 days
                        'rgba(34, 197, 94, 0.8)', // Green for >30 days
                        'rgba(34, 197, 94, 0.8)', // Green for >30 days
                        'rgba(34, 197, 94, 0.8)', // Green for >30 days
                        'rgba(34, 197, 94, 0.8)' // Green for >30 days
                    ],
                    borderColor: [
                        'rgba(34, 197, 94, 1)',
                        'rgba(34, 197, 94, 1)',
                        'rgba(34, 197, 94, 1)',
                        'rgba(34, 197, 94, 1)',
                        'rgba(34, 197, 94, 1)',
                        'rgba(34, 197, 94, 1)',
                        'rgba(34, 197, 94, 1)',
                        'rgba(34, 197, 94, 1)',
                        'rgba(34, 197, 94, 1)',
                        'rgba(34, 197, 94, 1)'
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
                            text: 'Days Remaining'
                        }
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'L/C Expiry Countdown'
                    },
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
@endpush
