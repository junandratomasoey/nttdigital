<?php

namespace App\Filament\Widgets;

use App\Models\KontakPesan;
use App\Models\Portofolio;
use App\Models\CarouselSlide;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $pesanBaru    = KontakPesan::baru()->count();
        $totalPesan   = KontakPesan::count();
        $totalPorto   = Portofolio::aktif()->count();
        $totalSlide   = CarouselSlide::aktif()->count();

        return [
            Stat::make('Pesan Baru', $pesanBaru)
                ->description('Belum dibalas')
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->color($pesanBaru > 0 ? 'danger' : 'success')
                ->chart([0, $pesanBaru]),

            Stat::make('Total Pesan Masuk', $totalPesan)
                ->description('Semua pesan kontak')
                ->descriptionIcon('heroicon-m-inbox')
                ->color('info'),

            Stat::make('Portofolio Aktif', $totalPorto)
                ->description('Demo website ditampilkan')
                ->descriptionIcon('heroicon-m-briefcase')
                ->color('success'),

            Stat::make('Slide Carousel', $totalSlide)
                ->description('Slide hero aktif')
                ->descriptionIcon('heroicon-m-photo')
                ->color('warning'),
        ];
    }
}
