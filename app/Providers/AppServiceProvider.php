<?php

namespace App\Providers;

use App\Policies\PermissionPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('viewAny', function ($user, $table) {
            return app(PermissionPolicy::class)->viewAny($user, $table);
        });

        Gate::define('view', function ($user, $table) {
            return app(PermissionPolicy::class)->view($user, $table);
        });

        Gate::define('create', function ($user, $table) {
            return app(PermissionPolicy::class)->create($user, $table);
        });

        Gate::define('update', function ($user, $table) {
            return app(PermissionPolicy::class)->update($user, $table);
        });

        Gate::define('delete', function ($user, $table) {
            return app(PermissionPolicy::class)->delete($user, $table);
        });
    }
}
