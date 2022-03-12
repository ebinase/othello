<?php

namespace App\Providers;

use App\Repositories\Game\SessionGameRepository;
use Illuminate\Support\ServiceProvider;
use Packages\Repositories\Game\GameRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    public array $bindings = [
        GameRepositoryInterface::class => SessionGameRepository::class,
    ];
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
    public function boot()
    {
        //
    }
}
