<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaketHargaResource\Pages;
use App\Models\PaketHarga;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PaketHargaResource extends Resource
{
    protected static ?string $model = PaketHarga::class;
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationLabel = 'Paket Harga';
    protected static ?string $modelLabel = 'Paket';
    protected static ?string $pluralModelLabel = 'Paket Harga';
    protected static ?string $navigationGroup = 'Konten Utama';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Paket')
                ->schema([
                    Forms\Components\TextInput::make('nama')
                        ->label('Nama Paket')
                        ->required()
                        ->maxLength(100),

                    Forms\Components\TextInput::make('label_badge')
                        ->label('Label Badge')
                        ->placeholder('⭐ Paling Populer')
                        ->maxLength(100),

                    Forms\Components\TextInput::make('harga')
                        ->label('Harga')
                        ->required()
                        ->placeholder('Rp 3.000.000')
                        ->maxLength(50),

                    Forms\Components\TextInput::make('satuan')
                        ->label('Satuan')
                        ->default('/ proyek')
                        ->maxLength(50),
                ])->columns(2),

            Forms\Components\Section::make('Fitur Paket')
                ->schema([
                    Forms\Components\Repeater::make('fitur')
                        ->label('Daftar Fitur')
                        ->simple(
                            Forms\Components\TextInput::make('fitur')
                                ->placeholder('Contoh: 10 halaman website')
                                ->required(),
                        )
                        ->addActionLabel('+ Tambah Fitur')
                        ->columnSpanFull()
                        ->reorderable(),
                ]),

            Forms\Components\Section::make('Pengaturan')
                ->schema([
                    Forms\Components\TextInput::make('urutan')
                        ->label('Urutan')
                        ->numeric()
                        ->default(0),
                    Forms\Components\Toggle::make('unggulan')
                        ->label('Tandai sebagai Unggulan (border hijau)')
                        ->default(false),
                    Forms\Components\Toggle::make('aktif')
                        ->label('Aktif')
                        ->default(true),
                ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('urutan')->label('No.')->sortable()->width(60),
                Tables\Columns\TextColumn::make('nama')->label('Nama Paket')->searchable(),
                Tables\Columns\TextColumn::make('harga')->label('Harga'),
                Tables\Columns\IconColumn::make('unggulan')->label('Unggulan')->boolean(),
                Tables\Columns\IconColumn::make('aktif')->label('Aktif')->boolean(),
            ])
            ->defaultSort('urutan')
            ->reorderable('urutan')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPaketHargas::route('/'),
            'create' => Pages\CreatePaketHarga::route('/create'),
            'edit'   => Pages\EditPaketHarga::route('/{record}/edit'),
        ];
    }
}
