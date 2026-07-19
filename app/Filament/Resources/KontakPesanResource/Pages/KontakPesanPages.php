<?php

namespace App\Filament\Resources\KontakPesanResource\Pages;

use App\Filament\Resources\KontakPesanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\EditRecord;

class ListKontakPesans extends ListRecords
{
    protected static string $resource = KontakPesanResource::class;
    protected function getHeaderActions(): array { return []; }
}

class EditKontakPesan extends EditRecord
{
    protected static string $resource = KontakPesanResource::class;
    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
