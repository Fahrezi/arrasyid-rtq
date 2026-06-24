<?php

namespace App\Filament\Widgets;

use App\Models\Donation;
use App\Models\Expense;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class MoneyFlowChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Arus Keuangan (12 Bulan Terakhir)';
    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $months = collect(range(11, 0))->map(fn ($i) => Carbon::now()->subMonths($i));

        $labels = $months->map(fn ($m) => $m->translatedFormat('M Y'))->toArray();

        $donations = $months->map(fn ($m) => (int) Donation::query()
            ->where('status', 'approved')
            ->whereYear('donated_at', $m->year)
            ->whereMonth('donated_at', $m->month)
            ->sum('amount')
        )->toArray();

        $expenses = $months->map(fn ($m) => (int) Expense::query()
            ->whereYear('expense_date', $m->year)
            ->whereMonth('expense_date', $m->month)
            ->sum('amount')
        )->toArray();

        return [
            'datasets' => [
                [
                    'label'           => 'Donasi',
                    'data'            => $donations,
                    'backgroundColor' => 'rgba(34, 197, 94, 0.2)',
                    'borderColor'     => 'rgb(34, 197, 94)',
                    'borderWidth'     => 2,
                    'tension'         => 0.3,
                    'fill'            => true,
                ],
                [
                    'label'           => 'Pengeluaran',
                    'data'            => $expenses,
                    'backgroundColor' => 'rgba(239, 68, 68, 0.2)',
                    'borderColor'     => 'rgb(239, 68, 68)',
                    'borderWidth'     => 2,
                    'tension'         => 0.3,
                    'fill'            => true,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
