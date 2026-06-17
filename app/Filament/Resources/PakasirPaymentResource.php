<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PakasirPaymentResource\Pages;
use App\Models\PakasirPayment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PakasirPaymentResource extends Resource
{
    protected static ?string $model = PakasirPayment::class;
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationLabel = 'Pembayaran';
    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('order_id')->label('Order ID')->disabled(),
            Forms\Components\Select::make('donation_id')
                ->label('Donasi')
                ->relationship('donation', 'id')
                ->searchable()
                ->preload(),
            Forms\Components\TextInput::make('amount')->label('Jumlah')->numeric()->prefix('Rp')->disabled(),
            Forms\Components\TextInput::make('project')->label('Proyek')->disabled(),
            Forms\Components\Select::make('status')
                ->options([
                    'pending'   => 'Menunggu',
                    'completed' => 'Selesai',
                    'failed'    => 'Gagal',
                    'expired'   => 'Kedaluwarsa',
                ])
                ->required(),
            Forms\Components\TextInput::make('payment_method')->label('Metode Pembayaran')->disabled(),
            Forms\Components\TextInput::make('va_number')->label('No. VA')->disabled(),
            Forms\Components\DateTimePicker::make('completed_at')->label('Selesai Pada')->disabled(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_id')->label('Order ID')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('amount')->label('Jumlah')->money('IDR')->sortable(),
                Tables\Columns\TextColumn::make('project')->label('Proyek')->searchable(),
                Tables\Columns\TextColumn::make('payment_method')->label('Metode')->toggleable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'pending'   => 'Menunggu',
                        'completed' => 'Selesai',
                        'failed'    => 'Gagal',
                        'expired'   => 'Kedaluwarsa',
                        default     => $state,
                    })
                    ->color(fn ($state) => match ($state) {
                        'pending'   => 'warning',
                        'completed' => 'success',
                        'failed'    => 'danger',
                        default     => 'gray',
                    }),
                Tables\Columns\TextColumn::make('completed_at')->label('Selesai')->dateTime()->sortable()->toggleable(),
                Tables\Columns\TextColumn::make('created_at')->label('Dibuat')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options(['pending' => 'Menunggu', 'completed' => 'Selesai', 'failed' => 'Gagal', 'expired' => 'Kedaluwarsa']),
            ])
            ->actions([Tables\Actions\ViewAction::make(), Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPakasirPayments::route('/'),
            'create' => Pages\CreatePakasirPayment::route('/create'),
            'edit'   => Pages\EditPakasirPayment::route('/{record}/edit'),
        ];
    }
}
