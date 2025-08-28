@extends('layouts.app')

@section('title', 'Accounts Summary')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <div class="row">
                            <div class="col-6">
                                <h6 class="text-white text-capitalize ps-3">Financial Accounts Summary</h6>
                            </div>
                            <div class="col-6 text-end">
                                <a href="{{ route('debit-notes.index') }}" class="btn btn-sm btn-outline-light me-3">
                                    <i class="material-symbols-rounded text-sm me-1">receipt</i>View Debit Notes
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Demo Info Card -->
                    <div class="alert alert-info text-white font-weight-bold" role="alert">
                        <i class="material-symbols-rounded text-sm me-2">info</i>
                        <strong>Demo Data:</strong> This page displays financial summary with demo data. All amounts and
                        metrics are simulated for demonstration purposes.
                    </div>

                    <!-- Financial Summary Cards -->
                    <div class="row">
                        <div class="col-xl-3 col-sm-6 mb-4">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Receivables
                                                </p>
                                                <h5 class="font-weight-bolder mb-0">
                                                    ${{ number_format($accountSummary['total_receivables'], 2) }}
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div
                                                class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                                <i class="material-symbols-rounded opacity-10">account_balance_wallet</i>
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
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Pending Receivables
                                                </p>
                                                <h5 class="font-weight-bolder mb-0">
                                                    ${{ number_format($accountSummary['pending_receivables'], 2) }}
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div
                                                class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                                <i class="material-symbols-rounded opacity-10">pending</i>
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
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Paid Receivables
                                                </p>
                                                <h5 class="font-weight-bolder mb-0">
                                                    ${{ number_format($accountSummary['paid_receivables'], 2) }}
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div
                                                class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                                <i class="material-symbols-rounded opacity-10">check_circle</i>
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
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Overdue Amount</p>
                                                <h5 class="font-weight-bolder mb-0">
                                                    ${{ number_format($accountSummary['overdue_amount'], 2) }}
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div
                                                class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                                <i class="material-symbols-rounded opacity-10">warning</i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Financial Metrics Row -->
                    <div class="row">
                        <div class="col-xl-3 col-sm-6 mb-4">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Current Month
                                                    Revenue</p>
                                                <h5 class="font-weight-bolder mb-0">
                                                    ${{ number_format($financialMetrics['current_month_revenue'], 2) }}
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div
                                                class="icon icon-shape bg-gradient-info shadow-info text-center rounded-circle">
                                                <i class="material-symbols-rounded opacity-10">trending_up</i>
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
                                                    {{ $financialMetrics['collection_rate'] }}%
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div
                                                class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                                <i class="material-symbols-rounded opacity-10">pie_chart</i>
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
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Avg Payment Time
                                                </p>
                                                <h5 class="font-weight-bolder mb-0">
                                                    {{ round($financialMetrics['avg_payment_time'] ?? 0) }} days
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div
                                                class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                                <i class="material-symbols-rounded opacity-10">schedule</i>
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
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Completed
                                                    Shipments</p>
                                                <h5 class="font-weight-bolder mb-0">
                                                    {{ $accountSummary['completed_shipments'] }}/{{ $accountSummary['total_shipments'] }}
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div
                                                class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                                <i class="material-symbols-rounded opacity-10">local_shipping</i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Charts Row -->
                    <div class="row">
                        <div class="col-lg-8 col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h6>Monthly Revenue Trend</h6>
                                    <p class="text-sm">
                                        <i class="fa fa-arrow-up text-success" aria-hidden="true"></i>
                                        <span class="font-weight-bold">4% more</span> this month
                                    </p>
                                </div>
                                <div class="card-body p-3">
                                    <div class="chart">
                                        <canvas id="revenueChart" class="chart-canvas" height="300"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h6>Receivables Status</h6>
                                </div>
                                <div class="card-body p-3">
                                    <div class="chart">
                                        <canvas id="receivablesChart" class="chart-canvas" height="300"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Transactions and Pending Payments -->
                    <div class="row">
                        <div class="col-lg-8 col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h6>Recent Account Transactions</h6>
                                </div>
                                <div class="card-body px-0 pt-0 pb-2">
                                    <div class="table-responsive p-0">
                                        <table class="table align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        Date</th>
                                                    <th
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                        Account</th>
                                                    <th
                                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        Type</th>
                                                    <th
                                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        Amount</th>
                                                    <th
                                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($recentTransactions as $transaction)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex px-2 py-1">
                                                                <div class="d-flex flex-column justify-content-center">
                                                                    <h6 class="mb-0 text-sm">
                                                                        {{ $transaction->entry_date->format('M d, Y') }}
                                                                    </h6>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <p class="text-xs font-weight-bold mb-0">
                                                                {{ $transaction->account_name }}</p>
                                                            <p class="text-xs text-secondary mb-0">
                                                                {{ $transaction->debitNote->number ?? 'N/A' }}
                                                            </p>
                                                        </td>
                                                        <td class="align-middle text-center">
                                                            <span class="text-secondary text-xs font-weight-bold">
                                                                {{ ucfirst($transaction->entry_type) }}
                                                            </span>
                                                        </td>
                                                        <td class="align-middle text-center">
                                                            <span class="text-secondary text-xs font-weight-bold">
                                                                ${{ number_format($transaction->amount, 2) }}
                                                            </span>
                                                        </td>
                                                        <td class="align-middle text-center text-sm">
                                                            @if ($transaction->status === 'posted')
                                                                <span
                                                                    class="badge badge-sm bg-gradient-success">Posted</span>
                                                            @elseif($transaction->status === 'pending')
                                                                <span
                                                                    class="badge badge-sm bg-gradient-warning">Pending</span>
                                                            @else
                                                                <span
                                                                    class="badge badge-sm bg-gradient-secondary">{{ ucfirst($transaction->status) }}</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center py-4">
                                                            <p class="text-secondary">No recent transactions found.</p>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h6>Pending Payments</h6>
                                </div>
                                <div class="card-body p-3">
                                    @forelse($pendingPayments as $payment)
                                        <div class="timeline timeline-one-side">
                                            <div class="timeline-block mb-3">
                                                <span class="timeline-step">
                                                    <i
                                                        class="material-symbols-rounded text-warning text-gradient">schedule</i>
                                                </span>
                                                <div class="timeline-content">
                                                    <h6 class="text-dark text-sm font-weight-bold mb-0">
                                                        {{ $payment->customer->name }}
                                                    </h6>
                                                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                                        ${{ number_format($payment->total_amount, 2) }}
                                                    </p>
                                                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                                        Due: {{ $payment->due_date->format('M d, Y') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-secondary text-center">No pending payments.</p>
                                    @endforelse
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
        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: @json($monthlyRevenue->pluck('month')),
                datasets: [{
                    label: 'Revenue',
                    data: @json($monthlyRevenue->pluck('revenue')),
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.1
                }, {
                    label: 'Pending',
                    data: @json($monthlyRevenue->pluck('pending')),
                    borderColor: 'rgb(255, 205, 86)',
                    backgroundColor: 'rgba(255, 205, 86, 0.2)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Receivables Chart
        const receivablesCtx = document.getElementById('receivablesChart').getContext('2d');
        new Chart(receivablesCtx, {
            type: 'doughnut',
            data: {
                labels: ['Paid', 'Pending', 'Approved', 'Overdue'],
                datasets: [{
                    data: [
                        {{ $accountSummary['paid_receivables'] }},
                        {{ $accountSummary['pending_receivables'] }},
                        {{ $accountSummary['approved_receivables'] }},
                        {{ $accountSummary['overdue_amount'] }}
                    ],
                    backgroundColor: [
                        'rgb(34, 197, 94)',
                        'rgb(251, 191, 36)',
                        'rgb(59, 130, 246)',
                        'rgb(239, 68, 68)'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
    </script>
@endpush
