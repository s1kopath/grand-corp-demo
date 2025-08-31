@extends('layouts.app')

@section('title', 'Outstanding Payments Report')

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
                        <form method="GET" action="{{ route('reports.outstanding-payments') }}" class="row g-3">
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
                                <a href="{{ route('reports.outstanding-payments') }}" class="btn btn-secondary">Reset</a>
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
                                <h6>Outstanding Payments by Customer Report</h6>
                                <p class="text-sm mb-0">
                                    <i class="fa fa-clock text-success" aria-hidden="true"></i>
                                    <span class="font-weight-bold">Purpose:</span> Track receivables and overdue payments
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
                                            Outstanding ({{ $data['currency'] }})
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Previous Year<br>
                                            <small class="text-xs">{{ $comparisonData['previous_year']['period']['from'] }}
                                                to {{ $comparisonData['previous_year']['period']['to'] }}</small><br>
                                            Outstanding ({{ $data['currency'] }})
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Two Years Ago<br>
                                            <small class="text-xs">{{ $comparisonData['two_years_ago']['period']['from'] }}
                                                to {{ $comparisonData['two_years_ago']['period']['to'] }}</small><br>
                                            Outstanding ({{ $data['currency'] }})
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
                                            $currentOutstanding = $customer['outstanding_amount'];
                                            $prevYearOutstanding =
                                                $comparisonData['previous_year']['data']['customers'][$index][
                                                    'outstanding_amount'
                                                ] ?? 0;
                                            $twoYearsAgoOutstanding =
                                                $comparisonData['two_years_ago']['data']['customers'][$index][
                                                    'outstanding_amount'
                                                ] ?? 0;

                                            $growthVsPY =
                                                $prevYearOutstanding > 0
                                                    ? (($currentOutstanding - $prevYearOutstanding) /
                                                            $prevYearOutstanding) *
                                                        100
                                                    : 0;
                                            $growthVs2YA =
                                                $twoYearsAgoOutstanding > 0
                                                    ? (($currentOutstanding - $twoYearsAgoOutstanding) /
                                                            $twoYearsAgoOutstanding) *
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
                                                    class="badge badge-sm bg-gradient-primary">{{ number_format($currentOutstanding, 2) }}</span>
                                                <br>
                                                <small
                                                    class="text-secondary">{{ number_format($customer['total_amount_billed'], 2) }}
                                                    billed</small>
                                                <br>
                                                <small
                                                    class="text-secondary">{{ number_format($customer['amount_paid'], 2) }}
                                                    paid</small>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span
                                                    class="badge badge-sm bg-gradient-success">{{ number_format($prevYearOutstanding, 2) }}</span>
                                                <br>
                                                <small
                                                    class="text-secondary">{{ number_format($comparisonData['previous_year']['data']['customers'][$index]['total_amount_billed'] ?? 0, 2) }}
                                                    billed</small>
                                                <br>
                                                <small
                                                    class="text-secondary">{{ number_format($comparisonData['previous_year']['data']['customers'][$index]['amount_paid'] ?? 0, 2) }}
                                                    paid</small>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span
                                                    class="badge badge-sm bg-gradient-info">{{ number_format($twoYearsAgoOutstanding, 2) }}</span>
                                                <br>
                                                <small
                                                    class="text-secondary">{{ number_format($comparisonData['two_years_ago']['data']['customers'][$index]['total_amount_billed'] ?? 0, 2) }}
                                                    billed</small>
                                                <br>
                                                <small
                                                    class="text-secondary">{{ number_format($comparisonData['two_years_ago']['data']['customers'][$index]['amount_paid'] ?? 0, 2) }}
                                                    paid</small>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="badge badge-sm {{ $growthVsPY >= 0 ? 'bg-gradient-danger' : 'bg-gradient-success' }}">
                                                    {{ $growthVsPY >= 0 ? '+' : '' }}{{ number_format($growthVsPY, 1) }}%
                                                </span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="badge badge-sm {{ $growthVs2YA >= 0 ? 'bg-gradient-danger' : 'bg-gradient-success' }}">
                                                    {{ $growthVs2YA >= 0 ? '+' : '' }}{{ number_format($growthVs2YA, 1) }}%
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach

                                    <!-- Summary Row -->
                                    @php
                                        $currentTotalOutstanding = $data['customers']->sum('outstanding_amount');
                                        $prevYearTotalOutstanding = $comparisonData['previous_year']['data'][
                                            'customers'
                                        ]->sum('outstanding_amount');
                                        $twoYearsAgoTotalOutstanding = $comparisonData['two_years_ago']['data'][
                                            'customers'
                                        ]->sum('outstanding_amount');

                                        $totalGrowthVsPY =
                                            $prevYearTotalOutstanding > 0
                                                ? (($currentTotalOutstanding - $prevYearTotalOutstanding) /
                                                        $prevYearTotalOutstanding) *
                                                    100
                                                : 0;
                                        $totalGrowthVs2YA =
                                            $twoYearsAgoTotalOutstanding > 0
                                                ? (($currentTotalOutstanding - $twoYearsAgoTotalOutstanding) /
                                                        $twoYearsAgoTotalOutstanding) *
                                                    100
                                                : 0;
                                    @endphp
                                    <tr class="table-dark">
                                        <td class="align-middle">
                                            <strong class="text-white">TOTAL</strong>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="badge badge-sm bg-gradient-primary text-white font-weight-bold">{{ number_format($currentTotalOutstanding, 2) }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="badge badge-sm bg-gradient-success text-white font-weight-bold">{{ number_format($prevYearTotalOutstanding, 2) }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="badge badge-sm bg-gradient-info text-white font-weight-bold">{{ number_format($twoYearsAgoTotalOutstanding, 2) }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="badge badge-sm {{ $totalGrowthVsPY >= 0 ? 'bg-gradient-danger' : 'bg-gradient-success' }} text-white font-weight-bold">
                                                {{ $totalGrowthVsPY >= 0 ? '+' : '' }}{{ number_format($totalGrowthVsPY, 1) }}%
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="badge badge-sm {{ $totalGrowthVs2YA >= 0 ? 'bg-gradient-danger' : 'bg-gradient-success' }} text-white font-weight-bold">
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
                                                        {{ number_format($comparisonData['current_year']['data']['customers']->sum('outstanding_amount'), 2) }}
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
                                                        {{ number_format($comparisonData['previous_year']['data']['customers']->sum('outstanding_amount'), 2) }}
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
                                                        {{ number_format($comparisonData['two_years_ago']['data']['customers']->sum('outstanding_amount'), 2) }}
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

        <!-- Payment Status Chart -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Payment Recovery Trend</h6>
                        <p class="text-sm mb-0">Conditional formatting for overdue (red highlight), trend line for payment
                            recovery</p>
                    </div>
                    <div class="card-body">
                        <canvas id="paymentChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Metrics -->
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Outstanding</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ number_format($data['total_outstanding'], 2) }}
                                        <span
                                            class="text-success text-sm font-weight-bolder">{{ $data['currency'] }}</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
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
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Customers with Outstanding</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $data['customers']->count() }}
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
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Avg Days Overdue</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ round($data['customers']->avg('days_overdue'), 1) }}
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
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Collection Rate</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        @php
                                            $totalBilled = $data['customers']->sum('total_amount_billed');
                                            $totalPaid = $data['customers']->sum('amount_paid');
                                            $collectionRate = $totalBilled > 0 ? ($totalPaid / $totalBilled) * 100 : 0;
                                        @endphp
                                        {{ round($collectionRate, 1) }}%
                                        <span class="text-success text-sm font-weight-bolder">Rate</span>
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

        <!-- Payment Status Summary -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Payment Status Summary</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <h6 class="text-sm font-weight-bold">High Risk (>30 days overdue)</h6>
                                <p class="text-sm">{{ $data['customers']->where('days_overdue', '>', 30)->count() }}
                                    customers</p>
                            </div>
                            <div class="col-md-4">
                                <h6 class="text-sm font-weight-bold">Medium Risk (1-30 days overdue)</h6>
                                <p class="text-sm">
                                    {{ $data['customers']->where('days_overdue', '>', 0)->where('days_overdue', '<=', 30)->count() }}
                                    customers</p>
                            </div>
                            <div class="col-md-4">
                                <h6 class="text-sm font-weight-bold">Current (0 days overdue)</h6>
                                <p class="text-sm">{{ $data['customers']->where('days_overdue', 0)->count() }} customers
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
                    label: 'Outstanding Amount ({{ $data['currency'] }})',
                    data: [
                        {{ $comparisonData['two_years_ago']['data']['customers']->sum('outstanding_amount') }},
                        {{ $comparisonData['previous_year']['data']['customers']->sum('outstanding_amount') }},
                        {{ $comparisonData['current_year']['data']['customers']->sum('outstanding_amount') }}
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
                            text: 'Outstanding Amount ({{ $data['currency'] }})'
                        }
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Outstanding Payments Comparison Chart'
                    }
                }
            }
        });
    </script>

    <script>
        // Payment Chart
        const paymentCtx = document.getElementById('paymentChart').getContext('2d');
        new Chart(paymentCtx, {
            type: 'bar',
            data: {
                labels: @json($data['customers']->map(fn($c) => $c['customer_name'])),
                datasets: [{
                    label: 'Outstanding Amount',
                    data: @json($data['customers']->map(fn($c) => $c['outstanding_amount'])),
                    backgroundColor: [
                        'rgba(220, 53, 69, 0.8)', // Red for high risk
                        'rgba(255, 193, 7, 0.8)', // Yellow for medium risk
                        'rgba(220, 53, 69, 0.8)', // Red for high risk
                        'rgba(255, 193, 7, 0.8)', // Yellow for medium risk
                        'rgba(255, 193, 7, 0.8)', // Yellow for medium risk
                        'rgba(255, 193, 7, 0.8)', // Yellow for medium risk
                        'rgba(34, 197, 94, 0.8)', // Green for low risk
                        'rgba(255, 193, 7, 0.8)', // Yellow for medium risk
                        'rgba(220, 53, 69, 0.8)', // Red for high risk
                        'rgba(255, 193, 7, 0.8)' // Yellow for medium risk
                    ],
                    borderColor: [
                        'rgba(220, 53, 69, 1)',
                        'rgba(255, 193, 7, 1)',
                        'rgba(220, 53, 69, 1)',
                        'rgba(255, 193, 7, 1)',
                        'rgba(255, 193, 7, 1)',
                        'rgba(255, 193, 7, 1)',
                        'rgba(34, 197, 94, 1)',
                        'rgba(255, 193, 7, 1)',
                        'rgba(220, 53, 69, 1)',
                        'rgba(255, 193, 7, 1)'
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
                            text: 'Amount ({{ $data['currency'] }})'
                        }
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Outstanding Payments by Customer'
                    },
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
@endpush
