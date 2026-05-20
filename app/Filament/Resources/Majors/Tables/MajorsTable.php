<?php

namespace App\Filament\Resources\Majors\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MajorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('اسم التخصص')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('department.name')
                    ->label('الكلية')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('degree_type')
                    ->label('الدرجة العلمية')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'bachelor' => 'بكالوريوس',
                        'diploma' => 'دبلوم',
                        default => $state,
                    })
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'bachelor' => 'primary',
                        'diploma' => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('acceptance_rate')
                    ->label('معدل القبول')
                    ->suffix('%')
                    ->sortable()
                    ->alignCenter(),

                TextColumn::make('credit_hour_price')
                    ->label('سعر الساعة')
                    ->suffix(' JD')
                    ->sortable()
                    ->alignCenter(),

                TextColumn::make('total_hours')
                    ->label('إجمالي الساعات')
                    ->placeholder('-')
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(),
            ])
            ->defaultSort('name', 'asc')
            ->filters([
                SelectFilter::make('department_id')
                    ->label('الكلية')
                    ->relationship('department', 'name', fn ($query) => $query->where('type', 'College'))
                    ->searchable()
                    ->preload(),

                SelectFilter::make('degree_type')
                    ->label('الدرجة العلمية')
                    ->options([
                        'bachelor' => 'بكالوريوس',
                        'diploma' => 'دبلوم',
                    ]),
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
