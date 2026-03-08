<?php

namespace App\Filament\Resources\Tickets;

use App\Filament\Resources\Tickets\Pages\CreateTicket;
use App\Filament\Resources\Tickets\Pages\EditTicket;
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
            // ✅ راح نضيف Replies Relation Manager لاحقاً
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->with(['student', 'department', 'assignedUser']);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTickets::route('/'),
            'create' => CreateTicket::route('/create'),
            'edit' => EditTicket::route('/{record}/edit'),
        ];
    }

    // ✅ Badge عدد التذاكر المفتوحة
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'open')->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }
}
