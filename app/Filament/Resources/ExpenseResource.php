<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpenseResource\Pages;
use App\Models\Expense;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ExpenseResource extends Resource
{
    protected static ?string $model = Expense::class;
    protected static ?string $navigationIcon = 'heroicon-o-arrow-trending-down';
    protected static ?string $navigationLabel = 'Pengeluaran';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('program_id')
                ->label('Program')
                ->relationship('program', 'name')
                ->searchable()
                ->preload()
                ->required(),
            Forms\Components\TextInput::make('name')
                ->label('Nama Pengeluaran')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('amount')
                ->label('Jumlah (Rp)')
                ->numeric()
                ->prefix('Rp')
                ->required(),
            Forms\Components\DatePicker::make('expense_date')
                ->label('Tanggal')
                ->required(),
            Forms\Components\Textarea::make('description')
                ->label('Deskripsi')
                ->required()
                ->rows(3)
                ->columnSpanFull(),
            Forms\Components\FileUpload::make('proof_of_expense')
                ->label('Bukti Pengeluaran')
                ->image()
                ->directory('expenses/proofs')
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('program.name')->label('Program')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('name')->label('Nama')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('amount')->label('Jumlah')->money('IDR')->sortable(),
                Tables\Columns\TextColumn::make('expense_date')->label('Tanggal')->date()->sortable(),
                Tables\Columns\TextColumn::make('description')->label('Deskripsi')->limit(50)->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('program')->relationship('program', 'name'),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])])
            ->defaultSort('expense_date', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListExpenses::route('/'),
            'create' => Pages\CreateExpense::route('/create'),
            'edit'   => Pages\EditExpense::route('/{record}/edit'),
        ];
    }
}
