<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DonationResource\Pages;
use App\Models\Donation;
use App\Models\Donor;
use App\Models\Program;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DonationResource extends Resource
{
    protected static ?string $model = Donation::class;
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationLabel = 'Donasi';
    protected static ?int $navigationSort = 3;

    public static function canEdit($record): bool { return false; }
    public static function canDelete($record): bool { return false; }
    public static function canDeleteAny(): bool { return false; }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('donor_id')
                ->label('Donatur')
                ->relationship('donor', 'name')
                ->searchable()
                ->preload()
                ->required()
                ->createOptionForm([
                    Forms\Components\TextInput::make('name')
                        ->label('Nama')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('phone')
                        ->label('No. HP / WhatsApp')
                        ->tel()
                        ->maxLength(20),
                    Forms\Components\TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->maxLength(255),
                    Forms\Components\Select::make('type')
                        ->label('Tipe')
                        ->options(['fix' => 'Tetap', 'non_fix' => 'Tidak Tetap'])
                        ->default('non_fix')
                        ->required(),
                    Forms\Components\Select::make('status')
                        ->options(['active' => 'Aktif', 'non_active' => 'Tidak Aktif'])
                        ->default('active')
                        ->required(),
                ]),
            Forms\Components\Select::make('program_id')
                ->label('Program')
                ->relationship('program', 'name')
                ->searchable()
                ->preload()
                ->required(),
            Forms\Components\TextInput::make('amount')
                ->label('Jumlah (Rp)')
                ->numeric()
                ->prefix('Rp')
                ->required(),
            Forms\Components\DateTimePicker::make('donated_at')
                ->label('Waktu Donasi')
                ->default(now())
                ->required(),
            Forms\Components\Select::make('payment_method')
                ->label('Metode Pembayaran')
                ->options([
                    'bank_transfer' => 'Transfer Bank',
                    'e_wallet'      => 'E-Wallet',
                    'cash'          => 'Tunai',
                ])
                ->default('cash')
                ->required(),
            Forms\Components\Select::make('status')
                ->options([
                    'pending'  => 'Menunggu',
                    'approved' => 'Disetujui',
                    'rejected' => 'Ditolak',
                ])
                ->default('approved')
                ->required(),
            Forms\Components\FileUpload::make('proof_of_donation')
                ->label('Bukti Donasi')
                ->image()
                ->directory('donations/proofs')
                ->columnSpanFull(),
            Forms\Components\Textarea::make('notes')
                ->label('Catatan')
                ->rows(3)
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('donor.name')->label('Donatur')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('program.name')->label('Program')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Jumlah')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Metode')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'bank_transfer' => 'Transfer Bank',
                        'e_wallet'      => 'E-Wallet',
                        'cash'          => 'Tunai',
                        default         => $state,
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'pending'  => 'Menunggu',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        default    => $state,
                    })
                    ->color(fn ($state) => match ($state) {
                        'pending'  => 'warning',
                        'approved' => 'success',
                        default    => 'danger',
                    }),
                Tables\Columns\TextColumn::make('donated_at')->label('Waktu')->dateTime()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options(['pending' => 'Menunggu', 'approved' => 'Disetujui', 'rejected' => 'Ditolak']),
                Tables\Filters\SelectFilter::make('payment_method')->label('Metode')->options(['bank_transfer' => 'Transfer Bank', 'e_wallet' => 'E-Wallet', 'cash' => 'Tunai']),
                Tables\Filters\SelectFilter::make('program')->relationship('program', 'name'),
            ])
            ->actions([Tables\Actions\ViewAction::make()])
            ->bulkActions([])
            ->defaultSort('donated_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListDonations::route('/'),
            'create' => Pages\CreateDonation::route('/create'),
            'view'   => Pages\ViewDonation::route('/{record}'),
        ];
    }
}
