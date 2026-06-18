<?php

namespace App\Filament\Widgets;

use App\Models\Ticket;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Auth;

class LatestTickets extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'أحدث التذاكر';

    public function table(Table $table): Table
    {
        $user = Auth::user();
        $query = Ticket::query();

        if (!$user->hasRole(['super_admin', 'Super Admin'])) {
            if ($user->hasRole(['Dean', 'Academic Supervisor'])) {
                $query->where('department_id', $user->department_id);
            } elseif ($user->hasRole('Instructor')) {
                // المدرس يرى التذاكر الموجهة للمدرسين في قسمه
                $query->where('department_id', $user->department_id)
                      ->where('target_type', 'instructor');
            } elseif ($user->hasRole('Admission Officer')) {
                // موظف القبول يرى التذاكر الموجهة للقبول
                $query->where('target_type', 'admission');
            } elseif ($user->hasRole('Support Agent')) {
                // موظف الدعم يرى التذاكر المسندة إليه أو غير المسندة في قسمه
                $query->where(fn ($q) => 
                    $q->where('assigned_to', $user->id)
                      ->orWhere(fn ($sq) => $sq->whereNull('assigned_to')->where('department_id', $user->department_id))
                );
            }
        }

        return $table
            ->query($query->latest())
            ->columns([
                Tables\Columns\TextColumn::make('ticket_code')
                    ->label('كود التذكرة')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('العنوان')
                    ->limit(50),
                Tables\Columns\TextColumn::make('status')
                    ->label('الحالة')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'open' => 'warning',
                        'in_progress' => 'info',
                        'resolved' => 'success',
                        'closed' => 'gray',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('priority')
                    ->label('الأولوية')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'low' => 'gray',
                        'medium' => 'info',
                        'high' => 'warning',
                        'urgent' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable(),
            ]);
    }
}
