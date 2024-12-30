<?php

namespace Jonathanrixhon\Contents\Filament\Resources\PageResource\Pages;

use Filament\Tables\Table;
use Jonathanrixhon\Contents\Filament\Resources\PageResource;
use Jonathanrixhon\Contents\Filament\Resources\ContentResource;
use Jonathanrixhon\Contents\Filament\Pages\ManageContents as ManageContentsBase;

class ManageContents extends ManageContentsBase
{
    protected static string $resource = PageResource::class;

    public static function getNavigationLabel(): string
    {
        return __('contents::label.contents');
    }
    
    public function table(Table $table): Table
    {
        return ContentResource::table($table);
    }
}
