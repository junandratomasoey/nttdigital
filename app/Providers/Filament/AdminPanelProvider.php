<?php

namespace App\Providers\Filament;

use App\Filament\Pages\PengaturanSitus;
use App\Filament\Resources\ArtikelResource;
use App\Filament\Resources\CarouselSlideResource;
use App\Filament\Resources\FaqResource;
use App\Filament\Resources\TestimoniResource;
use App\Filament\Resources\KontakPesanResource;
use App\Filament\Resources\LayananResource;
use App\Filament\Resources\PaketHargaResource;
use App\Filament\Resources\PortofolioResource;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\PesanTerbaruWidget;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::hex('#0F6E56'),
            ])
            ->brandName('NTT Digital Admin')
            ->favicon(asset('favicon.ico'))
            ->resources([
                CarouselSlideResource::class,
                PortofolioResource::class,
                LayananResource::class,
                PaketHargaResource::class,
                KontakPesanResource::class,
                TestimoniResource::class,
                ArtikelResource::class,
                FaqResource::class,
            ])
            ->widgets([
                StatsOverview::class,
                PesanTerbaruWidget::class,
            ])
            ->pages([
                Pages\Dashboard::class,
                PengaturanSitus::class,
            ])
            ->navigationItems([
                \Filament\Navigation\NavigationItem::make('Lihat Website')
                    ->url('/', shouldOpenInNewTab: true)
                    ->icon('heroicon-o-globe-alt')
                    ->sort(99),
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
