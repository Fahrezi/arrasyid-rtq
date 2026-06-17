<?php

namespace App\Filament\Pages;

use App\Models\Donation;
use App\Models\Donor;
use App\Models\Program;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Carbon;

class DonationRecap extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Rekap Donasi';
    protected static ?string $title = 'Rekap Donasi WhatsApp';
    protected static ?int $navigationSort = 4;
    protected static string $view = 'filament.pages.donation-recap';

    public string $rawText = '';
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(['donations' => []]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Repeater::make('donations')
                    ->label('')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Donatur')
                            ->required(),
                        Forms\Components\TextInput::make('amount')
                            ->label('Jumlah')
                            ->numeric()
                            ->prefix('Rp')
                            ->required(),
                        Forms\Components\DatePicker::make('donated_at')
                            ->label('Tanggal')
                            ->required(),
                        Forms\Components\Select::make('payment_method')
                            ->label('Metode')
                            ->options([
                                'cash'          => 'Tunai',
                                'bank_transfer' => 'Transfer Bank',
                                'e_wallet'      => 'E-Wallet',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('notes')
                            ->label('Catatan')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->reorderable(false)
                    ->columnSpanFull()
                    ->itemLabel(fn (array $state): string => $state['name'] ?: 'Donatur'),
            ])
            ->statePath('data');
    }

    public function parse(): void
    {
        if (blank($this->rawText)) {
            Notification::make()->title('Teks kosong')->warning()->send();
            return;
        }

        $rows = $this->parseLines($this->rawText);

        if (empty($rows)) {
            Notification::make()->title('Tidak ada data yang bisa diparsing')->warning()->send();
            return;
        }

        $this->form->fill(['donations' => $rows]);

        Notification::make()
            ->title(count($rows) . ' baris berhasil diparsing')
            ->success()
            ->send();
    }

    public function submitAll(): void
    {
        $this->form->validate();

        $donations = $this->data['donations'] ?? [];

        if (empty($donations)) {
            Notification::make()->title('Tidak ada data untuk disimpan')->warning()->send();
            return;
        }

        $defaultProgram = Program::first();
        $count = 0;

        foreach ($donations as $row) {
            $donor = Donor::firstOrCreate(
                ['name' => trim($row['name'])],
                ['type' => 'non_fix', 'status' => 'active']
            );

            Donation::create([
                'donor_id'       => $donor->id,
                'program_id'     => $defaultProgram?->id,
                'amount'         => $row['amount'],
                'donated_at'     => $row['donated_at'],
                'payment_method' => $row['payment_method'],
                'notes'          => $row['notes'] ?? null,
                'status'         => 'approved',
            ]);

            $count++;
        }

        Notification::make()
            ->title("{$count} donasi berhasil disimpan")
            ->success()
            ->send();

        $this->rawText = '';
        $this->form->fill(['donations' => []]);
    }

    private function parseLines(string $text): array
    {
        $lines = explode("\n", $text);
        $rows = [];

        foreach ($lines as $line) {
            // Strip leading number+dot and invisible Unicode chars (⁠ etc.)
            $line = preg_replace('/^\d+\.\s*/', '', $line);
            $line = preg_replace('/^[\x{2060}\x{200B}\x{FEFF}\s]+/u', '', $line);
            $line = trim($line);

            if (blank($line)) continue;

            // Must contain an amount to be valid
            if (!preg_match('/Rp\.?\s*([\d.,]+)/i', $line, $amountMatch)) {
                continue;
            }

            // Parse amount — strip thousand dots and trailing punctuation
            $rawAmount = rtrim($amountMatch[1], '.,- ');
            $rawAmount = str_replace(['.', ','], '', $rawAmount);
            $amount = (int) $rawAmount;

            if ($amount <= 0) continue;

            // Name: everything before the Rp token
            $rpPos = mb_stripos($line, $amountMatch[0]);
            $name = trim(mb_substr($line, 0, $rpPos));

            // Date: d/m/yy or d/m/yyyy (after Rp part)
            $donatedAt = now()->toDateString();
            if (preg_match('/(\d{1,2})\/(\d{1,2})\/(\d{2,4})/', $line, $dateMatch)) {
                $year = strlen($dateMatch[3]) === 2 ? '20' . $dateMatch[3] : $dateMatch[3];
                try {
                    $donatedAt = Carbon::createFromDate((int) $year, (int) $dateMatch[2], (int) $dateMatch[1])
                        ->toDateString();
                } catch (\Throwable) {
                    // keep today
                }
            }

            // Payment method
            $method = 'cash';
            if (preg_match('/\(tfr\)|tfr\b|transfer\s*bank/i', $line)) {
                $method = 'bank_transfer';
            } elseif (preg_match('/e.?wallet|gopay|ovo|dana|shopeepay|qris/i', $line)) {
                $method = 'e_wallet';
            }

            // Notes: pick up common note phrases
            $notes = '';
            if (preg_match('/(diniatkan\b.+|pahalanya\b.+|untuk\s+(?:alm|almh)\b.+)/iu', $line, $notesMatch)) {
                $notes = trim($notesMatch[0]);
            }

            $rows[] = [
                'name'           => $name,
                'amount'         => $amount,
                'donated_at'     => $donatedAt,
                'payment_method' => $method,
                'notes'          => $notes,
            ];
        }

        return $rows;
    }
}
