<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

/**
 * Halaman admin untuk mengubah tabel site_settings:
 * identitas, kontak, media sosial, SEO, dan kode pelacakan.
 */
class PengaturanSitus extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Pengaturan Situs';
    protected static ?string $title = 'Pengaturan Situs';
    protected static ?string $navigationGroup = 'Manajemen';
    protected static ?int $navigationSort = 9;
    protected static string $view = 'filament.pages.pengaturan-situs';

    public ?array $data = [];

    /** Semua key yang dikelola halaman ini. */
    protected const KEYS = [
        'site_nama', 'site_tagline', 'site_deskripsi',
        'site_email', 'site_whatsapp', 'site_alamat', 'jam_operasional', 'site_gmaps_embed',
        'site_instagram', 'site_facebook', 'site_tiktok',
        'jumlah_proyek', 'jumlah_kategori', 'respon_jam',
        'seo_og_image', 'seo_google_verification',
        'tracking_ga4_id', 'tracking_meta_pixel_id',
    ];

    public function mount(): void
    {
        $nilai = SiteSetting::whereIn('key', self::KEYS)->pluck('value', 'key')->all();
        $this->form->fill(array_merge(array_fill_keys(self::KEYS, null), $nilai));
    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->schema([
                Forms\Components\Tabs::make()->tabs([
                    Forms\Components\Tabs\Tab::make('Identitas')->icon('heroicon-o-identification')->schema([
                        Forms\Components\TextInput::make('site_nama')->label('Nama situs')->required(),
                        Forms\Components\TextInput::make('site_tagline')->label('Tagline')
                            ->helperText('Dipakai sebagai judul beranda di Google.'),
                        Forms\Components\Textarea::make('site_deskripsi')->label('Deskripsi singkat')->rows(3)->maxLength(300)
                            ->helperText('Deskripsi default untuk Google & media sosial (120–160 karakter ideal).'),
                        Forms\Components\Fieldset::make('Angka statistik di beranda')->schema([
                            Forms\Components\TextInput::make('jumlah_proyek')->label('Proyek selesai')->placeholder('15+'),
                            Forms\Components\TextInput::make('jumlah_kategori')->label('Kategori website')->placeholder('7+'),
                            Forms\Components\TextInput::make('respon_jam')->label('Waktu respon')->placeholder('24 jam'),
                        ])->columns(3),
                    ]),
                    Forms\Components\Tabs\Tab::make('Kontak')->icon('heroicon-o-phone')->schema([
                        Forms\Components\TextInput::make('site_whatsapp')->label('Nomor WhatsApp')
                            ->required()->placeholder('6281234567890')
                            ->regex('/^62\d{8,13}$/')
                            ->helperText('Format internasional tanpa + dan tanpa spasi, diawali 62.'),
                        Forms\Components\TextInput::make('site_email')->label('Email')->email(),
                        Forms\Components\TextInput::make('site_alamat')->label('Alamat'),
                        Forms\Components\TextInput::make('jam_operasional')->label('Jam operasional'),
                        Forms\Components\TextInput::make('site_gmaps_embed')->label('URL embed Google Maps')
                            ->url()->helperText('Google Maps → Bagikan → Sematkan peta → salin isi src="..." saja.'),
                    ])->columns(2),
                    Forms\Components\Tabs\Tab::make('Media Sosial')->icon('heroicon-o-share')->schema([
                        Forms\Components\TextInput::make('site_instagram')->label('Instagram')->url()->placeholder('https://instagram.com/...'),
                        Forms\Components\TextInput::make('site_facebook')->label('Facebook')->url()->placeholder('https://facebook.com/...'),
                        Forms\Components\TextInput::make('site_tiktok')->label('TikTok')->url()->placeholder('https://tiktok.com/@...'),
                    ]),
                    Forms\Components\Tabs\Tab::make('SEO & Pelacakan')->icon('heroicon-o-chart-bar')->schema([
                        Forms\Components\FileUpload::make('seo_og_image')->label('Gambar default saat dibagikan (OG image)')
                            ->image()->directory('seo')->maxSize(2048)
                            ->helperText('1200×630 px. Muncul saat link dibagikan ke WhatsApp/Facebook.'),
                        Forms\Components\TextInput::make('seo_google_verification')->label('Kode verifikasi Google Search Console')
                            ->helperText('Isi bagian content="..." dari tag meta verifikasi.'),
                        Forms\Components\TextInput::make('tracking_ga4_id')->label('Google Analytics 4 – Measurement ID')
                            ->placeholder('G-XXXXXXXXXX')->regex('/^G-[A-Z0-9]+$/'),
                        Forms\Components\TextInput::make('tracking_meta_pixel_id')->label('Meta (Facebook) Pixel ID')
                            ->placeholder('123456789012345')->numeric(),
                    ]),
                ])->persistTabInQueryString(),
            ]);
    }

    public function simpan(): void
    {
        foreach ($this->form->getState() as $key => $value) {
            if (in_array($key, self::KEYS, true)) {
                SiteSetting::set($key, $value ?? '');
            }
        }

        Notification::make()->title('Pengaturan disimpan')->success()->send();
    }
}
