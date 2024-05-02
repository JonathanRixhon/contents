<?php

namespace Jonathanrixhon\Contents\View\Components\Concerns;

use Closure;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Field;


abstract class Component extends \Illuminate\View\Component
{
    /**
     * the component's content
     */
    public array|null $content;

    /**
     * the component's blade view
     */
    public static string $view;

    /**
     * the component's attribute used to describe its content
     */
    public static string $tableValue = 'title';

    /**
     * the component folder's path
     */
    public static string $componentFolder = 'components';

    /**
     * Create a new component instance.
     */
    public function __construct(null|array $content = [])
    {
        $this->content = $content;
    }

    /**
     * Create a new component instance.
     */
    public function __get(string $attribute): mixed
    {
        return $this->content($attribute) ?? $this->{$attribute} ?? null;
    }

    /**
     * Get the component's label.
     */
    abstract public static function label(): string;

    /**
     * Get the component's description.
     */
    abstract public static function description(): string;

    /**
     * Get the admin fields.
     */
    abstract public static function fields(): array;

    /**
     * Process the data from the content for the page rendering.
     */
    protected function process(array $content = []): array
    {
        return $content;
    }

    /**
     * Get the content's value
     */
    protected function content(string $key): mixed
    {
        return data_get($this->content, $key) ?? $this->{$key} ?? null;
    }

    /**
     * Get the content's value
     */
    public static function getFields()
    {
        return array_map(function (Field $field) {
            $name = 'content.' . $field->getName();
            return $field->statePath($name);
        }, static::fields());
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $content = $this->subComponent
            ? $this->content
            : $this->process($this->content);

        return view(static::$componentFolder . '.' . static::$view, $content);
    }
}
