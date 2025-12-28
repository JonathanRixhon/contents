<?php

namespace Jonathanrixhon\Contents\Filament\Resources\Contents\Schemas;

use Filament\Schemas\Schema;
use Jonathanrixhon\Contents\Filament\Resources\Concerns\HasContents;

class ContentForm
{
    use HasContents;

    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            self::header()
                ->columnSpanFull(),
            ...self::groups()
        ]);
    }
}
