<?php

namespace App\Providers;

use App\enums\UserStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
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
        Schema::defaultStringLength(191);

        Model::preventLazyLoading(!$this->app->isProduction());

        Model::shouldBeStrict(!$this->app->isProduction());

//        @bloger
        Blade::if('manager',
            fn() => Auth::user()?->status === UserStatus::Manager);

        Gate::before(fn(User $user) => $user->status === UserStatus::Administrator);
    }
}
