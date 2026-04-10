<?php

namespace App\Filament\Resources\GuideCategoryResource\Pages;

use App\Filament\Resources\GuideCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGuideCategory extends EditRecord
{
    protected static string $resource = GuideCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}