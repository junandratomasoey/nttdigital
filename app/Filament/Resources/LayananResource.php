<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LayananResource\Pages;
use App\Models\Layanan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class LayananResource extends Resource
{
    protected static ?string $model = Layanan::class;
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    protected static ?string $navigationLabel = 'Layanan';
    protected static ?string $modelLabel = 'Layanan';
    protected static ?string $pluralModelLabel = 'Layanan';
    protected static ?string $navigationGroup = 'Konten Utama';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Layanan')
                ->schema([
                    Forms\Components\TextInput::make('nama')
                        ->label('Nama Layanan')
                        ->required()
                        ->maxLength(100)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, Forms\Set $set) =>
                            $set('slug', Str::slug($state))
                        ),

                    Forms\Components\TextInput::make('slug')
                        ->label('Slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(100),

                    Forms\Components\TextInput::make('emoji_icon')
                        ->label('Emoji Icon')
                        ->placeholder('🌐')
                        ->maxLength(10),

                    Forms\Components\ColorPicker::make('warna_bg')
                        ->label('Warna Background Icon'),

                    Forms\Components\Textarea::make('deskripsi')
                        ->label('Deskripsi')
                        ->rows(3)
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('harga_mulai')
                        ->label('Harga Mulai')
                        ->placeholder('Rp 2.500.000')
                        ->maxLength(50),

                    Forms\Components\TextInput::make('tagline')
                        ->label('Tagline (subjudul halaman detail)')
                        ->maxLength(255),
                ])->columns(2),

            Forms\Components\Section::make('Halaman Detail Layanan')
                ->description('Tampil di nttdigital.site/layanan/slug')
                ->collapsible()
                ->schema([
                    Forms\Components\RichEditor::make('konten')
                        ->label('Penjelasan lengkap')
                        ->fileAttachmentsDirectory('layanan/lampiran')
                        ->toolbarButtons(['h2', 'h3', 'bold', 'italic', 'link', 'bulletList', 'orderedList', 'blockquote', 'attachFiles', 'undo', 'redo'])
                        ->columnSpanFull(),
                    Forms\Components\Repeater::make('fitur')
                        ->label('Yang didapat klien')
                        ->simple(Forms\Components\TextInput::make('fitur')->required()->placeholder('Contoh: Layanan surat online'))
                        ->addActionLabel('+ Tambah Fitur')
                        ->reorderable()
                        ->columnSpanFull(),
                    Forms\Components\FileUpload::make('gambar')
                        ->label('Gambar ilustrasi')
                        ->image()->imageEditor()->directory('layanan')->maxSize(2048)
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('SEO')
                ->description('Opsional. Jika kosong, nama & deskripsi layanan yang dipakai.')
                ->collapsible()->collapsed()
                ->schema([
                    Forms\Components\TextInput::make('meta_title')->label('Judul SEO')->maxLength(60)
                        ->placeholder('Jasa Pembuatan Website Desa di NTT'),
                    Forms\Components\Textarea::make('meta_description')->label('Deskripsi SEO')->rows(2)->maxLength(160),
                ]),

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
                Tables\Columns\TextColumn::make('urutan')->label('No.')->sortable()->width(60),
                Tables\Columns\TextColumn::make('emoji_icon')->label('')->width(40),
                Tables\Columns\TextColumn::make('nama')->label('Nama Layanan')->searchable(),
                Tables\Columns\TextColumn::make('harga_mulai')->label('Harga Mulai'),
                Tables\Columns\IconColumn::make('aktif')->label('Aktif')->boolean(),
            ])
            ->defaultSort('urutan')
            ->reorderable('urutan')
            ->actions([
                Tables\Actions\Action::make('lihat')
                    ->label('Lihat')->icon('heroicon-o-eye')->color('gray')
                    ->url(fn (Layanan $record) => route('layanan.show', $record))
                    ->openUrlInNewTab(),
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
            'index'  => Pages\ListLayanans::route('/'),
            'create' => Pages\CreateLayanan::route('/create'),
            'edit'   => Pages\EditLayanan::route('/{record}/edit'),
        ];
    }
}
