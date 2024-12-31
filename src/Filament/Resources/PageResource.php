<?php

namespace Jonathanrixhon\Contents\Filament\Resources;

use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextArea;
use Filament\Forms\Components\TextInput;
use Jonathanrixhon\Contents\Models\Page;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Pages\Page as FilamentResourcePage;
use Jonathanrixhon\Contents\Filament\Resources\Concerns\HasContents;
use Jonathanrixhon\Contents\Filament\Resources\PageResource\Pages\EditPage;
use Jonathanrixhon\Contents\Filament\Resources\PageResource\Pages\ListPages;
use Jonathanrixhon\Contents\Filament\Resources\PageResource\Pages\CreatePage;
use Jonathanrixhon\Contents\Filament\RelationManagers\ContentsRelationManager;
use Jonathanrixhon\Contents\Filament\Resources\PageResource\Pages\ManageContents;

class PageResource extends Resource
{
    use HasContents;

    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make(__('contents::page.title.general'))
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
                ->schema([self::contentRepeater()]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('contents::field.title.label'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('route')
                    ->label(__('contents::field.route.label'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label(__('contents::field.description.label'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('contents::field.created_at.label'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalHeading(__('contents::action.content.edit'))
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ContentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPages::route('/'),
            'create' => CreatePage::route('/create'),
            'edit' => EditPage::route('/{record}/edit'),
            'manage-contents' => ManageContents::route('/{record}/contents/edit'),
        ];
    }

    public static function getRecordSubNavigation(FilamentResourcePage $page): array
    {
        return $page->generateNavigationItems([
            EditPage::class,
            ManageContents::class,
        ]);
    }
}
