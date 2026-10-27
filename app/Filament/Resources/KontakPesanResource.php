<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KontakPesanResource\Pages;
use App\Models\KontakPesan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class KontakPesanResource extends Resource
{
    protected static ?string $model = KontakPesan::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationLabel = 'Pesan Masuk';
    protected static ?string $modelLabel = 'Pesan';
    protected static ?string $pluralModelLabel = 'Pesan Masuk';
    protected static ?string $navigationGroup = 'Manajemen';
    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return (string) KontakPesan::baru()->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Detail Pesan')
                ->schema([
                    Forms\Components\TextInput::make('nama')->label('Nama')->disabled(),
                    Forms\Components\TextInput::make('whatsapp')->label('WhatsApp')->disabled(),
                    Forms\Components\TextInput::make('jenis_website')->label('Jenis Website')->disabled(),
                    Forms\Components\TextInput::make('paket')->label('Paket diminati')->disabled(),
                    Forms\Components\Textarea::make('pesan')->label('Pesan')->disabled()->rows(4)->columnSpanFull(),
                    Forms\Components\Select::make('status')
                        ->label('Status')
                        ->options([
                            'baru'     => 'Baru',
                            'dibaca'   => 'Dibaca',
                            'diproses' => 'Diproses',
                            'selesai'  => 'Selesai',
                        ])
                        ->required(),
                ])->columns(2),

            Forms\Components\Section::make('Sumber Lead')
                ->description('Dari halaman / kampanye mana pesan ini datang.')
                ->collapsible()
                ->schema([
                    Forms\Components\TextInput::make('halaman_asal')->label('Halaman')->disabled()->columnSpanFull(),
                    Forms\Components\TextInput::make('utm_source')->label('Sumber (utm_source)')->disabled(),
                    Forms\Components\TextInput::make('utm_medium')->label('Media (utm_medium)')->disabled(),
                    Forms\Components\TextInput::make('utm_campaign')->label('Kampanye (utm_campaign)')->disabled(),
                ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama')->label('Nama')->searchable(),
                Tables\Columns\TextColumn::make('whatsapp')->label('WhatsApp'),
                Tables\Columns\TextColumn::make('jenis_website')->label('Jenis Website')->badge(),
                Tables\Columns\TextColumn::make('paket')->label('Paket')->toggleable(),
                Tables\Columns\TextColumn::make('pesan')->label('Pesan')->limit(50)->wrap(),
                Tables\Columns\TextColumn::make('utm_source')->label('Sumber')->badge()->color('gray')
                    ->placeholder('langsung')->toggleable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'danger'  => 'baru',
                        'warning' => 'dibaca',
                        'info'    => 'diproses',
                        'success' => 'selesai',
                    ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options([
                    'baru' => 'Baru', 'dibaca' => 'Dibaca', 'diproses' => 'Diproses', 'selesai' => 'Selesai',
                ]),
                Tables\Filters\SelectFilter::make('jenis_website')->label('Jenis Website')
                    ->options(fn () => KontakPesan::query()->whereNotNull('jenis_website')->distinct()->pluck('jenis_website', 'jenis_website')),
            ])
            ->actions([
                Tables\Actions\Action::make('whatsapp')
                    ->label('WA')
                    ->icon('heroicon-o-chat-bubble-left')
                    ->color('success')
                    ->url(fn (KontakPesan $record) =>
                        "https://wa.me/{$record->whatsapp}?text=" . rawurlencode("Halo {$record->nama}, terima kasih sudah menghubungi NTT Digital.")
                    )
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make()->label('Update Status'),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListKontakPesans::route('/'),
            'edit'   => Pages\EditKontakPesan::route('/{record}/edit'),
        ];
    }
}
