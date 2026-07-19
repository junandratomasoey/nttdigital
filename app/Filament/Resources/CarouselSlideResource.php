<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarouselSlideResource\Pages;
use App\Models\CarouselSlide;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CarouselSlideResource extends Resource
{
    protected static ?string $model = CarouselSlide::class;
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationLabel = 'Slide Carousel';
    protected static ?string $modelLabel = 'Slide';
    protected static ?string $pluralModelLabel = 'Slide Carousel';
    protected static ?string $navigationGroup = 'Konten Utama';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Konten Slide')
                ->schema([
                    Forms\Components\TextInput::make('judul')
                        ->label('Judul')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('subjudul')
                        ->label('Sub Judul / Badge')
                        ->placeholder('contoh: 📍 Berbasis di Kupang, NTT')
                        ->maxLength(255),

                    Forms\Components\Textarea::make('deskripsi')
                        ->label('Deskripsi')
                        ->rows(3)
                        ->maxLength(500),

                    Forms\Components\Select::make('warna_tema')
                        ->label('Warna Tema')
                        ->options([
                            'teal'  => '🟢 Teal / Hijau (default)',
                            'biru'  => '🔵 Biru',
                            'ungu'  => '🟣 Ungu',
                        ])
                        ->default('teal')
                        ->required(),

                    Forms\Components\TextInput::make('emoji_icon')
                        ->label('Emoji Icon Latar')
                        ->placeholder('🏘️')
                        ->maxLength(10),
                ])->columns(2),

            Forms\Components\Section::make('Gambar Background (opsional)')
                ->schema([
                    Forms\Components\FileUpload::make('gambar')
                        ->label('Upload Gambar')
                        ->image()
                        ->directory('slides')
                        ->helperText('Gambar akan digunakan sebagai background slide. Format: JPG/PNG, maks 2MB.')
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Tombol Aksi')
                ->schema([
                    Forms\Components\TextInput::make('teks_tombol_utama')
                        ->label('Teks Tombol Utama')
                        ->default('Lihat Portofolio')
                        ->required(),

                    Forms\Components\TextInput::make('link_tombol_utama')
                        ->label('Link Tombol Utama')
                        ->default('#portofolio')
                        ->required(),

                    Forms\Components\TextInput::make('teks_tombol_kedua')
                        ->label('Teks Tombol Kedua')
                        ->placeholder('Konsultasi Gratis'),

                    Forms\Components\TextInput::make('link_tombol_kedua')
                        ->label('Link Tombol Kedua')
                        ->placeholder('#kontak'),
                ])->columns(2),

            Forms\Components\Section::make('Pengaturan')
                ->schema([
                    Forms\Components\TextInput::make('urutan')
                        ->label('Urutan Tampil')
                        ->numeric()
                        ->default(0),

                    Forms\Components\Toggle::make('aktif')
                        ->label('Aktif')
                        ->default(true),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('urutan')
                    ->label('No.')
                    ->sortable()
                    ->width(60),

                Tables\Columns\TextColumn::make('emoji_icon')
                    ->label('')
                    ->width(40),

                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul Slide')
                    ->searchable()
                    ->limit(50),

                Tables\Columns\BadgeColumn::make('warna_tema')
                    ->label('Tema')
                    ->colors([
                        'success' => 'teal',
                        'primary' => 'biru',
                        'warning' => 'ungu',
                    ]),

                Tables\Columns\IconColumn::make('aktif')
                    ->label('Aktif')
                    ->boolean(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->defaultSort('urutan')
            ->reorderable('urutan')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListCarouselSlides::route('/'),
            'create' => Pages\CreateCarouselSlide::route('/create'),
            'edit'   => Pages\EditCarouselSlide::route('/{record}/edit'),
        ];
    }
}
