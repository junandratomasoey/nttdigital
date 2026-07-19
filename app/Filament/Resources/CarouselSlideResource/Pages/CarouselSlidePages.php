<?php

namespace App\Filament\Resources\CarouselSlideResource\Pages;

use App\Filament\Resources\CarouselSlideResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;

class ListCarouselSlides extends ListRecords
{
    protected static string $resource = CarouselSlideResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}

class CreateCarouselSlide extends CreateRecord
{
    protected static string $resource = CarouselSlideResource::class;
}

class EditCarouselSlide extends EditRecord
{
    protected static string $resource = CarouselSlideResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
