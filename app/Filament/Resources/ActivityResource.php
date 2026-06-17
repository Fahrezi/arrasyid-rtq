<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityResource\Pages;
use App\Models\Activity;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ActivityResource extends Resource
{
    protected static ?string $model = Activity::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationLabel = 'Kegiatan';
    protected static ?int $navigationSort = 5;

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
                ->label('Nama Kegiatan')
                ->required()
                ->maxLength(255),
            Forms\Components\DatePicker::make('activity_date')
                ->label('Tanggal Kegiatan')
                ->required(),
            Forms\Components\Textarea::make('description')
                ->label('Deskripsi')
                ->required()
                ->rows(3)
                ->columnSpanFull(),
            Forms\Components\FileUpload::make('proof_of_activity')
                ->label('Dokumentasi')
                ->image()
                ->directory('activities/proofs')
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('program.name')->label('Program')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('name')->label('Nama Kegiatan')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('activity_date')->label('Tanggal')->date()->sortable(),
                Tables\Columns\TextColumn::make('description')->label('Deskripsi')->limit(50)->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('program')->relationship('program', 'name'),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])])
            ->defaultSort('activity_date', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListActivities::route('/'),
            'create' => Pages\CreateActivity::route('/create'),
            'edit'   => Pages\EditActivity::route('/{record}/edit'),
        ];
    }
}
