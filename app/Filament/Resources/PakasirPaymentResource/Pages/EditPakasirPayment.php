<?php

namespace App\Filament\Resources\PakasirPaymentResource\Pages;

use App\Filament\Resources\PakasirPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPakasirPayment extends EditRecord
{
    protected static string $resource = PakasirPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
