<?php

namespace App\Filament\Widgets;

use App\Models\Donation;
use App\Models\Expense;
use App\Models\Program;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MoneyFlowStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalDonations = (int) Donation::where('status', 'approved')->sum('amount');
        $totalExpenses  = (int) Expense::sum('amount');
        $netBalance     = $totalDonations - $totalExpenses;
        $activePrograms = Program::where('status', 'active')->count();

        $thisMonthDonations = (int) Donation::where('status', 'approved')
            ->whereMonth('donated_at', now()->month)
            ->whereYear('donated_at', now()->year)
            ->sum('amount');

        $thisMonthExpenses = (int) Expense::whereMonth('expense_date', now()->month)
            ->whereYear('expense_date', now()->year)
            ->sum('amount');

        return [
            Stat::make('Total Donasi', 'Rp ' . number_format($totalDonations, 0, ',', '.'))
                ->description('Bulan ini: Rp ' . number_format($thisMonthDonations, 0, ',', '.'))
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Total Pengeluaran', 'Rp ' . number_format($totalExpenses, 0, ',', '.'))
                ->description('Bulan ini: Rp ' . number_format($thisMonthExpenses, 0, ',', '.'))
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),

            Stat::make('Saldo Bersih', 'Rp ' . number_format($netBalance, 0, ',', '.'))
                ->description($netBalance >= 0 ? 'Surplus' : 'Defisit')
                ->descriptionIcon($netBalance >= 0 ? 'heroicon-m-check-circle' : 'heroicon-m-exclamation-triangle')
                ->color($netBalance >= 0 ? 'success' : 'danger'),

            Stat::make('Program Aktif', $activePrograms)
                ->description('Program berjalan')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('info'),
        ];
    }
}
