<?php

namespace App\Providers;

use App\Repositories\Game\SessionGameRepository;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;
use Packages\Models\Bot\Calculators\Random\RandomCalculator;
use Packages\Repositories\Game\GameRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        if (app()->isProduction()) $url->forceScheme('https');
    }
}
