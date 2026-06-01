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
            if ($user->hasRole('Dean')) {
                $query->where('department_id', $user->department_id);
            } else {
                // إذا لم يكن سوبر أدمن أو عميد، لا تظهر بيانات (أو تظهر فارغة)
                return [
                    'datasets' => [],
                    'labels' => [],
                ];
            }
        }

        $data = Ticket::query()
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
            $labels[] = now()->subDays($i)->format('D'); // اسم اليوم بالإنجليزية أو العربية حسب الترجمة
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
        return $user->hasRole(['super_admin', 'Super Admin', 'Dean']);
    }
}
