<?php

namespace App\Filament\Resources\DigitalProductVersionResource\Pages;

use App\Filament\Resources\DigitalProductVersionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDigitalProductVersions extends ListRecords
{
    protected static string $resource = DigitalProductVersionResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
