<?php

namespace App\Filament\Resources\KontakPesanResource\Pages;

use App\Filament\Resources\KontakPesanResource;
use Filament\Resources\Pages\ListRecords;

class ListKontakPesans extends ListRecords
{
    protected static string $resource = KontakPesanResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
