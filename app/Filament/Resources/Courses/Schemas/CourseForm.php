<?php

namespace App\Filament\Resources\Courses\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CourseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('معلومات المادة')
                    ->schema([
                        TextInput::make('course_code')
                            ->label('رمز المادة')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(20)
                            ->placeholder('مثال: CS101')
                            ->alphaNum(),

                        TextInput::make('name')
                            ->label('اسم المادة')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        TextInput::make('credit_hours')
                            ->label('عدد الساعات المعتمدة')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(12)
                            ->default(3),

                        Select::make('department_id')
                            ->label('القسم/الكلية')
                            ->relationship('department', 'name')
                            ->searchable()
                            ->preload()
                            ->placeholder('عام (متطلبات جامعة)')
                            ->native(false)
                            ->helperText('اترك فارغاً للمواد العامة'),
                    ])
                    ->columns(2),
            ]);
    }
}