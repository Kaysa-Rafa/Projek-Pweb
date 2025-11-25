<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        //
    ];

    public function boot(): void
    {
        // Gate untuk fungsi USER: upload, comment, rating
        Gate::define('manage-resources', function (User $user) {
            // Hanya user ('user') dan admin ('admin') yang bisa upload
            return $user->isUser() || $user->isAdmin();
        });

        // Gate untuk fungsi ADMIN: audit user
        Gate::define('access-admin-panel', function (User $user) {
            // Hanya Admin yang bisa mengakses panel admin
            return $user->isAdmin();
        });
    }
}