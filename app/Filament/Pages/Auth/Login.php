<?php

namespace App\Filament\Pages\Auth;

use App\Models\User;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class Login extends BaseLogin
{
    protected function throwFailureValidationException(): never
    {
        $data  = $this->form->getState();
        $email = $data['email'] ?? '';

        $user = User::where('email', $email)->first();

        if (! $user) {
            throw ValidationException::withMessages([
                'data.email' => 'Email tidak terdaftar.',
            ]);
        }

        throw ValidationException::withMessages([
            'data.password' => 'Password yang Anda masukkan salah.',
        ]);
    }
}
