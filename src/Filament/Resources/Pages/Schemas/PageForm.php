<?php

namespace Jonathanrixhon\Contents\Filament\Resources\Pages\Schemas;


use Filament\Schemas\Schema;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Jonathanrixhon\Contents\Filament\Resources\Concerns\HasContents;

class PageForm
{
    use HasContents;

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('contents::page.general.label'))
                    ->description(__('contents::page.general.description'))
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->label(__('contents::field.title.label'))
                            ->required(),
                        TextInput::make('route')
                            ->label(__('contents::field.route.label'))
                            ->disabled()
                            ->required(),
                        TextArea::make('description')
                            ->label(__('contents::field.description.label'))
                            ->columnSpanFull()
                    ]),
                Section::make(__('contents::field.contents.label'))
                    ->columnSpanFull()
                    ->schema([self::contentRepeater()]),
            ]);
    }
}
