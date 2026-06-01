<?php

namespace App\Filament\Widgets;

use App\Models\Ticket;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $user = Auth::user();
        $query = Ticket::query();

        // تصفية البيانات بناءً على الصلاحيات
        if (!$user->hasRole(['super_admin', 'Super Admin'])) {
            if ($user->hasRole('Dean')) {
                $query->where('department_id', $user->department_id);
            } elseif ($user->hasRole('Academic Supervisor')) {
                $query->where('department_id', $user->department_id);
            } elseif ($user->hasRole('Support Agent')) {
                $query->where('assigned_to', $user->id);
            } elseif ($user->hasRole('Instructor')) {
                // قد يحتاج المدرس لرؤية التذاكر المتعلقة بمواده فقط، لكن هنا سنفترض القسم
                $query->where('department_id', $user->department_id);
            } elseif ($user->hasRole('Admission Officer')) {
                $query->where('target_type', 'admission');
            }
        }

        $totalTickets = (clone $query)->count();
        $openTickets = (clone $query)->where('status', 'open')->count();
        $resolvedTickets = (clone $query)->where('status', 'resolved')->count();

        return [
            Stat::make('إجمالي التذاكر', $totalTickets)
                ->description('جميع التذاكر في نطاق صلاحياتك')
                ->descriptionIcon('heroicon-m-ticket')
                ->color('info'),
            Stat::make('تذاكر مفتوحة', $openTickets)
                ->description('تنتظر الرد أو الإجراء')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
            Stat::make('تذاكر محلولة', $resolvedTickets)
                ->description('تم الانتهاء منها بنجاح')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
        ];
    }
}
