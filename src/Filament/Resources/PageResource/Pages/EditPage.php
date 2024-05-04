<?php

namespace Jonathanrixhon\Contents\Filament\Resources\PageResource\Pages;

use Filament\Resources\Pages\EditRecord;
use Jonathanrixhon\Contents\Filament\Resources\PageResource;

class EditPage extends EditRecord
{
    protected static string $resource = PageResource::class;

    public function getTitle(): string
    {
        return __('contents::action.page.edit');
    }

    public static function getNavigationLabel(): string
    {
        return __('contents::action.page.edit');
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getRelationManagers(): array
    {
        return [];
    }
}
