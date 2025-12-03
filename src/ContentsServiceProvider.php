<?php

namespace Jonathanrixhon\Contents;

use Jonathanrixhon\Contents\Helpers;
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

        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'contents');
        $this->publishes([
            __DIR__ . '/../lang' => $this->app->langPath('vendor/contents'),
        ], ['contents-lang']);

        $this->install();
    }

    protected function install(): void
    {
        $this->publishes([
            //Filament
            Helpers::stubsPath('app/Filament/Pages/Settings.stub') => app_path('Filament/Pages/Settings.php'),
            Helpers::stubsPath('app/Filament/Resources/Concerns/Form.stub') => app_path('Filament/Resources/Concerns/Form.php'),
            Helpers::stubsPath('app/Filament/Resources/Pages/Schemas/PageForm.stub') => app_path('Filament/Resources/Pages/Schemas/PageForm.php'),
            Helpers::stubsPath('app/Filament/Resources/Pages/Pages/CreatePage.stub') => app_path('Filament/Resources/Pages/Pages/CreatePage.php'),
            Helpers::stubsPath('app/Filament/Resources/Pages/Pages/EditPage.stub') => app_path('Filament/Resources/Pages/Pages/EditPage.php'),
            Helpers::stubsPath('app/Filament/Resources/Pages/Pages/ListPages.stub') => app_path('Filament/Resources/Pages/Pages/ListPages.php'),
            Helpers::stubsPath('app/Filament/Resources/Pages/Pages/ManageContent.stub') => app_path('Filament/Resources/Pages/Pages/ManageContent.php'),
            Helpers::stubsPath('app/Filament/Resources/Contents/ContentResource.stub') => app_path('Filament/Resources/Contents/ContentResource.php'),
            Helpers::stubsPath('app/Filament/Resources/Pages/PageResource.stub') => app_path('Filament/Resources/Pages/PageResource.php'),
            Helpers::stubsPath('resources/views/filament/pages/settings.blade.php') => resource_path('views/filament/pages/settings.blade.php'),

            //Models
            Helpers::stubsPath('app/Models/Content.stub') => app_path('Models/Content.php'),
            Helpers::stubsPath('app/Models/Page.stub') => app_path('Models/Page.php'),

            //HTTP
            Helpers::stubsPath('app/Http/Controllers/HomeController.stub') => app_path('Http/Controllers/HomeController.php'),
            Helpers::stubsPath('app/Http/PageTemplate.stub') => app_path('Http/PageTemplate.php'),

            //Providers
            Helpers::stubsPath('app/Providers/Filament/AdminPanelProvider.stub') => app_path('Providers/Filament/AdminPanelProvider.php'),

            //Utils
            Helpers::stubsPath('app/Utils/Settings.stub') => app_path('Utils/Settings.php'),

            //Social image
            Helpers::stubsPath('resources/img/socials.jpg') => resource_path('img/socials.jpg'),
            Helpers::stubsPath('resources/img/socials_small.jpg') => resource_path('img/socials_small.jpg'),
        ], ['contents-install']);
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/contents.php', 'contents');
    }
}
