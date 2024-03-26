<?php

namespace Jonathanrixhon\Contents\Filament\Pages;

use Filament\Forms\Form;
use Filament\Tables\Table;
use Jonathanrixhon\Contents\Filament\Resources\ContentResource;

class ManageContents extends \Filament\Resources\Pages\ManageRelatedRecords
{
    protected static string $relationship = 'contents';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationLabel(): string
    {
        return 'Contents';
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
