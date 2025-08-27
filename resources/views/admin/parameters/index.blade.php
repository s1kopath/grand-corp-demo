@extends('layouts.app')

@section('title', 'System Parameters')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <div class="row">
                            <div class="col-6">
                                <h6 class="text-white text-capitalize ps-3">System Parameters</h6>
                            </div>
                            <div class="col-6 text-end">
                                <span class="btn btn-sm btn-outline-light me-3">
                                    <i class="material-icons text-sm me-1">settings</i>Add Parameter
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Demo Info Card -->
                    <div class="alert alert-info text-white font-weight-bold" role="alert">
                        <i class="material-icons text-sm me-2">info</i>
                        <strong>Demo Parameters:</strong> This page displays system configuration parameters. All parameters
                        are pre-seeded for demonstration purposes.
                    </div>

                    <!-- Parameter Statistics -->
                    <div class="row mb-4">
                        <div class="col-xl-3 col-sm-6 mb-4">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Parameters
                                                </p>
                                                <h5 class="font-weight-bolder mb-0">
                                                    {{ $parameterStats['total_parameters'] }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div
                                                class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                                <i class="material-icons opacity-10">settings</i>
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
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Categories</p>
                                                <h5 class="font-weight-bolder mb-0">{{ $parameterStats['categories'] }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div
                                                class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                                <i class="material-icons opacity-10">category</i>
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
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">System Params</p>
                                                <h5 class="font-weight-bolder mb-0">{{ $parameterStats['system_params'] }}
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div
                                                class="icon icon-shape bg-gradient-info shadow-info text-center rounded-circle">
                                                <i class="material-icons opacity-10">computer</i>
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
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Business Params</p>
                                                <h5 class="font-weight-bolder mb-0">{{ $parameterStats['business_params'] }}
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div
                                                class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                                <i class="material-icons opacity-10">business</i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Parameters by Category -->
                    <div class="row">
                        @foreach ($parameters as $category => $categoryParameters)
                            <div class="col-lg-6 col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-header pb-0">
                                        <div class="row">
                                            <div class="col-8">
                                                <h6 class="mb-0">{{ ucfirst($category) }} Parameters</h6>
                                                <p class="text-sm text-secondary mb-0">{{ count($categoryParameters) }}
                                                    parameters</p>
                                            </div>
                                            <div class="col-4 text-end">
                                                <div
                                                    class="icon icon-shape bg-gradient-{{ $category === 'system' ? 'info' : 'warning' }} shadow-{{ $category === 'system' ? 'info' : 'warning' }} text-center rounded-circle">
                                                    <i
                                                        class="material-icons opacity-10">{{ $category === 'system' ? 'computer' : 'business' }}</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="table-responsive">
                                            <table class="table align-items-center mb-0">
                                                <thead>
                                                    <tr>
                                                        <th
                                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                            Parameter</th>
                                                        <th
                                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                            Value</th>
                                                        <th
                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                            Type</th>
                                                        <th
                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                            Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($categoryParameters as $parameter)
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex px-2 py-1">
                                                                    <div class="d-flex flex-column justify-content-center">
                                                                        <h6 class="mb-0 text-sm">{{ $parameter->name }}</h6>
                                                                        <p class="text-xs text-secondary mb-0">
                                                                            {{ $parameter->description }}</p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <p class="text-xs font-weight-bold mb-0">
                                                                    @if ($parameter->type === 'boolean')
                                                                        <span
                                                                            class="badge badge-sm bg-gradient-{{ $parameter->value ? 'success' : 'secondary' }}">
                                                                            {{ $parameter->value ? 'Yes' : 'No' }}
                                                                        </span>
                                                                    @elseif($parameter->type === 'number')
                                                                        {{ number_format($parameter->value) }}
                                                                    @else
                                                                        {{ Str::limit($parameter->value, 30) }}
                                                                    @endif
                                                                </p>
                                                            </td>
                                                            <td class="align-middle text-center">
                                                                <span class="text-secondary text-xs font-weight-bold">
                                                                    {{ ucfirst($parameter->type) }}
                                                                </span>
                                                            </td>
                                                            <td class="align-middle text-center">
                                                                <div class="d-flex justify-content-center">
                                                                    <a href="#"
                                                                        class="btn btn-link text-dark px-2 mb-0"
                                                                        title="Edit Parameter">
                                                                        <i class="material-icons text-sm">edit</i>
                                                                    </a>
                                                                    <a href="#"
                                                                        class="btn btn-link text-dark px-2 mb-0"
                                                                        title="View History">
                                                                        <i class="material-icons text-sm">history</i>
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Parameter Categories Overview -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="mb-3">Parameter Categories Overview</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card bg-gradient-info text-white">
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-center">
                                                <div
                                                    class="icon icon-shape bg-white shadow text-center rounded-circle me-3">
                                                    <i class="material-icons opacity-10 text-info">computer</i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">System Parameters</h6>
                                                    <p class="text-sm mb-0 opacity-8">
                                                        {{ $parameterStats['system_params'] }} parameters</p>
                                                    <p class="text-xs mb-0 opacity-8">Application configuration, security
                                                        settings, and technical parameters</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card bg-gradient-warning text-white">
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-center">
                                                <div
                                                    class="icon icon-shape bg-white shadow text-center rounded-circle me-3">
                                                    <i class="material-icons opacity-10 text-warning">business</i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">Business Parameters</h6>
                                                    <p class="text-sm mb-0 opacity-8">
                                                        {{ $parameterStats['business_params'] }} parameters</p>
                                                    <p class="text-xs mb-0 opacity-8">Business rules, workflow settings,
                                                        and operational parameters</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Parameter Management -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="mb-3">Parameter Management</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header pb-0">
                                            <h6>Recent Changes</h6>
                                        </div>
                                        <div class="card-body p-3">
                                            <div class="timeline timeline-one-side">
                                                <div class="timeline-block mb-3">
                                                    <span class="timeline-step">
                                                        <i
                                                            class="material-icons text-success text-gradient">check_circle</i>
                                                    </span>
                                                    <div class="timeline-content">
                                                        <h6 class="text-dark text-sm font-weight-bold mb-0">Session Timeout
                                                            Updated</h6>
                                                        <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                                            Changed from 30 to 60 minutes
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="timeline-block mb-3">
                                                    <span class="timeline-step">
                                                        <i class="material-icons text-info text-gradient">info</i>
                                                    </span>
                                                    <div class="timeline-content">
                                                        <h6 class="text-dark text-sm font-weight-bold mb-0">Email
                                                            Notifications Enabled</h6>
                                                        <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                                            System notifications activated
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="timeline-block mb-3">
                                                    <span class="timeline-step">
                                                        <i class="material-icons text-warning text-gradient">warning</i>
                                                    </span>
                                                    <div class="timeline-content">
                                                        <h6 class="text-dark text-sm font-weight-bold mb-0">Backup
                                                            Frequency Modified</h6>
                                                        <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                                            Changed to daily backups
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header pb-0">
                                            <h6>Quick Actions</h6>
                                        </div>
                                        <div class="card-body p-3">
                                            <div class="d-grid gap-2">
                                                <button class="btn btn-sm bg-gradient-primary text-white" type="button">
                                                    <i class="material-icons text-sm me-2">settings</i>Add New Parameter
                                                </button>
                                                <button class="btn btn-sm bg-gradient-success text-white" type="button">
                                                    <i class="material-icons text-sm me-2">file_download</i>Export
                                                    Parameters
                                                </button>
                                                <button class="btn btn-sm bg-gradient-info text-white" type="button">
                                                    <i class="material-icons text-sm me-2">file_upload</i>Import Parameters
                                                </button>
                                                <button class="btn btn-sm bg-gradient-warning text-white" type="button">
                                                    <i class="material-icons text-sm me-2">restore</i>Reset to Defaults
                                                </button>
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
    </div>
@endsection
