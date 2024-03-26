<?php

namespace Jonathanrixhon\Contents\View\Components\Concerns;

use Closure;
use Illuminate\Contracts\View\View;


abstract class Component extends \Illuminate\View\Component
{
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
    public function __construct(null|array $content)
    {
        $this->content = $content;
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
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view(static::$componentFolder . '.' . static::$view, $this->process($this->content));
    }
}
