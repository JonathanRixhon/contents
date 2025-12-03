<?php

namespace Jonathanrixhon\Contents\Filament\Resources\Concerns;

use Illuminate\Support\Str;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;

trait HasContents
{
    /**
     * Get the repeater that list all your components.
     */
    public static function contentRepeater(): Repeater
    {
        $schema = array_merge([self::header()], self::groups());

        return Repeater::make('contents')
            ->relationship('contents')
            ->label(__('contents::field.contents.label'))
            ->addActionLabel(__('contents::action.component.add'))
            ->orderColumn('order')
            ->columnSpanFull()
            ->schema($schema)
            ->collapsible()
            ->cloneable()
            ->reorderableWithButtons()
            ->collapsed()
            ->live()
            ->itemLabel(function (array $state) {
                $title = __('contents::action.component.create');

                if ($state['component']) {
                    $component = (new $state['component']($state['content']));
                    $title = $component->{$component::$tableValue} ?? $state['component']::label();
                }

                return Str::limit($title, 30, '…');
            })
            ->mutateRelationshipDataBeforeSaveUsing(fn(array $data) => self::mutateBeforeSave($data))
            ->mutateRelationshipDataBeforeCreateUsing(fn(array $data) => self::mutateBeforeCreate($data))
            ->mutateRelationshipDataBeforeFillUsing(fn(array $data) => self::mutateBeforeFill($data));
    }

    /**
     * Get a section that manage a single component.
     */
    public static function singleComponent(string $component, string|null $relationship = null): Section
    {
        return Section::make()
            ->relationship($relationship)
            ->heading($component::label())
            ->description($component::description())
            ->collapsible()
            ->collapsed()
            ->schema([
                Hidden::make('order')
                    ->default($component::$fixedOrder ?? null),
                Hidden::make('component')
                    ->default($component),
                Group::make()
                    ->statePath('content')
                    ->schema($component::getFields()),
            ])
            ->mutateRelationshipDataBeforeSaveUsing(fn(array $data) => self::mutateBeforeSave($data))
            ->mutateRelationshipDataBeforeCreateUsing(fn(array $data) => self::mutateBeforeCreate($data))
            ->mutateRelationshipDataBeforeFillUsing(fn(array $data) => self::mutateBeforeFill($data));
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
                })
                ->columnSpanFull()
                ->statePath('content');
        }, self::availableComponents());
    }

    /**
     * Get the component's selector and visibility toggle
     */
    protected static function header(): Group
    {
        return Group::make([
            self::componentSelect()
                ->columnSpan(7),
            self::visibilityToggle()
                ->inline(false)
                ->default(true)
                ->columnSpan(1),
        ])->columns(8);
    }

    /**
     * Get the component select field
     */
    protected static function componentSelect(): Select
    {
        return Select::make('component')
            ->label(__('contents::field.component.label'))
            ->options(self::availableComponentOptions())
            ->columnSpanFull()
            ->live()
            ->disabled(fn($state) => $state ? true : false)
            ->dehydrated()
            ->required();
    }

    /**
     * Get the component visible field
     */
    public static function visibilityToggle(): Toggle
    {
        return Toggle::make('visible')
            ->label(__('contents::field.visible.label'));
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

    protected static function mutateBeforeCreate(array $data): array
    {
        return self::mutateBeforeSave($data);
    }

    protected static function mutateBeforeSave(array $data): array
    {
        return method_exists($data['component'], 'mutateBeforeSave')
            ? $data['component']::mutateBeforeSave($data)
            : $data;
    }

    protected static function mutateBeforeFill(array $data): array
    {
        return method_exists($data['component'], 'mutateBeforeFill')
            ? $data['component']::mutateBeforeFill($data)
            : $data;
    }
}
