<?php

declare(strict_types=1);

namespace Whodoku\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Whodoku\Console\Commands\BuildStory;
use Whodoku\Console\Commands\ClarifyWindowStatements;
use Whodoku\Console\Commands\RatePuzzles;
use Whodoku\Console\Commands\RegeneratePuzzles;
use Whodoku\Console\Commands\ReleaseCases;
use Whodoku\Console\Commands\ReviewPuzzles;
use Whodoku\Console\Commands\PrepareTestPlayer;
use Whodoku\Console\Commands\TelegramCheck;
use Whodoku\Console\Commands\TelegramPoll;
use Whodoku\Http\Middleware\UseWhodokuRootView;

class WhodokuServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/killdoku.php', 'killdoku');
        $this->mergeConfigFrom(__DIR__.'/../../config/story.php', 'story');
        $this->app->register(AppServiceProvider::class);
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'whodoku');

        if (config('database.connections.whodoku.driver') === 'pgsql') {
            $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        }

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../../public/build/whodoku' => public_path('build/whodoku'),
                __DIR__.'/../../public/fonts' => public_path('fonts'),
                __DIR__.'/../../public/icons' => public_path('icons'),
            ], 'whodoku-assets');

            $this->commands([
                BuildStory::class,
                RatePuzzles::class,
                ReleaseCases::class,
                ReviewPuzzles::class,
                PrepareTestPlayer::class,
                ClarifyWindowStatements::class,
                RegeneratePuzzles::class,
                TelegramCheck::class,
                TelegramPoll::class,
            ]);
        }

        Route::middleware(['web', UseWhodokuRootView::class])
            ->group(__DIR__.'/../../routes/web.php');
        Route::middleware(['api'])
            ->prefix('api')
            ->group(__DIR__.'/../../routes/api.php');
    }
}
