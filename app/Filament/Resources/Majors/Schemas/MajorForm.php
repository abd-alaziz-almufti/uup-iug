<?php

namespace App\Filament\Resources\Majors\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MajorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('تفاصيل التخصص')
                    ->schema([
                        Select::make('department_id')
                            ->label('الكلية')
                            ->relationship('department', 'name', fn ($query) => $query->where('type', 'College'))
                            ->required()
                            ->searchable()
                            ->preload()
                            ->native(false),

                        TextInput::make('name')
                            ->label('اسم التخصص')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('مثال: هندسة الحاسوب، الطب البشري'),

                        Select::make('degree_type')
                            ->label('الدرجة العلمية')
                            ->options([
                                'bachelor' => 'بكالوريوس',
                                'diploma' => 'دبلوم',
                            ])
                            ->default('bachelor')
                            ->required()
                            ->native(false),

                        TextInput::make('acceptance_rate')
                            ->label('معدل القبول (%)')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->placeholder('مثال: 85.00'),

                        TextInput::make('credit_hour_price')
                            ->label('سعر الساعة المعتمدة (JD)')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->placeholder('مثال: 35.00'),

                        TextInput::make('total_hours')
                            ->label('إجمالي الساعات الدراسية (اختياري)')
                            ->numeric()
                            ->minValue(0)
                            ->placeholder('مثال: 140'),
                    ])
                    ->columns(2),
            ]);
    }
}
