<?php

namespace App\Providers;

use App\Models\Itinerary;
use App\Models\Stage;
use App\Policies\ItineraryPolicy;
use App\Policies\StagePolicy;
use Illuminate\Pagination\Paginator;
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
        Paginator::useBootstrapFive(); 
    }

    protected $policies = [
        Itinerary::class => ItineraryPolicy::class,
    ];
}
