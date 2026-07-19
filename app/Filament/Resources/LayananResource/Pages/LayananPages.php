<?php

namespace App\Filament\Resources\LayananResource\Pages;

use App\Filament\Resources\LayananResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;

class ListLayanans extends ListRecords
{
    protected static string $resource = LayananResource::class;
    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}

class CreateLayanan extends CreateRecord
{
    protected static string $resource = LayananResource::class;
}

class EditLayanan extends EditRecord
{
    protected static string $resource = LayananResource::class;
    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
