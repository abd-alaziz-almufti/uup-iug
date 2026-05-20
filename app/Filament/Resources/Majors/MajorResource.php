<?php

namespace App\Filament\Resources\Majors;

use App\Filament\Resources\Majors\Pages\ListMajors;
use App\Filament\Resources\Majors\Schemas\MajorForm;
use App\Filament\Resources\Majors\Tables\MajorsTable;
use App\Models\Major;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MajorResource extends Resource
{
    protected static ?string $model = Major::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookmark;

    protected static ?string $navigationLabel = 'التخصصات الاكاديمية';

    protected static ?string $modelLabel = 'تخصص';

    protected static ?string $pluralModelLabel = 'التخصصات الاكاديمية';

    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'name';

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole(['Super Admin', 'super_admin', 'Academic Supervisor']);
    }

    public static function form(Schema $schema): Schema
    {
        return MajorForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MajorsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->with(['department']);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMajors::route('/'),
        ];
    }
}
