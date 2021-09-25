<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Packages\Domain\Board\Field;
use Packages\Domain\Color\Color;
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
        
        // $this->app->bind(Color::class, function ($app) {
        //     return new Color;
        // });


        // // 盤面のマス
        // $this->app->bind(Field::class, function ($app) {
        //     return new Field(
        //         $app->make(Color::class),
        //         $app->make(Position::class)
        //     );
        // });
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
