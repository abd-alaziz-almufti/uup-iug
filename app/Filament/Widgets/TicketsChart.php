<?php

namespace App\Filament\Widgets;

use App\Models\Ticket;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Auth;

class TicketsChart extends ChartWidget
{
    protected ?string $heading = 'تطور التذاكر (آخر 7 أيام)';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $user = Auth::user();
        $query = Ticket::query();

        // تصفية حسب الدور
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

        $data = (clone $query)
            ->where('created_at', '>=', now()->subDays(7))
            ->selectRaw('DATE(created_at) as date, count(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date')
            ->toArray();

        // ملء الأيام الناقصة بصفر
        $labels = [];
        $values = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $labels[] = now()->subDays($i)->format('D');
            $values[] = $data[$date] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'التذاكر الجديدة',
                    'data' => $values,
                    'fill' => 'start',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    public static function canView(): bool
    {
        $user = Auth::user();
        // متاح لجميع موظفي الإدارة لرؤية إحصائياتهم الخاصة
        return $user->hasRole(['super_admin', 'Super Admin', 'Dean', 'Academic Supervisor', 'Admission Officer', 'Support Agent', 'Instructor']);
    }
}
