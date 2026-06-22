<?php

namespace App\Filament\Resources\DuitkuPaymentResource\Pages;

use App\Filament\Resources\DuitkuPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDuitkuPayment extends EditRecord
{
    protected static string $resource = DuitkuPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
