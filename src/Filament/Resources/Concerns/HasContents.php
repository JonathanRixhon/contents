<?php

namespace Jonathanrixhon\Contents\Filament\Resources\Concerns;

use Filament\Facades\Filament;
use Filament\Forms\Get;
use Illuminate\Support\Str;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;

trait HasContents
{
    /**
     * Get the repeater that list all your components.
     */
    public static function contentRepeater(): Repeater
    {
        $schema = array_merge([self::componentSelect()], self::groups());

        return Repeater::make('contents')
            ->label(__('contents::label.contents'))
            ->live(onBlur: true)
            ->relationship()
            ->orderColumn('order')
            ->columnSpanFull()
            ->schema($schema)
            ->addActionLabel(__('contents::action.component.add'))
            ->collapsible()
            ->cloneable()
            ->reorderableWithButtons()
            ->collapsed()
            ->itemLabel(function (array $state) {
                $title = __('contents::action.component.create');
                if ($state['component']) {
                    $component = (new $state['component']($state['content']));
                    $title = $component->{$component::$tableValue} ?? $state['component']::label();
                }

                return Str::limit($title, 30, '…');
            })
            ->mutateRelationshipDataBeforeSaveUsing(function (array $data): array {
                return method_exists($data['component'], 'mutateBeforeSave')
                    ? $data['component']::mutateBeforeSave($data)
                    : $data;
            })
            ->mutateRelationshipDataBeforeFillUsing(function (array $data): array {
                return method_exists($data['component'], 'mutateBeforeFill')
                    ? $data['component']::mutateBeforeFill($data)
                    : $data;
            });
    }

    /**
     * Get an array of component group used in the repeater
     * to show/hide the correct fields
     *
     * TODO: find a way to improve it (avoid listing all groups).
     */
    protected static function groups(): array
    {
        return array_map(function ($component) {
            return Group::make($component::getFields())
                ->visible(function (Get $get) use ($component) {
                    return $get('component') === $component;
                })->columnSpanFull();
        }, self::availableComponents());
    }

    /**
     * Get the compontent select field
     */
    protected static function componentSelect(): Select
    {
        return Select::make('component')
            ->label(__('contents::label.component'))
            ->options(self::availableComponentOptions())
            ->columnSpanFull()
            ->live()
            ->disabled(fn ($state) => $state ? true : false)
            ->required();
    }

    /**
     * List all the available components based on
     * the abstract availableComponents method.
     */
    protected static function availableComponentOptions(): array
    {
        return array_reduce(self::availableComponents(), function ($carry, $component) {
            $carry[$component] = $component::label();
            return $carry;
        }, []);
    }

    /**
     * List all the available for the current resource.
     */
    public static function availableComponents(): array
    {
        return config('contents.components');
    }
}
