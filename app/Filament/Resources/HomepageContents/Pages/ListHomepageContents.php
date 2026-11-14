<?php
namespace App\Filament\Resources\HomepageContents\Pages;

use App\Filament\Resources\HomepageContents\HomepageContentResource;
use Filament\Resources\Pages\ListRecords;

class ListHomepageContents extends ListRecords
{
    protected static string $resource = HomepageContentResource::class;
}
