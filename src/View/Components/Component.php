<?php

namespace Jonathanrixhon\Contents\View\Components;

use App\View\Components\SlidingText;
use Closure;
use ReflectionClass;
use Illuminate\Contracts\View\View;
use Illuminate\View\ComponentAttributeBag;

abstract class Component extends \Illuminate\View\Component
{
    /**
     * the component's content
     */
    public array|null $content;

    /**
     * the component's blade view
     */
    protected static string|null $view = null;

    /**
     * the component's classname
     */
    protected static string|null $className = null;

    /**
     * the component's attribute used to describe its content
     */
    public static string $tableValue = 'title';

    /**
     * the component folder's path
     */
    public static string $componentFolder = 'components';

    /**
     * the component's fixed order
     */
    public static int|null $fixedOrder = null;

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
     * Get the content's view
     */
    public static function getView()
    {
        if (static::$view) {
            return static::$view;
        }

        $className = class_basename(static::class);
        return str($className)->kebab();
    }

    /**
     * Get the component's class
     */
    public static function getClassName()
    {
        if (static::$className) {
            return static::$className;
        }

        $className = class_basename(static::class);
        return str($className)->kebab();
    }

    /**
     * Get the table title
     */
    public function getTableTitle(): string
    {
        return $this->content(static::$tableValue);
    }

    /**
     * Get the content's value
     */
    protected function content(string $key): mixed
    {
        return data_get($this->content, $key) ?? $this->{$key} ?? null;
    }

    /**
     * Get the content's fields
     */
    public static function getFields()
    {
        return static::fields();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $content = $this->subComponent
            ? $this->content
            : $this->process($this->content);

        return function (array $data) use ($content) {
            $attributes = $this->manageAttributes($data['attributes'], $content);
            $this->withAttributes($attributes->getAttributes());

            return view(static::$componentFolder . '.' . self::getView(), $content);
        };
    }


    /**
     * Build classes
     */
    public function manageAttributes(ComponentAttributeBag $attributes, array $content = []): ComponentAttributeBag
    {
        $class = array_reduce($content['modifiers'] ?? [], function ($carry, $modifier) {
            $carry .= ' ' . static::getClassName() . '--' . $modifier;
            return $carry;
        }, '');

        return $attributes->merge(compact('class'));
    }

    /**
     * Mutate translated datas before save
     */
    public static function mutateBeforeSave(array $data): array
    {
        return $data;
    }

    /**
     * Mutate translated datas before save
     */
    public static function mutateBeforeFill(array $data): array
    {
        return $data;
    }

    /**
     * Mutate translated datas before create
     */
    public static function mutateBeforeCreate(array $data): array
    {
        return $data;
    }
}
