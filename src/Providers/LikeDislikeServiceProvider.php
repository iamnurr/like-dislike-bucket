<?php
namespace NrType\LikeDislike\Providers;

use Illuminate\Support\ServiceProvider;

class LikeDislikeServiceProvider extends ServiceProvider
{
/**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
