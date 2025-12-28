<?php

namespace Jonathanrixhon\Contents\Filament\Resources\Pages\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class PagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label(__('contents::field.title.label'))
                    ->searchable(),
                TextColumn::make('route')
                    ->label(__('contents::field.route.label'))
                    ->searchable(),
                TextColumn::make('description')
                    ->label(__('contents::field.description.label'))
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label(__('contents::field.created_at.label'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ]);
        // ->recordActions([
        //     EditAction::make()
        //         ->modalHeading(__('contents::action.content.edit'))
        // ])
        // ->bulkActions([
        //     BulkActionGroup::make([
        //         DeleteBulkAction::make(),
        //     ]),
        // ]);
    }
}
