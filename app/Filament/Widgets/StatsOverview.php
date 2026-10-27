<?php

namespace App\Filament\Widgets;

use App\Models\Artikel;
use App\Models\KontakPesan;
use App\Models\Portofolio;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $pesanBaru    = KontakPesan::baru()->count();
        $leadBulanIni = KontakPesan::where('created_at', '>=', now()->startOfMonth())->count();
        $leadBulanLalu = KontakPesan::whereBetween('created_at', [now()->subMonthNoOverflow()->startOfMonth(), now()->startOfMonth()])->count();

        // Tren lead 7 hari terakhir untuk grafik kecil
        $tren = collect(range(6, 0))->map(fn ($h) =>
            KontakPesan::whereDate('created_at', now()->subDays($h)->toDateString())->count()
        )->all();

        $artikelTerbit = Artikel::terbit()->count();
        $totalDilihat  = (int) Artikel::sum('dilihat');

        return [
            Stat::make('Pesan Baru', $pesanBaru)
                ->description('Belum dibalas')
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->color($pesanBaru > 0 ? 'danger' : 'success'),

            Stat::make('Lead Bulan Ini', $leadBulanIni)
                ->description("Bulan lalu: {$leadBulanLalu}")
                ->descriptionIcon($leadBulanIni >= $leadBulanLalu ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->chart($tren)
                ->color('info'),

            Stat::make('Artikel Terbit', $artikelTerbit)
                ->description(number_format($totalDilihat, 0, ',', '.') . ' kali dibaca')
                ->descriptionIcon('heroicon-m-newspaper')
                ->color('warning'),

            Stat::make('Portofolio Aktif', Portofolio::aktif()->count())
                ->description('Demo website ditampilkan')
                ->descriptionIcon('heroicon-m-briefcase')
                ->color('success'),
        ];
    }
}
