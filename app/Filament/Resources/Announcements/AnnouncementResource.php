<?php

namespace App\Filament\Resources\Announcements;

use App\Filament\Resources\Announcements\Pages\ListAnnouncements;
use App\Filament\Resources\Announcements\Schemas\AnnouncementForm;
use App\Filament\Resources\Announcements\Tables\AnnouncementsTable;
use App\Models\Announcement;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AnnouncementResource extends Resource
{
    protected static ?string $model = Announcement::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Banknotes;
    protected static ?string $navigationLabel = 'الاعلانات';

    protected static ?string $modelLabel = 'أعلان';

    protected static ?string $pluralModelLabel = 'الاعلانات';

    protected static ?int $navigationSort = 4;
    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return AnnouncementForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AnnouncementsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery()->with(['department', 'publisher']);
        $user = auth()->user();

        if ($user->hasRole(['Super Admin', 'super_admin', 'Content Manager'])) {
            return $query;
        }

        return $query->where('department_id', $user->department_id);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAnnouncements::route('/'),
        ];
    }
}
