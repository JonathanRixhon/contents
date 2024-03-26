<?php

namespace Jonathanrixhon\Contents\Filament\Resources;

use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Jonathanrixhon\Contents\Models\Content;
use Jonathanrixhon\Contents\Filament\Resources\Concerns\HasContents;

class ContentResource extends Resource
{
    use HasContents;

    protected static ?string $model = Content::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form->schema([self::componentSelect(), ...self::groups()]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('order')
            ->reorderable('order')
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('component')
                    ->formatStateUsing(function (Content $record) {
                        return $record->content[$record->component::$tableValue] ?? 'No content';
                    })
                    ->tooltip(function (Content $record) {
                        return $record->component::description();
                    })
                    ->description(function (Content $record) {
                        return $record->component::label();
                    }),
                Tables\Columns\IconColumn::make('visible')
                    ->boolean()
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
