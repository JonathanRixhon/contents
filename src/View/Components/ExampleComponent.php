<?php

namespace Jonathanrixhon\Contents\View\Components;

use Filament\Forms\Components\RichEditor;

class ExampleComponent extends Concerns\Component
{
    public static string $view = 'example-component';

    /**
     * Get the component label
     */
    public static function label(): string
    {
        return "Example component";
    }

    /**
     * Get the component label
     */
    public static function description(): string
    {
        return "A description";
    }

    /**
     * Get the admin fields
     */
    public static function fields(): array
    {
        return [
            RichEditor::make('content.text')
                ->columnSpanFull()
                ->rules(['required'])
        ];
    }
}
