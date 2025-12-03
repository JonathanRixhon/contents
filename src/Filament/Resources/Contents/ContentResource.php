<?php

namespace Jonathanrixhon\Contents\Filament\Resources\Contents;

use BackedEnum;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ReplicateAction;
use Jonathanrixhon\Contents\Models\Content;
use Jonathanrixhon\Contents\Filament\Resources\Concerns\HasContents;
use Jonathanrixhon\Contents\Filament\Resources\Contents\Schemas\ContentForm;

class ContentResource extends Resource
{
    use HasContents;

    protected static ?string $model = Content::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Schema $schema): Schema
    {
        return ContentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('order')
            ->reorderable('order')
            ->headerActions([
                CreateAction::make()
                    ->mutateDataUsing(function (array $data): array {
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
            ->recordActions(self::actions())
            // ->bulkActions([
            //     BulkActionGroup::make([
            //         DeleteBulkAction::make(),
            //     ]),
            // ])
        ;
    }

    public static function actions(): ActionGroup
    {
        return ActionGroup::make([
            ReplicateAction::make()
                ->modalHeading(__('contents::action.content.duplicate')),
            EditAction::make()
                ->modalHeading(__('contents::action.content.edit'))
                ->mutateRecordDataUsing(fn(array $data) => self::mutateBeforeFill($data))
                ->mutateDataUsing(fn(array $data) => self::mutateBeforeSave($data)),
            DeleteAction::make()
                ->modalHeading(__('contents::action.content.delete'))
        ]);
    }
}
