<?php

namespace App\Filament\Resources\Allergens\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AllergenForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->required()->maxLength(255)->unique(ignoreRecord: true),
                TextInput::make('name')
                    ->required()->maxLength(255),
            ]);
    }
}
