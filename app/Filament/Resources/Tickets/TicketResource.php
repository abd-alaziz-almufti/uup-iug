<?php

namespace App\Filament\Resources\Tickets;

use App\Filament\Resources\Tickets\Pages\ListTickets;
use App\Filament\Resources\Tickets\Schemas\TicketForm;
use App\Filament\Resources\Tickets\Tables\TicketsTable;
use App\Models\Ticket;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTicket;

    // ✅ إضافات جديدة
    protected static ?string $navigationLabel = 'التذاكر';

    protected static ?string $modelLabel = 'تذكرة';

    protected static ?string $pluralModelLabel = 'التذاكر';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'title'; 

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole(['Super Admin', 'super_admin', 'Academic Supervisor', 'Support Agent']);
    }

    public static function form(Schema $schema): Schema
    {
        return TicketForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TicketsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\RepliesRelationManager::class,
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery()->with(['student', 'department', 'assignedUser', 'course']);
        $user = auth()->user();

        // Super Admin sees everything
        if ($user->hasRole(['Super Admin', 'super_admin'])) {
            return $query;
        }

        // Dean sees tickets targeted to 'dean' in their department/college
        if ($user->hasRole('Dean')) {
            return $query->where('target_type', 'dean')
                ->where('department_id', $user->department_id); // Assuming Dean's department represents their college
        }

        // Instructor sees tickets targeted to 'instructor' for their courses
        if ($user->hasRole('Instructor')) {
            return $query->where('target_type', 'instructor')
                ->where(function ($q) use ($user) {
                    $q->where('assigned_to', $user->id)
                      ->orWhereNull('assigned_to');
                });
        }

        // Admission Officer sees tickets targeted to 'admission'
        if ($user->hasRole('Admission Officer')) {
            return $query->where('target_type', 'admission');
        }

        // Academic Supervisor sees all tickets in their department
        if ($user->hasRole('Academic Supervisor')) {
            return $query->where('department_id', $user->department_id);
        }

        // Support Agent sees assigned tickets OR unassigned tickets in their department
        if ($user->hasRole('Support Agent')) {
            return $query->where(function ($q) use ($user) {
                $q->where('assigned_to', $user->id)
                  ->orWhere(function ($sq) use ($user) {
                      $sq->whereNull('assigned_to')
                        ->where('department_id', $user->department_id);
                  });
            });
        }

        // Student sees only their own tickets
        if ($user->hasRole('Student')) {
            return $query->where('student_id', $user->id);
        }

        return $query->where('id', 0); // Default to nothing if no match
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTickets::route('/'),
        ];
    }

    // ✅ Badge عدد التذاكر المفتوحة
    public static function getNavigationBadge(): ?string
    {
        return static::getEloquentQuery()->where('status', 'open')->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }
}
