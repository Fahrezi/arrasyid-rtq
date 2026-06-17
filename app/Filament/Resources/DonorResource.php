<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DonorResource\Pages;
use App\Models\Donor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DonorResource extends Resource
{
    protected static ?string $model = Donor::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Donatur';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('Nama')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255),
            Forms\Components\Select::make('type')
                ->label('Tipe')
                ->options([
                    'fix'     => 'Tetap',
                    'non_fix' => 'Tidak Tetap',
                ])
                ->required(),
            Forms\Components\Select::make('status')
                ->options([
                    'active'     => 'Aktif',
                    'non_active' => 'Tidak Aktif',
                ])
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nama')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state === 'fix' ? 'Tetap' : 'Tidak Tetap')
                    ->color(fn ($state) => $state === 'fix' ? 'success' : 'warning'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state === 'active' ? 'Aktif' : 'Tidak Aktif')
                    ->color(fn ($state) => $state === 'active' ? 'success' : 'danger'),
                Tables\Columns\TextColumn::make('created_at')->label('Dibuat')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')->options(['fix' => 'Tetap', 'non_fix' => 'Tidak Tetap']),
                Tables\Filters\SelectFilter::make('status')->options(['active' => 'Aktif', 'non_active' => 'Tidak Aktif']),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListDonors::route('/'),
            'create' => Pages\CreateDonor::route('/create'),
            'edit'   => Pages\EditDonor::route('/{record}/edit'),
        ];
    }
}
