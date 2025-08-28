@extends('layouts.app')

@section('title', 'Product-Principal Engagement Report')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-6">
                                <h6>Product-Principal Engagement Report</h6>
                                <p class="text-sm mb-0">
                                    <i class="fa fa-clock text-success" aria-hidden="true"></i>
                                    <span class="font-weight-bold">Purpose:</span> Map which products are linked to which
                                    principals and their activity
                                </p>
                            </div>
                            <div class="col-6 text-end">
                                <h6 class="text-sm font-weight-bold">Report Date: {{ $data['report_date'] }}</h6>
                                <h6 class="text-sm font-weight-bold">Total Products: {{ $data['total_products'] }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Product Name</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Principal</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Total Orders</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Avg Shipment Delay (days)</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Outstanding Indent</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['products'] as $product)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $product['product_name'] }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span
                                                    class="badge badge-sm bg-gradient-info">{{ $product['principal'] }}</span>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span
                                                    class="badge badge-sm bg-gradient-primary">{{ $product['total_orders'] }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                @if ($product['avg_shipment_delay'] <= 2)
                                                    <span
                                                        class="badge badge-sm bg-gradient-success">{{ $product['avg_shipment_delay'] }}
                                                        days</span>
                                                @elseif($product['avg_shipment_delay'] <= 5)
                                                    <span
                                                        class="badge badge-sm bg-gradient-warning">{{ $product['avg_shipment_delay'] }}
                                                        days</span>
                                                @else
                                                    <span
                                                        class="badge badge-sm bg-gradient-danger">{{ $product['avg_shipment_delay'] }}
                                                        days</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                @if ($product['outstanding_indent'] == 0)
                                                    <span class="badge badge-sm bg-gradient-success">0</span>
                                                @else
                                                    <span
                                                        class="badge badge-sm bg-gradient-warning">{{ $product['outstanding_indent'] }}</span>
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

        <!-- Engagement Heatmap -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Engagement Intensity Heatmap</h6>
                        <p class="text-sm mb-0">Color intensity based on total orders and delay performance</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($data['products']->take(12) as $product)
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body p-3 text-center">
                                            <h6 class="text-sm font-weight-bold mb-1">{{ $product['product_name'] }}</h6>
                                            <p class="text-xs text-secondary mb-2">{{ $product['principal'] }}</p>
                                            <div class="d-flex justify-content-between">
                                                <span class="text-xs">Orders: {{ $product['total_orders'] }}</span>
                                                <span class="text-xs">Delay: {{ $product['avg_shipment_delay'] }}d</span>
                                            </div>
                                            <div class="mt-2">
                                                @if ($product['total_orders'] > 100)
                                                    <span class="badge badge-sm bg-gradient-success">High Engagement</span>
                                                @elseif($product['total_orders'] > 50)
                                                    <span class="badge badge-sm bg-gradient-warning">Medium
                                                        Engagement</span>
                                                @else
                                                    <span class="badge badge-sm bg-gradient-secondary">Low Engagement</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Metrics -->
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Products</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $data['total_products'] }}
                                        <span class="text-success text-sm font-weight-bolder">Products</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
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
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Orders</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $data['products']->sum('total_orders') }}
                                        <span class="text-success text-sm font-weight-bolder">Orders</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
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
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Avg Delay</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ round($data['products']->avg('avg_shipment_delay'), 1) }}
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
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Outstanding Indents</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $data['products']->sum('outstanding_indent') }}
                                        <span class="text-success text-sm font-weight-bolder">Items</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-info shadow-info text-center rounded-circle">
                                    <i class="material-symbols-rounded text-lg opacity-10" aria-hidden="true">pending</i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
