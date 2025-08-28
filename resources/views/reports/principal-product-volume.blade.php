@extends('layouts.app')

@section('title', 'Principal-wise Product Volume Report')

@section('content')
    <div class="container-fluid py-4">
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
                            </div>
                            <div class="col-6 text-end">
                                <h6 class="text-sm font-weight-bold">Report Date: {{ $data['report_date'] }}</h6>
                                <h6 class="text-sm font-weight-bold">Total Principals: {{ $data['total_principals'] }}</h6>
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
                                            Product Count</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Total Indent Volume</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Total Shipment Volume</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            % Shipped on Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['principals'] as $principal)
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
                                                    class="badge badge-sm bg-gradient-info">{{ $principal['product_count'] }}</span>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span
                                                    class="badge badge-sm bg-gradient-primary">{{ number_format($principal['total_indent_volume']) }}
                                                    units</span>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span
                                                    class="badge badge-sm bg-gradient-success">{{ number_format($principal['total_shipment_volume']) }}
                                                    units</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                @if ($principal['shipped_on_time_percentage'] >= 95)
                                                    <span
                                                        class="badge badge-sm bg-gradient-success">{{ $principal['shipped_on_time_percentage'] }}%</span>
                                                @elseif($principal['shipped_on_time_percentage'] >= 90)
                                                    <span
                                                        class="badge badge-sm bg-gradient-warning">{{ $principal['shipped_on_time_percentage'] }}%</span>
                                                @else
                                                    <span
                                                        class="badge badge-sm bg-gradient-danger">{{ $principal['shipped_on_time_percentage'] }}%</span>
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

        <!-- Stacked Bar Chart -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Product Volume Comparison - Indent vs Shipment</h6>
                        <p class="text-sm mb-0">Stacked bar chart showing volume performance per principal</p>
                    </div>
                    <div class="card-body">
                        <canvas id="volumeChart" height="100"></canvas>
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
                        text: 'Principal-wise Product Volume Analysis'
                    }
                }
            }
        });
    </script>
@endpush
