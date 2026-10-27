<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PortofolioResource\Pages;
use App\Models\Portofolio;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PortofolioResource extends Resource
{
    protected static ?string $model = Portofolio::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationLabel = 'Portofolio';
    protected static ?string $modelLabel = 'Portofolio';
    protected static ?string $pluralModelLabel = 'Portofolio';
    protected static ?string $navigationGroup = 'Konten Utama';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Proyek')
                ->schema([
                    Forms\Components\TextInput::make('nama_proyek')
                        ->label('Nama Proyek')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(function ($state, Forms\Set $set, ?Portofolio $record) {
                            if (! $record) {
                                $set('slug', \Illuminate\Support\Str::slug($state));
                            }
                        }),

                    Forms\Components\TextInput::make('slug')
                        ->label('Slug')
                        ->unique(ignoreRecord: true)
                        ->maxLength(255)
                        ->helperText('Alamat: nttdigital.site/portofolio/slug. Kosongkan untuk dibuat otomatis.'),

                    Forms\Components\Select::make('kategori')
                        ->label('Kategori')
                        ->options([
                            'Desa'      => 'Desa',
                            'Sekolah'   => 'Sekolah',
                            'UMKM'      => 'UMKM',
                            'Undangan'  => 'Undangan',
                            'Gereja'    => 'Gereja',
                            'Hotel'     => 'Hotel',
                            'Perusahaan'=> 'Perusahaan',
                            'Lainnya'   => 'Lainnya',
                        ])
                        ->required(),

                    Forms\Components\TextInput::make('emoji_icon')
                        ->label('Emoji Icon')
                        ->placeholder('🏘️')
                        ->maxLength(10),

                    Forms\Components\ColorPicker::make('warna_thumb')
                        ->label('Warna Thumbnail'),

                    Forms\Components\Textarea::make('deskripsi')
                        ->label('Deskripsi Singkat')
                        ->rows(2)
                        ->maxLength(200)
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('link_demo')
                        ->label('Link Demo')
                        ->url()
                        ->placeholder('https://demo-desa.nttdigital.site')
                        ->columnSpanFull(),
                ])->columns(2),

            Forms\Components\Section::make('Gambar')
                ->schema([
                    Forms\Components\FileUpload::make('gambar_thumbnail')
                        ->label('Gambar Thumbnail')
                        ->image()
                        ->directory('portofolio')
                        ->maxSize(2048)
                        ->helperText('Gambar preview proyek (juga dipakai saat dibagikan ke WhatsApp/Facebook). JPG/PNG, maks 2MB.')
                        ->columnSpanFull(),
                    Forms\Components\FileUpload::make('galeri')
                        ->label('Galeri tangkapan layar')
                        ->image()->multiple()->reorderable()->maxFiles(9)
                        ->directory('portofolio/galeri')
                        ->maxSize(2048)
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Halaman Detail / Studi Kasus')
                ->collapsible()
                ->schema([
                    Forms\Components\TextInput::make('klien')->label('Nama klien')->maxLength(150)
                        ->helperText('Kosongkan untuk proyek demo.'),
                    Forms\Components\TextInput::make('lokasi')->placeholder('Kab. Kupang')->maxLength(150),
                    Forms\Components\TextInput::make('tahun')->numeric()->minValue(2015)->maxValue(2100),
                    Forms\Components\TagsInput::make('teknologi')->placeholder('Laravel'),
                    Forms\Components\RichEditor::make('konten')
                        ->label('Cerita proyek')
                        ->helperText('Tantangan klien, solusi yang dibuat, dan hasilnya.')
                        ->fileAttachmentsDirectory('portofolio/lampiran')
                        ->toolbarButtons(['h2', 'h3', 'bold', 'italic', 'link', 'bulletList', 'orderedList', 'blockquote', 'attachFiles', 'undo', 'redo'])
                        ->columnSpanFull(),
                    Forms\Components\Repeater::make('fitur')
                        ->label('Fitur utama')
                        ->simple(Forms\Components\TextInput::make('fitur')->required())
                        ->addActionLabel('+ Tambah Fitur')
                        ->reorderable()
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('meta_description')
                        ->label('Deskripsi SEO (opsional)')->rows(2)->maxLength(160)
                        ->columnSpanFull(),
                ])->columns(2),

            Forms\Components\Section::make('Pengaturan')
                ->schema([
                    Forms\Components\TextInput::make('urutan')->label('Urutan')->numeric()->default(0),
                    Forms\Components\Toggle::make('tampilkan_demo')->label('Tampilkan Link Demo')->default(true),
                    Forms\Components\Toggle::make('aktif')->label('Aktif')->default(true),
                ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('urutan')->label('No.')->sortable()->width(60),
                Tables\Columns\TextColumn::make('emoji_icon')->label('')->width(40),
                Tables\Columns\TextColumn::make('nama_proyek')->label('Nama Proyek')->searchable(),
                Tables\Columns\BadgeColumn::make('kategori')->label('Kategori'),
                Tables\Columns\IconColumn::make('tampilkan_demo')->label('Demo')->boolean(),
                Tables\Columns\IconColumn::make('aktif')->label('Aktif')->boolean(),
            ])
            ->defaultSort('urutan')
            ->reorderable('urutan')
            ->actions([
                Tables\Actions\Action::make('lihat')
                    ->label('Lihat')->icon('heroicon-o-eye')->color('gray')
                    ->url(fn (Portofolio $record) => route('portofolio.show', $record))
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPortofolios::route('/'),
            'create' => Pages\CreatePortofolio::route('/create'),
            'edit'   => Pages\EditPortofolio::route('/{record}/edit'),
        ];
    }
}
