<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $user = auth()->user();
        $query = \App\Models\Ticket::query();

        // تطبيق نفس منطق التصفية حسب الدور
        if (!$user->hasRole(['super_admin', 'Super Admin'])) {
            if ($user->hasRole(['Dean', 'Academic Supervisor'])) {
                $query->where('department_id', $user->department_id);
            } elseif ($user->hasRole('Instructor')) {
                $query->where('department_id', $user->department_id)
                      ->where('target_type', 'instructor');
            } elseif ($user->hasRole('Admission Officer')) {
                $query->where('target_type', 'admission');
            } elseif ($user->hasRole('Support Agent')) {
                $query->where(fn ($q) => 
                    $q->where('assigned_to', $user->id)
                      ->orWhere(fn ($sq) => $sq->whereNull('assigned_to')->where('department_id', $user->department_id))
                );
            }
        }

        return [
            Stat::make('إجمالي التذاكر', (clone $query)->count())
                ->description('جميع التذاكر في صلاحياتك')
                ->descriptionIcon('heroicon-m-ticket')
                ->color('info'),
            Stat::make('تذاكر مفتوحة', (clone $query)->whereIn('status', ['open', 'in_progress'])->count())
                ->description('تنتظر المتابعة')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
            Stat::make('تذاكر محلولة', (clone $query)->where('status', 'resolved')->count())
                ->description('تم إنجازها')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
        ];
    }
}
