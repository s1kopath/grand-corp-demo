@extends('layouts.app')

@section('title', 'Indents vs Shipments Report')

@section('content')
    <div class="container-fluid py-4">
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
                            </div>
                            <div class="col-6 text-end">
                                <h6 class="text-sm font-weight-bold">Report Date: {{ $data['report_date'] }}</h6>
                                <h6 class="text-sm font-weight-bold">Total Months: {{ $data['total_months'] }}</h6>
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
                                            Total Indents</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Shipped on Time</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Delayed Shipments</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            % On-Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['monthly_data'] as $month)
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
                                                    class="badge badge-sm bg-gradient-primary">{{ $month['total_indents'] }}</span>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span
                                                    class="badge badge-sm bg-gradient-success">{{ $month['shipped_on_time'] }}</span>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span
                                                    class="badge badge-sm bg-gradient-warning">{{ $month['delayed_shipments'] }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                @if ($month['on_time_percentage'] >= 95)
                                                    <span
                                                        class="badge badge-sm bg-gradient-success">{{ $month['on_time_percentage'] }}%</span>
                                                @elseif($month['on_time_percentage'] >= 90)
                                                    <span
                                                        class="badge badge-sm bg-gradient-warning">{{ $month['on_time_percentage'] }}%</span>
                                                @else
                                                    <span
                                                        class="badge badge-sm bg-gradient-danger">{{ $month['on_time_percentage'] }}%</span>
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
