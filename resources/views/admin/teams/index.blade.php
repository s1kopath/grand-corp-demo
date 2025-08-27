@extends('layouts.app')

@section('title', 'Teams Management')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <div class="row">
                            <div class="col-6">
                                <h6 class="text-white text-capitalize ps-3">Teams Management</h6>
                            </div>
                            <div class="col-6 text-end">
                                <span class="btn btn-sm btn-outline-light me-3">
                                    <i class="material-icons text-sm me-1">group_add</i>Create Team
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Demo Info Card -->
                    <div class="alert alert-info text-white font-weight-bold" role="alert">
                        <i class="material-icons text-sm me-2">info</i>
                        <strong>Demo Teams:</strong> This page displays team structure and hierarchy. All team data is
                        pre-seeded for demonstration purposes.
                    </div>

                    <!-- Team Statistics -->
                    <div class="row mb-4">
                        <div class="col-xl-3 col-sm-6 mb-4">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Teams</p>
                                                <h5 class="font-weight-bolder mb-0">{{ $teamStats['total_teams'] }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div
                                                class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                                <i class="material-icons opacity-10">groups</i>
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
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Users</p>
                                                <h5 class="font-weight-bolder mb-0">{{ $teamStats['total_users'] }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div
                                                class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                                <i class="material-icons opacity-10">people</i>
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
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Active Teams</p>
                                                <h5 class="font-weight-bolder mb-0">{{ $teamStats['active_teams'] }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div
                                                class="icon icon-shape bg-gradient-info shadow-info text-center rounded-circle">
                                                <i class="material-icons opacity-10">check_circle</i>
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
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">With Manager</p>
                                                <h5 class="font-weight-bolder mb-0">{{ $teamStats['teams_with_manager'] }}
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div
                                                class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                                <i class="material-icons opacity-10">person</i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Teams Table -->
                    <div class="row">
                        <div class="col-12">
                            <h6 class="mb-3">Team Structure</h6>
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Team</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Manager</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Members</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Department</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Status</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($teams as $team)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{ $team->name }}</h6>
                                                            <p class="text-xs text-secondary mb-0">{{ $team->description }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <h6 class="mb-0 text-sm">
                                                            {{ $team->manager->name ?? 'Not Assigned' }}</h6>
                                                        <p class="text-xs text-secondary mb-0">
                                                            {{ $team->manager->email ?? '' }}</p>
                                                    </div>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">
                                                        {{ $team->users->count() }} members
                                                    </span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">
                                                        {{ $team->department ?? 'N/A' }}
                                                    </span>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    @if ($team->status === 'active')
                                                        <span class="badge badge-sm bg-gradient-success">Active</span>
                                                    @elseif($team->status === 'inactive')
                                                        <span class="badge badge-sm bg-gradient-secondary">Inactive</span>
                                                    @else
                                                        <span
                                                            class="badge badge-sm bg-gradient-warning">{{ ucfirst($team->status) }}</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center">
                                                    <div class="d-flex justify-content-center">
                                                        <a href="#" class="btn btn-link text-dark px-2 mb-0"
                                                            title="View Details">
                                                            <i class="material-icons text-sm">visibility</i>
                                                        </a>
                                                        <a href="#" class="btn btn-link text-dark px-2 mb-0"
                                                            title="Edit Team">
                                                            <i class="material-icons text-sm">edit</i>
                                                        </a>
                                                        <a href="#" class="btn btn-link text-dark px-2 mb-0"
                                                            title="Manage Members">
                                                            <i class="material-icons text-sm">group</i>
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

                    <!-- Team Hierarchy -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="mb-3">Organizational Hierarchy</h6>
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        @foreach ($teams as $team)
                                            <div class="col-md-4 mb-3">
                                                <div class="card bg-gradient-light">
                                                    <div class="card-body p-3">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <div
                                                                class="icon icon-shape bg-gradient-{{ $team->status === 'active' ? 'success' : 'secondary' }} shadow-{{ $team->status === 'active' ? 'success' : 'secondary' }} text-center rounded-circle me-3">
                                                                <i class="material-icons opacity-10 text-white">groups</i>
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-0">{{ $team->name }}</h6>
                                                                <p class="text-xs text-secondary mb-0">
                                                                    {{ $team->users->count() }} members</p>
                                                            </div>
                                                        </div>
                                                        @if ($team->manager)
                                                            <div class="d-flex align-items-center">
                                                                <div
                                                                    class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle me-2">
                                                                    <i class="material-icons opacity-10 text-white"
                                                                        style="font-size: 1rem;">person</i>
                                                                </div>
                                                                <div>
                                                                    <p class="text-xs font-weight-bold mb-0">
                                                                        {{ $team->manager->name }}</p>
                                                                    <p class="text-xs text-secondary mb-0">Team Manager</p>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($team->users->count() > 0)
                                                            <div class="mt-2">
                                                                <p class="text-xs text-secondary mb-1">Team Members:</p>
                                                                <div class="d-flex flex-wrap">
                                                                    @foreach ($team->users->take(3) as $user)
                                                                        <span
                                                                            class="badge badge-sm bg-gradient-info me-1 mb-1">{{ $user->name }}</span>
                                                                    @endforeach
                                                                    @if ($team->users->count() > 3)
                                                                        <span
                                                                            class="badge badge-sm bg-gradient-secondary me-1 mb-1">+{{ $team->users->count() - 3 }}
                                                                            more</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Team Performance Summary -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="mb-3">Team Performance Summary</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header pb-0">
                                            <h6>Team Activity</h6>
                                        </div>
                                        <div class="card-body p-3">
                                            <div class="timeline timeline-one-side">
                                                @foreach ($teams->take(3) as $team)
                                                    <div class="timeline-block mb-3">
                                                        <span class="timeline-step">
                                                            <i
                                                                class="material-icons text-success text-gradient">check_circle</i>
                                                        </span>
                                                        <div class="timeline-content">
                                                            <h6 class="text-dark text-sm font-weight-bold mb-0">
                                                                {{ $team->name }}</h6>
                                                            <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                                                {{ $team->users->count() }} active members
                                                            </p>
                                                        </div>
                                                    </div>
                                                @endforeach
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
                                                    <i class="material-icons text-sm me-2">group_add</i>Create New Team
                                                </button>
                                                <button class="btn btn-sm bg-gradient-success text-white" type="button">
                                                    <i class="material-icons text-sm me-2">person_add</i>Assign Team
                                                    Manager
                                                </button>
                                                <button class="btn btn-sm bg-gradient-info text-white" type="button">
                                                    <i class="material-icons text-sm me-2">group</i>Manage Members
                                                </button>
                                                <button class="btn btn-sm bg-gradient-warning text-white" type="button">
                                                    <i class="material-icons text-sm me-2">assessment</i>Team Reports
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
