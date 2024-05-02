<?php

namespace Jonathanrixhon\Contents\Filament\Resources\PageResource\Pages;

use Filament\Resources\Pages\EditRecord;
use Jonathanrixhon\Contents\Filament\Resources\PageResource;

class EditPage extends EditRecord
{
    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (method_exists(PageResource::class, 'process')) {
            return PageResource::process($data);
        }
        return $data;
    }


    public function getRelationManagers(): array
    {
        return [];
    }
}
