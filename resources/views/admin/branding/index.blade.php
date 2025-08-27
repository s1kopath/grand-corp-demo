@extends('layouts.app')

@section('title', 'Company Branding')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <div class="row">
                            <div class="col-6">
                                <h6 class="text-white text-capitalize ps-3">Company Branding</h6>
                            </div>
                            <div class="col-6 text-end">
                                <span class="btn btn-sm btn-outline-light me-3">
                                    <i class="material-icons text-sm me-1">palette</i>Customize
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Demo Info Card -->
                    <div class="alert alert-info text-white font-weight-bold" role="alert">
                        <i class="material-icons text-sm me-2">info</i>
                        <strong>Demo Branding:</strong> This page displays company branding settings. All branding data is
                        pre-seeded for demonstration purposes.
                    </div>

                    <!-- Branding Statistics -->
                    <div class="row mb-4">
                        <div class="col-xl-3 col-sm-6 mb-4">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Logo Configured</p>
                                                <h5 class="font-weight-bolder mb-0">
                                                    {{ $brandingStats['logo_configured'] ? 'Yes' : 'No' }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div
                                                class="icon icon-shape bg-gradient-{{ $brandingStats['logo_configured'] ? 'success' : 'secondary' }} shadow-{{ $brandingStats['logo_configured'] ? 'success' : 'secondary' }} text-center rounded-circle">
                                                <i class="material-icons opacity-10">image</i>
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
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Favicon Configured
                                                </p>
                                                <h5 class="font-weight-bolder mb-0">
                                                    {{ $brandingStats['favicon_configured'] ? 'Yes' : 'No' }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div
                                                class="icon icon-shape bg-gradient-{{ $brandingStats['favicon_configured'] ? 'success' : 'secondary' }} shadow-{{ $brandingStats['favicon_configured'] ? 'success' : 'secondary' }} text-center rounded-circle">
                                                <i class="material-icons opacity-10">star</i>
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
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Color Scheme</p>
                                                <h5 class="font-weight-bolder mb-0">
                                                    {{ ucfirst($brandingStats['color_scheme']) }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div
                                                class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                                <i class="material-icons opacity-10">palette</i>
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
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Last Updated</p>
                                                <h5 class="font-weight-bolder mb-0">
                                                    {{ $brandingStats['last_updated'] ? $brandingStats['last_updated']->diffForHumans() : 'Never' }}
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div
                                                class="icon icon-shape bg-gradient-info shadow-info text-center rounded-circle">
                                                <i class="material-icons opacity-10">update</i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Branding Preview -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h6>Current Branding</h6>
                                </div>
                                <div class="card-body p-3">
                                    <div class="text-center mb-3">
                                        @if ($branding && $branding->logo_url)
                                            <img src="{{ $branding->logo_url }}" alt="Company Logo" class="img-fluid"
                                                style="max-height: 100px;">
                                        @else
                                            <div class="bg-gradient-light rounded p-4">
                                                <i class="material-icons text-secondary" style="font-size: 3rem;">image</i>
                                                <p class="text-secondary mt-2">No logo configured</p>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="text-sm mb-1"><strong>Company Name:</strong></p>
                                            <p class="text-sm text-secondary mb-3">
                                                {{ $branding->company_name ?? 'Grand Corporation' }}</p>
                                        </div>
                                        <div class="col-6">
                                            <p class="text-sm mb-1"><strong>Tagline:</strong></p>
                                            <p class="text-sm text-secondary mb-3">
                                                {{ $branding->tagline ?? 'Excellence in International Trade' }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="text-sm mb-1"><strong>Primary Color:</strong></p>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary rounded me-2" style="width: 20px; height: 20px;">
                                                </div>
                                                <span
                                                    class="text-sm text-secondary">{{ $branding->primary_color ?? '#1976D2' }}</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <p class="text-sm mb-1"><strong>Secondary Color:</strong></p>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-secondary rounded me-2" style="width: 20px; height: 20px;">
                                                </div>
                                                <span
                                                    class="text-sm text-secondary">{{ $branding->secondary_color ?? '#424242' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h6>Branding Elements</h6>
                                </div>
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-6 mb-3">
                                            <div class="text-center">
                                                <div class="bg-gradient-light rounded p-3 mb-2">
                                                    <i class="material-icons text-primary"
                                                        style="font-size: 2rem;">image</i>
                                                </div>
                                                <h6 class="mb-0">Logo</h6>
                                                <p class="text-xs text-secondary mb-0">
                                                    {{ $brandingStats['logo_configured'] ? 'Configured' : 'Not Set' }}</p>
                                            </div>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <div class="text-center">
                                                <div class="bg-gradient-light rounded p-3 mb-2">
                                                    <i class="material-icons text-primary"
                                                        style="font-size: 2rem;">star</i>
                                                </div>
                                                <h6 class="mb-0">Favicon</h6>
                                                <p class="text-xs text-secondary mb-0">
                                                    {{ $brandingStats['favicon_configured'] ? 'Configured' : 'Not Set' }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <div class="text-center">
                                                <div class="bg-gradient-light rounded p-3 mb-2">
                                                    <i class="material-icons text-primary"
                                                        style="font-size: 2rem;">palette</i>
                                                </div>
                                                <h6 class="mb-0">Colors</h6>
                                                <p class="text-xs text-secondary mb-0">
                                                    {{ ucfirst($brandingStats['color_scheme']) }}</p>
                                            </div>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <div class="text-center">
                                                <div class="bg-gradient-light rounded p-3 mb-2">
                                                    <i class="material-icons text-primary"
                                                        style="font-size: 2rem;">font_download</i>
                                                </div>
                                                <h6 class="mb-0">Typography</h6>
                                                <p class="text-xs text-secondary mb-0">Default Font</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Branding Settings -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="mb-3">Branding Configuration</h6>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-header pb-0">
                                            <h6>Company Information</h6>
                                        </div>
                                        <div class="card-body p-3">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="input-group input-group-outline mb-3">
                                                        <label class="form-label">Company Name</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $branding->company_name ?? 'Grand Corporation' }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group input-group-outline mb-3">
                                                        <label class="form-label">Tagline</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $branding->tagline ?? 'Excellence in International Trade' }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="input-group input-group-outline mb-3">
                                                        <label class="form-label">Website URL</label>
                                                        <input type="url" class="form-control"
                                                            value="{{ $branding->website_url ?? 'https://grandcorporation.com' }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group input-group-outline mb-3">
                                                        <label class="form-label">Support Email</label>
                                                        <input type="email" class="form-control"
                                                            value="{{ $branding->support_email ?? 'support@grandcorporation.com' }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="input-group input-group-outline mb-3">
                                                        <label class="form-label">Company Address</label>
                                                        <textarea class="form-control" rows="3" readonly>{{ $branding->address ?? '123 Business Street, Suite 100, New York, NY 10001, USA' }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header pb-0">
                                            <h6>Color Scheme</h6>
                                        </div>
                                        <div class="card-body p-3">
                                            <div class="mb-3">
                                                <label class="form-label">Primary Color</label>
                                                <div class="d-flex align-items-center">
                                                    <input type="color" class="form-control form-control-color me-2"
                                                        value="{{ $branding->primary_color ?? '#1976D2' }}" readonly>
                                                    <span
                                                        class="text-sm text-secondary">{{ $branding->primary_color ?? '#1976D2' }}</span>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Secondary Color</label>
                                                <div class="d-flex align-items-center">
                                                    <input type="color" class="form-control form-control-color me-2"
                                                        value="{{ $branding->secondary_color ?? '#424242' }}" readonly>
                                                    <span
                                                        class="text-sm text-secondary">{{ $branding->secondary_color ?? '#424242' }}</span>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Accent Color</label>
                                                <div class="d-flex align-items-center">
                                                    <input type="color" class="form-control form-control-color me-2"
                                                        value="{{ $branding->accent_color ?? '#FF9800' }}" readonly>
                                                    <span
                                                        class="text-sm text-secondary">{{ $branding->accent_color ?? '#FF9800' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Branding Actions -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="mb-3">Branding Management</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header pb-0">
                                            <h6>Upload Assets</h6>
                                        </div>
                                        <div class="card-body p-3">
                                            <div class="d-grid gap-2">
                                                <button class="btn btn-sm bg-gradient-primary text-white" type="button">
                                                    <i class="material-icons text-sm me-2">upload_file</i>Upload Logo
                                                </button>
                                                <button class="btn btn-sm bg-gradient-success text-white" type="button">
                                                    <i class="material-icons text-sm me-2">upload_file</i>Upload Favicon
                                                </button>
                                                <button class="btn btn-sm bg-gradient-info text-white" type="button">
                                                    <i class="material-icons text-sm me-2">upload_file</i>Upload Banner
                                                </button>
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
                                                <button class="btn btn-sm bg-gradient-warning text-white" type="button">
                                                    <i class="material-icons text-sm me-2">palette</i>Customize Colors
                                                </button>
                                                <button class="btn btn-sm bg-gradient-info text-white" type="button">
                                                    <i class="material-icons text-sm me-2">font_download</i>Typography
                                                    Settings
                                                </button>
                                                <button class="btn btn-sm bg-gradient-secondary text-white"
                                                    type="button">
                                                    <i class="material-icons text-sm me-2">restore</i>Reset to Defaults
                                                </button>
                                                <button class="btn btn-sm bg-gradient-success text-white" type="button">
                                                    <i class="material-icons text-sm me-2">preview</i>Preview Changes
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
