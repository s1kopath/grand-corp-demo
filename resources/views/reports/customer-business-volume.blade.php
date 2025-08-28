@extends('layouts.app')

@section('title', 'Customer Business Volume Report')

@section('content')
    <div class="container-fluid py-4">
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
                                            Total Orders</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Total Volume (Units)</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Total Revenue ({{ $data['currency'] }})</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Avg Lead Time (days)</th>
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
                                                    class="badge badge-sm bg-gradient-info">{{ $customer['total_orders'] }}</span>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span
                                                    class="badge badge-sm bg-gradient-primary">{{ number_format($customer['total_volume']) }}</span>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span
                                                    class="badge badge-sm bg-gradient-success">{{ number_format($customer['total_revenue'], 2) }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                @if ($customer['avg_lead_time'] <= 7)
                                                    <span
                                                        class="badge badge-sm bg-gradient-success">{{ $customer['avg_lead_time'] }}
                                                        days</span>
                                                @elseif($customer['avg_lead_time'] <= 14)
                                                    <span
                                                        class="badge badge-sm bg-gradient-warning">{{ $customer['avg_lead_time'] }}
                                                        days</span>
                                                @else
                                                    <span
                                                        class="badge badge-sm bg-gradient-danger">{{ $customer['avg_lead_time'] }}
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

        <!-- Charts Row -->
        <div class="row">
            <!-- Pie Chart for Revenue Share -->
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Revenue Share by Customer</h6>
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
                        <h6>Volume Comparison by Customer</h6>
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
                                    <i class="material-symbols-rounded text-lg opacity-10" aria-hidden="true">inventory</i>
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
    </script>
@endpush
