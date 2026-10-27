<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimoniResource\Pages;
use App\Models\Testimoni;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TestimoniResource extends Resource
{
    protected static ?string $model = Testimoni::class;
    protected static ?string $navigationIcon = 'heroicon-o-star';
    protected static ?string $navigationLabel = 'Testimoni';
    protected static ?string $modelLabel = 'Testimoni';
    protected static ?string $pluralModelLabel = 'Testimoni';
    protected static ?string $navigationGroup = 'Konten Utama';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Testimoni Klien')
                ->description('Gunakan hanya testimoni asli dari klien, dengan izin mereka.')
                ->schema([
                    Forms\Components\TextInput::make('nama')->required()->maxLength(100),
                    Forms\Components\TextInput::make('jabatan')->placeholder('Kepala Desa')->maxLength(100),
                    Forms\Components\TextInput::make('instansi')->placeholder('Desa Oesao')->maxLength(150),
                    Forms\Components\Select::make('rating')
                        ->options([5 => '★★★★★', 4 => '★★★★', 3 => '★★★', 2 => '★★', 1 => '★'])
                        ->default(5)->required()->native(false),
                    Forms\Components\Textarea::make('isi')->label('Isi testimoni')->required()->rows(4)->maxLength(600)->columnSpanFull(),
                    Forms\Components\Select::make('portofolio_id')
                        ->label('Terkait proyek (opsional)')
                        ->relationship('portofolio', 'nama_proyek')
                        ->searchable()->preload(),
                    Forms\Components\FileUpload::make('foto')->image()->avatar()->directory('testimoni')->maxSize(1024),
                ])->columns(2),
            Forms\Components\Section::make('Pengaturan')->schema([
                Forms\Components\TextInput::make('urutan')->numeric()->default(0),
                Forms\Components\Toggle::make('aktif')->default(true),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('urutan')->label('No.')->sortable()->width(60),
                Tables\Columns\ImageColumn::make('foto')->circular()->label(''),
                Tables\Columns\TextColumn::make('nama')->searchable()
                    ->description(fn (Testimoni $r) => collect([$r->jabatan, $r->instansi])->filter()->implode(', ')),
                Tables\Columns\TextColumn::make('isi')->limit(60)->wrap(),
                Tables\Columns\TextColumn::make('rating')->formatStateUsing(fn ($state) => str_repeat('★', $state)),
                Tables\Columns\IconColumn::make('aktif')->boolean(),
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
            'index'  => Pages\ListTestimonis::route('/'),
            'create' => Pages\CreateTestimoni::route('/create'),
            'edit'   => Pages\EditTestimoni::route('/{record}/edit'),
        ];
    }
}
