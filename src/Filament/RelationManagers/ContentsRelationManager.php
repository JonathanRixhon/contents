<?php

namespace Jonathanrixhon\Contents\Filament\RelationManagers;

use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\RelationManagers\RelationManager;
use Jonathanrixhon\Contents\Filament\Resources\ContentResource;

class ContentsRelationManager extends RelationManager
{
    protected static string $relationship = 'contents';

    public function form(Form $form): Form
    {
        return ContentResource::form($form);
    }


    public function table(Table $table): Table
    {
        return ContentResource::table($table);
    }
}
