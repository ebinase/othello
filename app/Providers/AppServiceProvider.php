<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Packages\Domain\Stone\Stone;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // コマ
        $this->app->bind(Stone::class, function ($app) {
            return new Stone(
                $app->make(Color::class),
                $app->make(Position::class)
            );
        });
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
