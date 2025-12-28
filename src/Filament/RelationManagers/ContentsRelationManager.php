<?php

namespace Jonathanrixhon\Contents\Filament\RelationManagers;

use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\RelationManagers\RelationManager;
use Jonathanrixhon\Contents\Filament\Resources\Contents\ContentResource;

class ContentsRelationManager extends RelationManager
{
    protected bool $allowsDuplicates = true;
    
    protected static string $relationship = 'contents';

    public function schema(Schema $schema): Schema
    {
        return ContentResource::schema($schema);
    }

    public function table(Table $table): Table
    {
        return ContentResource::table($table);
    }
}
