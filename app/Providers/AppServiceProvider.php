<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        view()->composer('layouts.main', function ($view) {
            $view->with('setting', Setting::first());
        });

        view()->composer('layouts.auth', function ($view) {
            $view->with('setting', Setting::first());
        });

        view()->composer('auth.login', function ($view) {
            $view->with('setting', Setting::first());
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Gate::define('admin', function(User $user) {
        //     auth()->username === 'administrator';
        // });
    }
}
