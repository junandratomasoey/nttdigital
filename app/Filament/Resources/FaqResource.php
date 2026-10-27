<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FaqResource\Pages;
use App\Models\Faq;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FaqResource extends Resource
{
    protected static ?string $model = Faq::class;
    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';
    protected static ?string $navigationLabel = 'FAQ';
    protected static ?string $modelLabel = 'FAQ';
    protected static ?string $pluralModelLabel = 'FAQ';
    protected static ?string $navigationGroup = 'Blog & SEO';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([
                Forms\Components\TextInput::make('pertanyaan')->required()->maxLength(255)->columnSpanFull(),
                Forms\Components\Textarea::make('jawaban')->required()->rows(4)->columnSpanFull(),
                Forms\Components\Select::make('kategori')
                    ->options(fn () => Faq::query()->distinct()->pluck('kategori', 'kategori')
                        ->union(['Umum' => 'Umum', 'Harga & Pembayaran' => 'Harga & Pembayaran', 'Teknis' => 'Teknis']))
                    ->helperText('Kategori dengan nama jenis layanan (mis. "Desa") juga tampil di halaman layanan tersebut.')
                    ->createOptionForm([Forms\Components\TextInput::make('kategori')->required()])
                    ->createOptionUsing(fn (array $data) => $data['kategori'])
                    ->default('Umum')->required()->native(false),
                Forms\Components\TextInput::make('urutan')->numeric()->default(0),
                Forms\Components\Toggle::make('tampil_di_beranda')->label('Tampilkan di beranda'),
                Forms\Components\Toggle::make('aktif')->default(true),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('urutan')->label('No.')->sortable()->width(60),
                Tables\Columns\TextColumn::make('pertanyaan')->searchable()->wrap(),
                Tables\Columns\TextColumn::make('kategori')->badge()->color('gray'),
                Tables\Columns\ToggleColumn::make('tampil_di_beranda')->label('Beranda'),
                Tables\Columns\ToggleColumn::make('aktif'),
            ])
            ->defaultSort('urutan')
            ->reorderable('urutan')
            ->filters([
                Tables\Filters\SelectFilter::make('kategori')
                    ->options(fn () => Faq::query()->distinct()->pluck('kategori', 'kategori')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListFaqs::route('/'),
            'create' => Pages\CreateFaq::route('/create'),
            'edit'   => Pages\EditFaq::route('/{record}/edit'),
        ];
    }
}
