<?php

namespace App\Filament\Resources\Courses\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CoursesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('course_code')
                    ->label('رمز المادة')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('تم نسخ رمز المادة')
                    ->badge()
                    ->color('primary'),

                TextColumn::make('name')
                    ->label('اسم المادة')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                TextColumn::make('credit_hours')
                    ->label('الساعات')
                    ->sortable()
                    ->alignCenter()
                    ->badge()
                    ->color('success'),

                TextColumn::make('department.name')
                    ->label('القسم')
                    ->searchable()
                    ->placeholder('عام')
                    ->toggleable(),

                TextColumn::make('faqs_count')
                    ->label('عدد الأسئلة')
                    ->counts('faqs')
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(),

                TextColumn::make('enrollments_count')
                    ->label('عدد المسجلين')
                    ->counts('enrollments')
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('تاريخ الإضافة')
                    ->dateTime('Y-m-d')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('course_code', 'asc')
            ->filters([
                SelectFilter::make('department_id')
                    ->label('القسم')
                    ->relationship('department', 'name')
                    ->searchable()
                    ->preload()
                    ->multiple(),

                SelectFilter::make('credit_hours')
                    ->label('الساعات المعتمدة')
                    ->options([
                        1 => '1 ساعة',
                        2 => '2 ساعات',
                        3 => '3 ساعات',
                        4 => '4 ساعات',
                        6 => '6 ساعات',
                    ])
                    ->multiple(),

                Filter::make('general')
                    ->label('مواد عامة فقط')
                    ->query(fn($query) => $query->whereNull('department_id')),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make()->label('عرض'),
                    EditAction::make()->label('تعديل'),
                    DeleteAction::make()->label('حذف'),
                ]),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->label('حذف المحدد'),
                ]),
            ]);
    }
}