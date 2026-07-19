<?php

namespace App\Filament\Resources\PortofolioResource\Pages;

use App\Filament\Resources\PortofolioResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;

class ListPortofolios extends ListRecords
{
    protected static string $resource = PortofolioResource::class;
    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}

class CreatePortofolio extends CreateRecord
{
    protected static string $resource = PortofolioResource::class;
}

class EditPortofolio extends EditRecord
{
    protected static string $resource = PortofolioResource::class;
    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
