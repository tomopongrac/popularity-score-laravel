<?php

namespace App\Providers;

use App\Services\GitHubServiceProvider;
use App\Services\ServiceProvider;
use Illuminate\Support\ServiceProvider as ServiceProviderIlluminate;

class AppServiceProvider extends ServiceProviderIlluminate
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ServiceProvider::class, GitHubServiceProvider::class);
    }
}
