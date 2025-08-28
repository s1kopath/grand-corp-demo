@extends('layouts.app')

@section('title', 'L/C Expiry Analysis Report')

@section('content')
    <div class="container-fluid py-4">
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
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">L/C
                                            No</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Customer</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Principal</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Amount ({{ $data['currency'] }})</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Issue Date</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Expiry Date</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Days Remaining</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['lcs'] as $lc)
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
                                                    class="badge badge-sm bg-gradient-info">{{ number_format($lc['amount'], 2) }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold">{{ $lc['issue_date'] }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold">{{ $lc['expiry_date'] }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                @if ($lc['days_remaining'] > 30)
                                                    <span
                                                        class="badge badge-sm bg-gradient-success">{{ $lc['days_remaining'] }}
                                                        days</span>
                                                @elseif($lc['days_remaining'] > 7)
                                                    <span
                                                        class="badge badge-sm bg-gradient-warning">{{ $lc['days_remaining'] }}
                                                        days</span>
                                                @elseif($lc['days_remaining'] > 0)
                                                    <span
                                                        class="badge badge-sm bg-gradient-danger">{{ $lc['days_remaining'] }}
                                                        days</span>
                                                @else
                                                    <span class="badge badge-sm bg-gradient-secondary">Expired</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center">
                                                @if ($lc['status'] == 'Active')
                                                    <span
                                                        class="badge badge-sm bg-gradient-success">{{ $lc['status'] }}</span>
                                                @else
                                                    <span
                                                        class="badge badge-sm bg-gradient-secondary">{{ $lc['status'] }}</span>
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
                        'rgba(34, 197, 94, 0.8)',  // Green for >30 days
                        'rgba(34, 197, 94, 0.8)',  // Green for >30 days
                        'rgba(34, 197, 94, 0.8)',  // Green for >30 days
                        'rgba(34, 197, 94, 0.8)',  // Green for >30 days
                        'rgba(34, 197, 94, 0.8)',  // Green for >30 days
                        'rgba(34, 197, 94, 0.8)',  // Green for >30 days
                        'rgba(34, 197, 94, 0.8)',  // Green for >30 days
                        'rgba(34, 197, 94, 0.8)',  // Green for >30 days
                        'rgba(34, 197, 94, 0.8)',  // Green for >30 days
                        'rgba(34, 197, 94, 0.8)'   // Green for >30 days
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
