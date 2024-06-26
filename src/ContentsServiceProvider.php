<?php

namespace Jonathanrixhon\Contents;

use Illuminate\Support\ServiceProvider;

class ContentsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations')
        ], 'contents-migrations');

        $this->publishes([
            __DIR__ . '/../config/contents.php' => config_path('contents.php'),
        ], ['contents-config']);

        $this->loadTranslationsFrom(__DIR__.'/../lang', 'contents');
        $this->publishes([
            __DIR__.'/../lang' => $this->app->langPath('vendor/lang'),
        ], ['contents-lang']);
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/contents.php', 'contents');
    }
}
