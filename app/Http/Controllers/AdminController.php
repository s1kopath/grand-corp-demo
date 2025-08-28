<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use App\Models\Parameter;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function teams()
    {
        $teams = Team::with(['users'])->get();
        $teamStats = [
            'total_teams' => Team::count(),
            'total_users' => User::count(),
            'active_teams' => Team::where('status', 'active')->count(),
            'teams_with_manager' => Team::count(),
        ];

        return view('admin.teams.index', compact('teams', 'teamStats'));
    }

    public function users()
    {
        $users = User::with(['team'])->orderBy('created_at', 'desc')->get();
        $userStats = [
            'total_users' => User::count(),
            'super_admins' => User::where('role', 'super_admin')->count(),
            'admins' => User::where('role', 'admin')->count(),
            'staff' => User::where('role', 'staff')->count(),
            'active_users' => User::where('status', 'active')->count(),
            'recent_logins' => User::where('last_login_at', '>=', now()->subDays(7))->count(),
        ];

        return view('admin.users.index', compact('users', 'userStats'));
    }

    public function parameters()
    {
        $parameters = Parameter::all()->groupBy('category');
        $parameterStats = [
            'total_parameters' => Parameter::count(),
            'categories' => Parameter::distinct('category')->count(),
            'system_params' => Parameter::where('category', 'system')->count(),
            'business_params' => Parameter::where('category', 'business')->count(),
            'last_updated' => Parameter::max('updated_at'),
        ];

        return view('admin.parameters.index', compact('parameters', 'parameterStats'));
    }
}
