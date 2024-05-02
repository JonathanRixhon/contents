<?php

namespace Jonathanrixhon\Contents\View\Components\Concerns;

use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Field;

trait HasTranslations
{
    //public static array $translatable = [];

    /**
     * allows to detect if the component is a subcomponent and then
     * skip the dataprocessing part
     */
    public bool $skipTranslations;

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

    /**
     * Get the translated admin fields
     */
    public static function tabs(): Tabs
    {
        $langs = ['fr', 'en'];

        $tabs = array_map(function ($lang) {
            return Tabs\Tab::make(mb_strtoupper($lang))
                ->schema(static::remapFields($lang));
        }, $langs);

        return Tabs::make('Tabs')->tabs($tabs);
    }

    /**
     * Remap all components names with .$lang
     * suffix to be a json object
     *
     */
    public static function remapFields(string $lang): array
    {
        return array_map(function (Field $field)  use ($lang) {
            $name = 'content.translated.' . $field->getName() . '.' . $lang;
            return $field->statePath($name);
        }, self::translatedFields());
    }

    /**
     * Get the content's value
     */
    public static function getFields()
    {
        return [
            ...parent::getFields(),
            self::tabs()
        ];
    }

    /**
     * Mutate translated datas before save
     */
    public static function mutateBeforeSave(array $data): array
    {
        $data['content'] = array_merge($data['content'], $data['content']['translated'] ?? []);
        unset($data['content']['translated']);

        return $data;
    }

    /**
     * Mutate translated datas before save
     */
    public static function mutateBeforeFill(array $data): array
    {
        foreach (static::$translatable as $key) {
            $data['content']['translated'][$key] = $data['content'][$key];
            unset($data['content'][$key]);
        }

        return $data;
    }
}
