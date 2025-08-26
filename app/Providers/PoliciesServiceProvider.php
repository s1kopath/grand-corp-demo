<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Enums\UserRole;

class PoliciesServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // SuperAdmin can do everything
        Gate::define('viewAdmin', function ($user) {
            return in_array($user->role, [UserRole::SUPER_ADMIN, UserRole::ADMIN]);
        });

        Gate::define('viewFinance', function ($user) {
            return in_array($user->role, [UserRole::SUPER_ADMIN, UserRole::ADMIN]);
        });

        Gate::define('viewReports', function ($user) {
            return in_array($user->role, [UserRole::SUPER_ADMIN, UserRole::ADMIN]);
        });

        Gate::define('manageBranding', function ($user) {
            return $user->role === UserRole::SUPER_ADMIN;
        });

        Gate::define('manageUsers', function ($user) {
            return in_array($user->role, [UserRole::SUPER_ADMIN, UserRole::ADMIN]);
        });

        Gate::define('viewDataBank', function ($user) {
            return true; // All roles can view data bank
        });

        Gate::define('viewCRM', function ($user) {
            return true; // All roles can view CRM
        });

        Gate::define('viewSalesOps', function ($user) {
            return true; // All roles can view sales operations
        });

        Gate::define('viewLogistics', function ($user) {
            return true; // All roles can view logistics
        });
    }
}
