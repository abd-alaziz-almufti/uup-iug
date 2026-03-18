<?php

namespace App\Filament\Resources\Tickets\Schemas;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TicketForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('معلومات التذكرة')
                    ->schema([
                        TextInput::make('title')
                            ->label('العنوان')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Select::make('target_type')
                            ->label('الجهة المستهدفة')
                            ->options([
                                'supervisor' => 'المشرف الأكاديمي',
                                'dean' => 'عميد الكلية',
                                'instructor' => 'مدرس المادة',
                                'admission' => 'القبول والتسجيل',
                            ])
                            ->required()
                            ->live()
                            ->native(false),

                        Select::make('course_id')
                            ->label('المادة الدراسية')
                            ->relationship('course', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->visible(fn (Forms\Get $get) => $get('target_type') === 'instructor'),

                        Select::make('category')
                            ->label('التصنيف')
                            ->options([
                                'تسجيل مواد' => 'تسجيل مواد',
                                'مالي' => 'مالي',
                                'امتحانات' => 'امتحانات',
                                'علامات' => 'علامات',
                                'تقني' => 'تقني',
                                'إداري' => 'إداري',
                                'أخرى' => 'أخرى',
                            ])
                            ->required()
                            ->searchable(),

                        Select::make('status')
                            ->label('الحالة')
                            ->options([
                                'open' => 'مفتوحة',
                                'in_progress' => 'قيد المعالجة',
                                'resolved' => 'محلولة',
                                'closed' => 'مغلقة',
                            ])
                            ->default('open')
                            ->required()
                            ->native(false)
                            ->visible(fn () => auth()->user()->hasRole(['Super Admin', 'super_admin', 'Academic Supervisor', 'Support Agent', 'Dean', 'Instructor', 'Admission Officer'])),

                        Select::make('priority')
                            ->label('الأولوية')
                            ->options([
                                'low' => 'منخفضة',
                                'medium' => 'متوسطة',
                                'high' => 'عالية',
                                'urgent' => 'عاجلة',
                            ])
                            ->default('medium')
                            ->required()
                            ->native(false),
                    ])
                    ->columns(2),

                Section::make('التعيين')
                    ->schema([
                        Select::make('student_id')
                            ->label('الطالب')
                            ->relationship('student', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('department_id')
                            ->label('القسم المسؤول')
                            ->relationship('department', 'name')
                            ->searchable()
                            ->required(),

                        Select::make('assigned_to')
                            ->label('معين لـ')
                            ->relationship('assignedUser', 'name', function ($query) {
                                return $query->whereHas('roles', function ($q) {
                                    $q->whereIn('name', ['Support Agent', 'Super Admin', 'super_admin']);
                                });
                            })
                            ->searchable()
                            ->preload()
                            ->placeholder('غير معين'),
                    ])
                    ->columns(3),
            ]);
    }
}