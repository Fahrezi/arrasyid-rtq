<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->hidden(function () {
                    /** @var User $record */
                    $record = $this->getRecord();
                    if ($record->id === auth()->id()) return true;
                    if ($record->isSuperAdmin() && User::where('role', 'super_admin')->count() <= 1) return true;
                    return false;
                }),
        ];
    }
}
