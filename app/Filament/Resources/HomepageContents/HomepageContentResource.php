<?php
namespace App\Filament\Resources\HomepageContents;

use App\Models\HomepageContent;
use App\Filament\Resources\HomepageContents\Pages\EditHomepageContent;
use App\Filament\Resources\HomepageContents\Pages\ListHomepageContents;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;

class HomepageContentResource extends Resource
{
    protected static ?string $model = HomepageContent::class;
    protected static ?string $modelLabel = 'Startseiteninhalt';
    protected static ?string $pluralModelLabel = 'Startseite';
    protected static ?string $navigationLabel = 'Startseite';
    public static function canCreate(): bool { return false; }
    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool { return false; }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('about_heading')->label('Überschrift über MORANO+')->maxLength(255),
            Textarea::make('about_text')->label('Über MORANO+')->rows(4),
            FileUpload::make('about_image')->label('Bild über MORANO+')->image()->disk('public')->directory('homepage')->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])->maxSize(5120),
            Textarea::make('highlights_empty_text')->label('Text ohne ausgewählte Highlights'),
            Textarea::make('offers_empty_text')->label('Text ohne aktuelle Angebote'),
            Textarea::make('address')->label('Bestätigte Adresse'),
            Repeater::make('hours')->label('Bestätigte Öffnungszeiten')->schema([
                TextInput::make('label')->label('Wochentage')->required()->maxLength(100),
                TextInput::make('time')->label('Zeiten oder Ruhetag')->required()->maxLength(100),
            ])->defaultItems(0)->addActionLabel('Zeitraum hinzufügen'),
            TextInput::make('phone')->label('Telefon')->tel()->maxLength(80),
            TextInput::make('email')->label('E-Mail')->email()->maxLength(255),
            Textarea::make('map_embed_url')->label('Google-Maps-Einbettungsadresse')->rules(['nullable', 'url', 'starts_with:https://www.google.com/maps/embed?'])->helperText('Nur den bestätigten Standort eintragen. Leere Angaben werden nicht veröffentlicht.'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([TextColumn::make('about_heading')->label('Startseite')])->recordActions([EditAction::make()]);
    }

    public static function getPages(): array
    {
        return ['index' => ListHomepageContents::route('/'), 'edit' => EditHomepageContent::route('/{record}/edit')];
    }
}
