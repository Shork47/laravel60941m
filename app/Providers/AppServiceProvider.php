<?php

namespace App\Providers;

use App\Models\Dish;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
//use Nette\Utils\Paginator;
use Illuminate\Pagination\Paginator;

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
        Paginator::defaultView('pagination::default');

        Gate::define('edit-dish', function (User $user, Dish $dish) {
            return $user->is_admin || $dish->user_id === $user->id;
        });

        Gate::define('destroy-dish', function (User $user, Dish $dish) {
            return $user->is_admin || $dish->user_id === $user->id;
        });
    }
}
