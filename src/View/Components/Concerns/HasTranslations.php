<?php

namespace Jonathanrixhon\Contents\View\Components\Concerns;

use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Field;
use Filament\SpatieLaravelTranslatablePlugin;

trait HasTranslations
{
    //public static array $translatable = [];

    /**
     * allows to detect if the component is a subcomponent and then
     * skip the dataprocessing part
     */
    public bool $skipTranslations = false;

    /**
     * Create a new component instance.
     */
    public function __construct(null|array $content = [], bool $skipTranslations = false)
    {
        parent::__construct($content);
        $this->skipTranslations = $skipTranslations;
    }

    /**
     * Process the data from the content for the page rendering.
     */
    protected function process(array $content = []): array
    {
        if ($this->skipTranslations) return $content;

        foreach ($content as $key => $value) {
            $content[$key] = $this->content($key);
        }

        return $content;
    }


    /**
     * Get the content's value
     */
    protected function content(string $key): mixed
    {
        if (in_array($key, static::$translatable ?? [])) {
            $key .= '.' . app()->getLocale();
        }

        return data_get($this->content, $key) ?? $this->{$key} ?? null;
    }
}
