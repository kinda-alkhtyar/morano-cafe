<?php

namespace App\Filament\Resources\Offers\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class OfferForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()->maxLength(255),
                Textarea::make('description')
                    ->columnSpanFull(),
                Textarea::make('redemption_conditions')->label('Einlösebedingungen')->columnSpanFull(),
                TextInput::make('source_url')->label('Externer Angebotslink')->url()->maxLength(255),
                FileUpload::make('image_path')
                    ->image()->disk('public')->directory('offers')->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])->maxSize(5120),
                TextInput::make('original_price')
                    ->integer()->minValue(0)->prefix('¢'),
                TextInput::make('offer_price')
                    ->integer()->minValue(0)->lte('original_price')->prefix('¢'),
                DateTimePicker::make('starts_at'),
                DateTimePicker::make('ends_at'),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
