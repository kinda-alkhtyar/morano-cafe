<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required(),
                TextInput::make('name')
                    ->required()->maxLength(255),
                TextInput::make('slug')
                    ->required()->maxLength(255)->unique(ignoreRecord: true),
                Textarea::make('description')
                    ->columnSpanFull(),
                Textarea::make('ingredients')->label('Zutaten')->columnSpanFull(),
                TextInput::make('price')->label('Website-Preis in Cent')->integer()->minValue(0),
                TextInput::make('reference_price')->label('Wolt-Referenzpreis in Cent')->integer()->minValue(0),
                FileUpload::make('image_path')
                    ->image()->disk('public')->directory('products')->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])->maxSize(5120),
                TextInput::make('image_review_note')->label('Bildprüfung')->maxLength(255),
                Toggle::make('is_available')
                    ->required(),
                Toggle::make('is_featured')
                    ->required(),
                TextInput::make('sort_order')
                    ->required()->integer()->minValue(0)
                    ->default(0),
                Select::make('allergens')->label('Bestätigte Allergene')->relationship('allergens', 'name')->multiple(),
            ]);
    }
}
