<?php

namespace Jonathanrixhon\Contents\Filament\Pages;

use Filament\Forms\Form;
use Filament\Tables\Table;
use Jonathanrixhon\Contents\Filament\Resources\ContentResource;

class ManageContents extends \Filament\Resources\Pages\ManageRelatedRecords
{
    protected static string $relationship = 'contents';

    protected static ?string $navigationIcon = 'heroicon-o-square-3-stack-3d';

    public function getTitle(): string
    {
        return __('contents::action.content.edit');
    }


    public static function getNavigationLabel(): string
    {
        return __('contents::page.manage-contents.title');
    }

    public function form(Form $form): Form
    {
        return ContentResource::form($form);
    }

    public function table(Table $table): Table
    {
        return ContentResource::table($table);
    }
}
