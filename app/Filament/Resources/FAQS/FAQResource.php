<?php

namespace App\Filament\Resources\FAQS;

use App\Filament\Resources\FAQS\Pages\ListFAQS;
use App\Filament\Resources\FAQS\Schemas\FAQForm;
use App\Filament\Resources\FAQS\Tables\FAQSTable;
use App\Models\FAQ;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FAQResource extends Resource
{
    protected static ?string $model = FAQ::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedQuestionMarkCircle;


    protected static ?string $navigationLabel = 'الأسئلة الشائعة';

    protected static ?string $modelLabel = 'سؤال';

    protected static ?string $pluralModelLabel = 'الأسئلة الشائعة';

    protected static ?int $navigationSort = 5;

    protected static ?string $recordTitleAttribute = 'question';

    public static function form(Schema $schema): Schema
    {
        return FAQForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FAQSTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery()->with(['course']);
        $user = auth()->user();

        if ($user->hasRole(['Super Admin', 'super_admin', 'Content Manager', 'Support Agent'])) {
            return $query;
        }

        if ($user->hasRole('Academic Supervisor')) {
            return $query->whereHas('course', function ($q) use ($user) {
                $q->where('department_id', $user->department_id);
            });
        }

        if ($user->hasRole('Instructor')) {
            return $query->whereHas('course', function ($q) use ($user) {
                $q->where('department_id', $user->department_id);
            });
        }

        return $query->where('id', 0);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFAQS::route('/'),
        ];
    }
}
