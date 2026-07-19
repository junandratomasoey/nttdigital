<?php

namespace App\Filament\Widgets;

use App\Models\KontakPesan;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class PesanTerbaruWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    protected static ?string $heading = 'Pesan Terbaru';
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                KontakPesan::query()->latest()->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama'),
                Tables\Columns\TextColumn::make('whatsapp')
                    ->label('WhatsApp'),
                Tables\Columns\TextColumn::make('jenis_website')
                    ->label('Jenis Website')
                    ->badge(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'danger'  => 'baru',
                        'warning' => 'dibaca',
                        'info'    => 'diproses',
                        'success' => 'selesai',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('balas_wa')
                    ->label('Balas WA')
                    ->icon('heroicon-o-chat-bubble-left')
                    ->color('success')
                    ->url(fn (KontakPesan $record) =>
                        "https://wa.me/{$record->whatsapp}?text=Halo%20{$record->nama}%2C%20terima%20kasih%20sudah%20menghubungi%20NTT%20Digital."
                    )
                    ->openUrlInNewTab(),
            ]);
    }
}
