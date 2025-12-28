<?php

namespace Jonathanrixhon\Contents\Filament\Resources\Pages;

use BackedEnum;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Jonathanrixhon\Contents\Models\Page;
use Filament\Pages\Enums\SubNavigationPosition;
use Filament\Resources\Pages\Page as FilamentResourcePage;
use Jonathanrixhon\Contents\Filament\Resources\Concerns\HasContents;
use Jonathanrixhon\Contents\Filament\Resources\Pages\Pages\EditPage;
use Jonathanrixhon\Contents\Filament\Resources\Pages\Pages\ListPages;
use Jonathanrixhon\Contents\Filament\Resources\Pages\Pages\CreatePage;
use Jonathanrixhon\Contents\Filament\Resources\Pages\Schemas\PageForm;
use Jonathanrixhon\Contents\Filament\Resources\Pages\Tables\PagesTable;
use Jonathanrixhon\Contents\Filament\Resources\Pages\Pages\ManageContents;
use Jonathanrixhon\Contents\Filament\RelationManagers\ContentsRelationManager;

class PageResource extends Resource
{
    use HasContents;

    protected static ?string $model = Page::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-document';

    protected static ?SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Schema $form): Schema
    {
        return PageForm::configure($form);
    }

    public static function table(Table $table): Table
    {
        return PagesTable::configure($table);
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
