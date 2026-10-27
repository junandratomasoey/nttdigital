<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArtikelResource\Pages;
use App\Models\Artikel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ArtikelResource extends Resource
{
    protected static ?string $model = Artikel::class;
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationLabel = 'Artikel / Blog';
    protected static ?string $modelLabel = 'Artikel';
    protected static ?string $pluralModelLabel = 'Artikel';
    protected static ?string $navigationGroup = 'Blog & SEO';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Group::make([
                Forms\Components\Section::make('Isi Artikel')->schema([
                    Forms\Components\TextInput::make('judul')
                        ->required()->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(function ($state, Forms\Set $set, ?Artikel $record) {
                            if (! $record) {
                                $set('slug', Str::slug($state));
                            }
                        }),
                    Forms\Components\TextInput::make('slug')
                        ->required()->unique(ignoreRecord: true)->maxLength(255)
                        ->helperText('Alamat artikel: nttdigital.com/blog/slug. Hindari mengubah slug setelah terbit.'),
                    Forms\Components\Textarea::make('ringkasan')
                        ->rows(2)->maxLength(300)
                        ->helperText('Tampil di daftar artikel. Kosongkan untuk diambil otomatis dari isi.'),
                    Forms\Components\RichEditor::make('konten')
                        ->label('Isi')
                        ->required()
                        ->fileAttachmentsDirectory('artikel/lampiran')
                        ->toolbarButtons([
                            'h2', 'h3', 'bold', 'italic', 'underline', 'strike', 'link',
                            'bulletList', 'orderedList', 'blockquote', 'attachFiles', 'undo', 'redo',
                        ])
                        ->columnSpanFull(),
                ]),

                Forms\Components\Section::make('SEO')
                    ->description('Opsional. Jika kosong, judul & ringkasan artikel yang dipakai.')
                    ->collapsible()
                    ->schema([
                        Forms\Components\TextInput::make('meta_title')
                            ->label('Judul SEO')->maxLength(60)
                            ->helperText('Maks. 60 karakter agar tidak terpotong di Google.'),
                        Forms\Components\Textarea::make('meta_description')
                            ->label('Deskripsi SEO')->rows(2)->maxLength(160)
                            ->helperText('120–160 karakter, sertakan kata kunci utama.'),
                    ]),
            ])->columnSpan(['lg' => 2]),

            Forms\Components\Group::make([
                Forms\Components\Section::make('Publikasi')->schema([
                    Forms\Components\Select::make('status')
                        ->options(['draf' => 'Draf', 'terbit' => 'Terbit'])
                        ->default('draf')->required()->native(false),
                    Forms\Components\DateTimePicker::make('dipublikasikan_pada')
                        ->label('Tanggal terbit')
                        ->helperText('Isi tanggal mendatang untuk menjadwalkan.')
                        ->seconds(false),
                    Forms\Components\Select::make('kategori')
                        ->options(Artikel::KATEGORI)->default('Tips')->required()->native(false),
                    Forms\Components\TagsInput::make('tags')->placeholder('website desa'),
                    Forms\Components\TextInput::make('penulis')->default('Tim NTT Digital')->required(),
                ]),
                Forms\Components\Section::make('Gambar Utama')->schema([
                    Forms\Components\FileUpload::make('gambar')
                        ->hiddenLabel()->image()->imageEditor()
                        ->directory('artikel')->maxSize(2048)
                        ->helperText('Rasio 16:9, mis. 1200×675 px. Juga dipakai saat dibagikan ke WhatsApp/Facebook.'),
                ]),
            ])->columnSpan(['lg' => 1]),
        ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('gambar')->label('')->width(64)->height(36),
                Tables\Columns\TextColumn::make('judul')->searchable()->limit(60)->wrap(),
                Tables\Columns\TextColumn::make('kategori')->badge()->color('gray'),
                Tables\Columns\TextColumn::make('status')->badge()
                    ->formatStateUsing(fn ($state) => $state === 'terbit' ? 'Terbit' : 'Draf')
                    ->color(fn ($state) => $state === 'terbit' ? 'success' : 'warning'),
                Tables\Columns\TextColumn::make('dipublikasikan_pada')->label('Terbit')->dateTime('d M Y')->sortable(),
                Tables\Columns\TextColumn::make('dilihat')->label('Dilihat')->numeric()->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options(['draf' => 'Draf', 'terbit' => 'Terbit']),
                Tables\Filters\SelectFilter::make('kategori')->options(Artikel::KATEGORI),
            ])
            ->actions([
                Tables\Actions\Action::make('lihat')
                    ->label('Lihat')->icon('heroicon-o-eye')->color('gray')
                    ->url(fn (Artikel $record) => route('blog.show', $record))
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
            'index'  => Pages\ListArtikels::route('/'),
            'create' => Pages\CreateArtikel::route('/create'),
            'edit'   => Pages\EditArtikel::route('/{record}/edit'),
        ];
    }
}
