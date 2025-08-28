@extends('layouts.app')

@section('title', 'Business Reports')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <div class="row">
                            <div class="col-6">
                                <h6 class="text-white text-capitalize ps-3">Business Reports Center</h6>
                            </div>
                            <div class="col-6 text-end">
                                <span class="btn btn-sm btn-outline-light me-3">
                                    <i class="material-symbols-rounded text-sm me-1">schedule</i>Auto-refresh: 5 min
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Demo Info Card -->
                    <div class="alert alert-info text-white font-weight-bold" role="alert">
                        <i class="material-symbols-rounded text-sm me-2">info</i>
                        <strong>Demo Reports:</strong> All reports are pre-generated with demo data. Export buttons will
                        download sample files for demonstration purposes.
                    </div>

                    <!-- Detailed Reports Section -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">Detailed Analysis Reports
                            </h6>
                            <div class="row">
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-body p-3">
                                            <div class="row">
                                                <div class="col-8">
                                                    <div class="numbers">
                                                        <p class="text-sm mb-0 text-capitalize font-weight-bold">80/20
                                                            Analysis</p>
                                                        <p class="text-xs text-secondary mb-0">Pareto analysis of top
                                                            customers</p>
                                                    </div>
                                                </div>
                                                <div class="col-4 text-end">
                                                    <a href="{{ route('reports.pareto-analysis') }}"
                                                        class="btn btn-sm bg-gradient-primary">
                                                        <i class="material-symbols-rounded text-sm">analytics</i> View
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-body p-3">
                                            <div class="row">
                                                <div class="col-8">
                                                    <div class="numbers">
                                                        <p class="text-sm mb-0 text-capitalize font-weight-bold">Principal
                                                            Product Volume</p>
                                                        <p class="text-xs text-secondary mb-0">Supplier performance analysis
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-4 text-end">
                                                    <a href="{{ route('reports.principal-product-volume') }}"
                                                        class="btn btn-sm bg-gradient-success">
                                                        <i class="material-symbols-rounded text-sm">business</i> View
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-body p-3">
                                            <div class="row">
                                                <div class="col-8">
                                                    <div class="numbers">
                                                        <p class="text-sm mb-0 text-capitalize font-weight-bold">
                                                            Product-Principal Engagement</p>
                                                        <p class="text-xs text-secondary mb-0">Product supplier mapping</p>
                                                    </div>
                                                </div>
                                                <div class="col-4 text-end">
                                                    <a href="{{ route('reports.product-principal-engagement') }}"
                                                        class="btn btn-sm bg-gradient-warning">
                                                        <i class="material-symbols-rounded text-sm">link</i> View
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-body p-3">
                                            <div class="row">
                                                <div class="col-8">
                                                    <div class="numbers">
                                                        <p class="text-sm mb-0 text-capitalize font-weight-bold">Indents vs
                                                            Shipments</p>
                                                        <p class="text-xs text-secondary mb-0">Monthly operational
                                                            efficiency</p>
                                                    </div>
                                                </div>
                                                <div class="col-4 text-end">
                                                    <a href="{{ route('reports.indents-vs-shipments') }}"
                                                        class="btn btn-sm bg-gradient-info">
                                                        <i class="material-symbols-rounded text-sm">trending_up</i> View
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-body p-3">
                                            <div class="row">
                                                <div class="col-8">
                                                    <div class="numbers">
                                                        <p class="text-sm mb-0 text-capitalize font-weight-bold">Customer
                                                            Business Volume</p>
                                                        <p class="text-xs text-secondary mb-0">Customer revenue analysis</p>
                                                    </div>
                                                </div>
                                                <div class="col-4 text-end">
                                                    <a href="{{ route('reports.customer-business-volume') }}"
                                                        class="btn btn-sm bg-gradient-secondary">
                                                        <i class="material-symbols-rounded text-sm">people</i> View
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-body p-3">
                                            <div class="row">
                                                <div class="col-8">
                                                    <div class="numbers">
                                                        <p class="text-sm mb-0 text-capitalize font-weight-bold">Outstanding
                                                            Payments</p>
                                                        <p class="text-xs text-secondary mb-0">Receivables tracking</p>
                                                    </div>
                                                </div>
                                                <div class="col-4 text-end">
                                                    <a href="{{ route('reports.outstanding-payments') }}"
                                                        class="btn btn-sm bg-gradient-danger">
                                                        <i class="material-symbols-rounded text-sm">account_balance</i> View
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-body p-3">
                                            <div class="row">
                                                <div class="col-8">
                                                    <div class="numbers">
                                                        <p class="text-sm mb-0 text-capitalize font-weight-bold">L/C Expiry
                                                            Analysis</p>
                                                        <p class="text-xs text-secondary mb-0">Letter of credit tracking</p>
                                                    </div>
                                                </div>
                                                <div class="col-4 text-end">
                                                    <a href="{{ route('reports.lc-expiry-analysis') }}"
                                                        class="btn btn-sm bg-gradient-dark">
                                                        <i class="material-symbols-rounded text-sm">schedule</i> View
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Report Statistics -->
                    <div class="row mb-4">
                        <div class="col-xl-3 col-sm-6 mb-4">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Reports</p>
                                                <h5 class="font-weight-bolder mb-0">{{ $reportStats['total_reports'] }}
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div
                                                class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                                <i class="material-symbols-rounded opacity-10">assessment</i>
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
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Generated Today
                                                </p>
                                                <h5 class="font-weight-bolder mb-0">
                                                    {{ $reportStats['reports_generated_today'] }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div
                                                class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                                <i class="material-symbols-rounded opacity-10">today</i>
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
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Records Exported
                                                </p>
                                                <h5 class="font-weight-bolder mb-0">
                                                    {{ number_format($reportStats['total_records_exported']) }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div
                                                class="icon icon-shape bg-gradient-info shadow-info text-center rounded-circle">
                                                <i class="material-symbols-rounded opacity-10">file_download</i>
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
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Avg Generation</p>
                                                <h5 class="font-weight-bolder mb-0">
                                                    {{ $reportStats['average_generation_time'] }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div
                                                class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                                <i class="material-symbols-rounded opacity-10">timer</i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reports Grid -->
                    <div class="row">
                        @foreach ($reports as $report)
                            <div class="col-lg-6 col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-header pb-0">
                                        <div class="row">
                                            <div class="col-8">
                                                <h6 class="mb-0">{{ $report['title'] }}</h6>
                                                <p class="text-sm text-secondary mb-0">{{ $report['description'] }}</p>
                                            </div>
                                            <div class="col-4 text-end">
                                                <div
                                                    class="icon icon-shape bg-gradient-{{ $report['color'] }} shadow-{{ $report['color'] }} text-center rounded-circle">
                                                    <i
                                                        class="material-symbols-rounded opacity-10">{{ $report['icon'] }}</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="numbers">
                                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Records</p>
                                                    <h6 class="font-weight-bolder mb-0">
                                                        {{ number_format($report['records']) }}</h6>
                                                    <p class="text-xs text-secondary mb-0">
                                                        Last generated: {{ $report['last_generated'] }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-4 text-end">
                                                <a href="{{ route('reports.export', $report['slug']) }}"
                                                    class="btn btn-sm bg-gradient-{{ $report['color'] }} text-white"
                                                    title="Export {{ $report['title'] }}">
                                                    <i class="material-symbols-rounded text-sm">file_download</i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Report Categories -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="mb-3">Report Categories</h6>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <div class="card bg-gradient-success text-white">
                                        <div class="card-body p-3">
                                            <div class="text-center">
                                                <i class="material-symbols-rounded opacity-10 mb-2"
                                                    style="font-size: 2rem;">trending_up</i>
                                                <h6 class="mb-0">Sales & Performance</h6>
                                                <p class="text-sm mb-0 opacity-8">3 reports</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card bg-gradient-primary text-white">
                                        <div class="card-body p-3">
                                            <div class="text-center">
                                                <i class="material-symbols-rounded opacity-10 mb-2"
                                                    style="font-size: 2rem;">people</i>
                                                <h6 class="mb-0">Customer & Supplier</h6>
                                                <p class="text-sm mb-0 opacity-8">2 reports</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card bg-gradient-info text-white">
                                        <div class="card-body p-3">
                                            <div class="text-center">
                                                <i class="material-symbols-rounded opacity-10 mb-2"
                                                    style="font-size: 2rem;">account_balance</i>
                                                <h6 class="mb-0">Financial & Operations</h6>
                                                <p class="text-sm mb-0 opacity-8">2 reports</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card bg-gradient-warning text-white">
                                        <div class="card-body p-3">
                                            <div class="text-center">
                                                <i class="material-symbols-rounded opacity-10 mb-2"
                                                    style="font-size: 2rem;">verified</i>
                                                <h6 class="mb-0">Compliance & Quality</h6>
                                                <p class="text-sm mb-0 opacity-8">1 report</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Popular Reports -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="mb-3">Most Popular Reports</h6>
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Report</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Category</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Downloads</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Last Used</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">Sales Performance Report</h6>
                                                        <p class="text-xs text-secondary mb-0">Monthly sales analysis</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-sm bg-gradient-success">Sales</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">156</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">2 hours ago</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <a href="{{ route('reports.export', 'sales-performance') }}"
                                                    class="btn btn-link text-dark px-2 mb-0" title="Export">
                                                    <i class="material-symbols-rounded text-sm">file_download</i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">Financial Summary Report</h6>
                                                        <p class="text-xs text-secondary mb-0">Revenue and receivables</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-sm bg-gradient-info">Finance</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">89</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">6 hours ago</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <a href="{{ route('reports.export', 'financial-summary') }}"
                                                    class="btn btn-link text-dark px-2 mb-0" title="Export">
                                                    <i class="material-symbols-rounded text-sm">file_download</i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">Customer Analysis Report</h6>
                                                        <p class="text-xs text-secondary mb-0">Customer profitability</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-sm bg-gradient-primary">Customer</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">67</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">1 day ago</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <a href="{{ route('reports.export', 'customer-analysis') }}"
                                                    class="btn btn-link text-dark px-2 mb-0" title="Export">
                                                    <i class="material-symbols-rounded text-sm">file_download</i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Report Schedule Info -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card bg-gradient-light">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="mb-2">Automated Report Schedule</h6>
                                            <ul class="text-sm text-secondary mb-0">
                                                <li>Daily: Financial Summary, Inventory Status</li>
                                                <li>Weekly: Sales Performance, Customer Analysis</li>
                                                <li>Monthly: Compliance Report, Operational Metrics</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="mb-2">Export Formats</h6>
                                            <ul class="text-sm text-secondary mb-0">
                                                <li>Excel (.xlsx) - Full formatting and charts</li>
                                                <li>PDF (.pdf) - Print-ready reports</li>
                                                <li>CSV (.csv) - Data analysis format</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
