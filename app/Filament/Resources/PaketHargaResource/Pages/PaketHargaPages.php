<?php

namespace App\Filament\Resources\PaketHargaResource\Pages;

use App\Filament\Resources\PaketHargaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;

class ListPaketHargas extends ListRecords
{
    protected static string $resource = PaketHargaResource::class;
    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}

class CreatePaketHarga extends CreateRecord
{
    protected static string $resource = PaketHargaResource::class;
}

class EditPaketHarga extends EditRecord
{
    protected static string $resource = PaketHargaResource::class;
    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
