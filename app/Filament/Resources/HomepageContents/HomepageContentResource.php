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
            Repeater::make('hours')->label('Öffnungszeiten')->schema([
                TextInput::make('label')->label('Wochentage')->required()->maxLength(100),
                TextInput::make('time')->label('Zeiten oder Ruhetag')->required()->maxLength(100),
            ])->defaultItems(0)->addActionLabel('Zeitraum hinzufügen'),
            \Filament\Forms\Components\Toggle::make('hours_provisional')->label('Öffnungszeiten vorläufig'),
            TextInput::make('hours_source')->label('Quelle der Öffnungszeiten')->url(),
            TextInput::make('phone')->label('Telefon')->tel()->maxLength(80),
            TextInput::make('email')->label('E-Mail')->email()->maxLength(255),
            Textarea::make('map_embed_url')->label('Google-Maps-Einbettungsadresse')->rules(['nullable', 'url', 'starts_with:https://www.google.com/maps/embed?'])->helperText('Nur den bestätigten Standort eintragen. Leere Angaben werden nicht veröffentlicht.'),
            TextInput::make('instagram_url')->label('Instagram')->rules(['nullable', 'url', 'starts_with:https://www.instagram.com/'])->maxLength(255),
            TextInput::make('facebook_url')->label('Facebook')->rules(['nullable', 'url', 'starts_with:https://www.facebook.com/'])->maxLength(255),
            TextInput::make('tiktok_url')->label('TikTok')->rules(['nullable', 'url', 'starts_with:https://www.tiktok.com/'])->maxLength(255),
            TextInput::make('wolt_url')->label('Wolt')->url()->maxLength(255),
            TextInput::make('foodora_url')->label('Foodora')->url()->maxLength(255),
            TextInput::make('neotaste_url')->label('NeoTaste')->url()->maxLength(255),
            Textarea::make('imprint_content')->label('Impressum (freigegebener Text)')->rows(12)->helperText('Erst nach rechtlicher Freigabe veröffentlichen.'),
            Textarea::make('privacy_content')->label('Datenschutz (freigegebener Text)')->rows(12)->helperText('Google Maps wird erst nach aktivem Klick geladen. Externe Schriften und weitere Dienste in der Erklärung berücksichtigen.'),
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
