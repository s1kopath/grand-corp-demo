@extends('layouts.app')

@section('title', 'Outstanding Payments Report')

@section('content')
    <div class="container-fluid py-4">
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
                            </div>
                            <div class="col-6 text-end">
                                <h6 class="text-sm font-weight-bold">Report Date: {{ $data['report_date'] }}</h6>
                                <h6 class="text-sm font-weight-bold">Currency: {{ $data['currency'] }}</h6>
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
                                            Total Amount Billed ({{ $data['currency'] }})</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Amount Paid</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Outstanding Amount</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Days Overdue</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['customers'] as $customer)
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
                                                    class="badge badge-sm bg-gradient-info">{{ number_format($customer['total_amount_billed'], 2) }}</span>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span
                                                    class="badge badge-sm bg-gradient-success">{{ number_format($customer['amount_paid'], 2) }}</span>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                @if ($customer['outstanding_amount'] > 0)
                                                    <span
                                                        class="badge badge-sm bg-gradient-danger">{{ number_format($customer['outstanding_amount'], 2) }}</span>
                                                @else
                                                    <span class="badge badge-sm bg-gradient-success">0.00</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center">
                                                @if ($customer['days_overdue'] == 0)
                                                    <span class="badge badge-sm bg-gradient-success">0 days</span>
                                                @elseif($customer['days_overdue'] <= 30)
                                                    <span
                                                        class="badge badge-sm bg-gradient-warning">{{ $customer['days_overdue'] }}
                                                        days</span>
                                                @else
                                                    <span
                                                        class="badge badge-sm bg-gradient-danger">{{ $customer['days_overdue'] }}
                                                        days</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
                        'rgba(220, 53, 69, 0.8)',  // Red for high risk
                        'rgba(255, 193, 7, 0.8)',  // Yellow for medium risk
                        'rgba(220, 53, 69, 0.8)',  // Red for high risk
                        'rgba(255, 193, 7, 0.8)',  // Yellow for medium risk
                        'rgba(255, 193, 7, 0.8)',  // Yellow for medium risk
                        'rgba(255, 193, 7, 0.8)',  // Yellow for medium risk
                        'rgba(34, 197, 94, 0.8)',  // Green for low risk
                        'rgba(255, 193, 7, 0.8)',  // Yellow for medium risk
                        'rgba(220, 53, 69, 0.8)',  // Red for high risk
                        'rgba(255, 193, 7, 0.8)'   // Yellow for medium risk
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
