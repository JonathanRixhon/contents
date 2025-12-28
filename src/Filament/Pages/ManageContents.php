<?php

namespace Jonathanrixhon\Contents\Filament\Pages;

use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Jonathanrixhon\Contents\Filament\Resources\Contents\ContentResource;

class ManageContents extends \Filament\Resources\Pages\ManageRelatedRecords
{
    protected static string $relationship = 'contents';

    //protected static ?string $navigationIcon = 'heroicon-o-square-3-stack-3d';

    public function getTitle(): string
    {
        return __('contents::action.content.edit');
    }

    public static function getNavigationLabel(): string
    {
        return __('contents::page.manage-contents.title');
    }

    public function form(Schema $schema): Schema
    {
        return ContentResource::form($schema);
    }

    public function table(Table $table): Table
    {
        return ContentResource::table($table);
    }
}
