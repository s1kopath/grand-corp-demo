@extends('layouts.app')

@section('title', 'Users Management')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <div class="row">
                            <div class="col-6">
                                <h6 class="text-white text-capitalize ps-3">Users Management</h6>
                            </div>
                            <div class="col-6 text-end">
                                <span class="btn btn-sm btn-outline-light me-3">
                                    <i class="material-icons text-sm me-1">person_add</i>Create User
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Demo Info Card -->
                    <div class="alert alert-info text-white font-weight-bold" role="alert">
                        <i class="material-icons text-sm me-2">info</i>
                        <strong>Demo Users:</strong> This page displays user accounts and role assignments. All user data is
                        pre-seeded for demonstration purposes.
                    </div>

                    <!-- User Statistics -->
                    <div class="row mb-4">
                        <div class="col-xl-2 col-sm-6 mb-4">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Users</p>
                                                <h5 class="font-weight-bolder mb-0">{{ $userStats['total_users'] }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div
                                                class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                                <i class="material-icons opacity-10">people</i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-sm-6 mb-4">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Super Admins</p>
                                                <h5 class="font-weight-bolder mb-0">{{ $userStats['super_admins'] }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div
                                                class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                                <i class="material-icons opacity-10">admin_panel_settings</i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-sm-6 mb-4">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Admins</p>
                                                <h5 class="font-weight-bolder mb-0">{{ $userStats['admins'] }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div
                                                class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                                <i class="material-icons opacity-10">security</i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-sm-6 mb-4">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Staff</p>
                                                <h5 class="font-weight-bolder mb-0">{{ $userStats['staff'] }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div
                                                class="icon icon-shape bg-gradient-info shadow-info text-center rounded-circle">
                                                <i class="material-icons opacity-10">person</i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-sm-6 mb-4">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Active</p>
                                                <h5 class="font-weight-bolder mb-0">{{ $userStats['active_users'] }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div
                                                class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                                <i class="material-icons opacity-10">check_circle</i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-sm-6 mb-4">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Recent Logins</p>
                                                <h5 class="font-weight-bolder mb-0">{{ $userStats['recent_logins'] }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div
                                                class="icon icon-shape bg-gradient-secondary shadow-secondary text-center rounded-circle">
                                                <i class="material-icons opacity-10">login</i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Users Table -->
                    <div class="row">
                        <div class="col-12">
                            <h6 class="mb-3">User Accounts</h6>
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                User</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Role</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Team</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Status</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Last Login</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{ $user->name }}</h6>
                                                            <p class="text-xs text-secondary mb-0">{{ $user->email }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <span
                                                            class="badge badge-sm bg-gradient-{{ $user->role === 'super_admin' ? 'danger' : ($user->role === 'admin' ? 'warning' : 'info') }}">
                                                            {{ ucwords(str_replace('_', ' ', $user->role)) }}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $user->team->name ?? 'No Team' }}</p>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    @if ($user->status === 'active')
                                                        <span class="badge badge-sm bg-gradient-success">Active</span>
                                                    @elseif($user->status === 'inactive')
                                                        <span class="badge badge-sm bg-gradient-secondary">Inactive</span>
                                                    @else
                                                        <span
                                                            class="badge badge-sm bg-gradient-warning">{{ ucfirst($user->status) }}</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">
                                                        {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}
                                                    </span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <div class="d-flex justify-content-center">
                                                        <a href="#" class="btn btn-link text-dark px-2 mb-0"
                                                            title="View Profile">
                                                            <i class="material-icons text-sm">visibility</i>
                                                        </a>
                                                        <a href="#" class="btn btn-link text-dark px-2 mb-0"
                                                            title="Edit User">
                                                            <i class="material-icons text-sm">edit</i>
                                                        </a>
                                                        <a href="#" class="btn btn-link text-dark px-2 mb-0"
                                                            title="Reset Password">
                                                            <i class="material-icons text-sm">lock_reset</i>
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

                    <!-- Role Distribution -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h6>Role Distribution</h6>
                                </div>
                                <div class="card-body p-3">
                                    <div class="timeline timeline-one-side">
                                        <div class="timeline-block mb-3">
                                            <span class="timeline-step">
                                                <i
                                                    class="material-icons text-danger text-gradient">admin_panel_settings</i>
                                            </span>
                                            <div class="timeline-content">
                                                <h6 class="text-dark text-sm font-weight-bold mb-0">Super Admins</h6>
                                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                                    {{ $userStats['super_admins'] }} users - Full system access
                                                </p>
                                            </div>
                                        </div>
                                        <div class="timeline-block mb-3">
                                            <span class="timeline-step">
                                                <i class="material-icons text-warning text-gradient">security</i>
                                            </span>
                                            <div class="timeline-content">
                                                <h6 class="text-dark text-sm font-weight-bold mb-0">Admins</h6>
                                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                                    {{ $userStats['admins'] }} users - Administrative access
                                                </p>
                                            </div>
                                        </div>
                                        <div class="timeline-block mb-3">
                                            <span class="timeline-step">
                                                <i class="material-icons text-info text-gradient">person</i>
                                            </span>
                                            <div class="timeline-content">
                                                <h6 class="text-dark text-sm font-weight-bold mb-0">Staff</h6>
                                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                                    {{ $userStats['staff'] }} users - Standard access
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
                                    <h6>User Activity</h6>
                                </div>
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="text-center">
                                                <h4 class="text-success mb-0">{{ $userStats['active_users'] }}</h4>
                                                <p class="text-sm text-secondary mb-0">Active Users</p>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-center">
                                                <h4 class="text-info mb-0">{{ $userStats['recent_logins'] }}</h4>
                                                <p class="text-sm text-secondary mb-0">Recent Logins (7 days)</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="text-sm text-secondary">Active Rate</span>
                                            <span
                                                class="text-sm text-secondary">{{ round(($userStats['active_users'] / $userStats['total_users']) * 100, 1) }}%</span>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar bg-gradient-success" role="progressbar"
                                                style="width: {{ ($userStats['active_users'] / $userStats['total_users']) * 100 }}%">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="mb-3">Quick Actions</h6>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <button class="btn btn-sm bg-gradient-primary text-white w-100" type="button">
                                        <i class="material-icons text-sm me-2">person_add</i>Create User
                                    </button>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <button class="btn btn-sm bg-gradient-success text-white w-100" type="button">
                                        <i class="material-icons text-sm me-2">group_add</i>Bulk Import
                                    </button>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <button class="btn btn-sm bg-gradient-warning text-white w-100" type="button">
                                        <i class="material-icons text-sm me-2">security</i>Role Management
                                    </button>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <button class="btn btn-sm bg-gradient-info text-white w-100" type="button">
                                        <i class="material-icons text-sm me-2">assessment</i>User Reports
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
