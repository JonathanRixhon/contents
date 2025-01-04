<?php

namespace Jonathanrixhon\Contents\Filament\Resources;

use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
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
        return $form->schema([
            self::header()
                ->columnSpanFull(),
            ...self::groups()
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('order')
            ->reorderable('order')
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        return self::mutateBeforeSave($data);
                    })
            ])
            ->columns([
                Tables\Columns\TextColumn::make('component')
                    ->label(__('contents::field.component.label'))
                    ->formatStateUsing(function (Content $record) {
                        $component = $record->component
                            ? new $record->component($record->content)
                            : null;
                        return $component->getTableTitle() ?? 'No content';
                    })
                    ->tooltip(function (Content $record) {
                        return $record->component::description();
                    })
                    ->description(function (Content $record) {
                        return $record->component::label();
                    }),
                Tables\Columns\IconColumn::make('visible')
                    ->label(__('contents::field.visible.label'))
                    ->boolean()
            ])
            ->actions(self::actions())
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function actions(): ActionGroup
    {
        return ActionGroup::make([
            Tables\Actions\ReplicateAction::make()
                ->modalHeading(__('contents::action.content.duplicate')),
            Tables\Actions\EditAction::make()
                ->modalHeading(__('contents::action.content.edit'))
                ->mutateRecordDataUsing(fn(array $data) => self::mutateBeforeFill($data))
                ->mutateFormDataUsing(fn(array $data) => self::mutateBeforeSave($data)),
            Tables\Actions\DeleteAction::make()
                ->modalHeading(__('contents::action.content.delete'))
        ]);
    }
}
