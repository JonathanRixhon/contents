<?php

namespace Jonathanrixhon\Contents;

class Helpers
{

    /**
     * Return the stub's path
     */
    public static function basePath(string $target = ''): string
    {
        return __DIR__ . '/' . trim($target, '/');
    }

    /**
     * Return the stub's path
     */
    public static function stubsPath(string $target = ''): string
    {
        return Helpers::basePath('/../stubs/' . trim($target, '/'));
    }

    public static function getLocales(): array
    {
        $filamentTranslatable = filament()->hasPlugin('spatie-laravel-translatable')
            ? filament('spatie-laravel-translatable')->getDefaultLocales()
            : null;

        return config('contents.locales') ?? $filamentTranslatable ?? [config('app.locale')];
    }
}
