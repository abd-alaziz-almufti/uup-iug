<?php

namespace App\Filament\Resources\FAQS\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use App\Models\FAQ;
use Filament\Actions\Action;

class FAQSTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('#')
                    ->sortable(),

                TextColumn::make('question')
                    ->label('السؤال')
                    ->searchable()
                    ->limit(60)
                    ->wrap()
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 60) {
                            return null;
                        }
                        return $state;
                    }),

                BadgeColumn::make('category')
                    ->label('التصنيف')
                    ->searchable()
                    ->colors([
                        'primary' => 'التسجيل',
                        'success' => 'المالي',
                        'warning' => 'الامتحانات',
                        'info' => 'العلامات',
                        'danger' => 'التقني',
                    ]),

                TextColumn::make('course.name')
                    ->label('المادة')
                    ->placeholder('عام')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('course.course_code')
                    ->label('رمز المادة')
                    ->placeholder('-')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('تاريخ الإضافة')
                    ->dateTime('Y-m-d')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                BadgeColumn::make('status')
                    ->label('حالة النشر')
                    ->colors([
                        'warning' => FAQ::STATUS_PENDING,
                        'success' => FAQ::STATUS_PUBLISHED,
                        'danger' => FAQ::STATUS_REJECTED,
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        FAQ::STATUS_PENDING => 'قيد المراجعة',
                        FAQ::STATUS_PUBLISHED => 'منشور',
                        FAQ::STATUS_REJECTED => 'مرفوض',
                        default => $state,
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('category')
                    ->label('التصنيف')
                    ->options([
                        'التسجيل' => 'التسجيل',
                        'المالي' => 'المالي',
                        'الامتحانات' => 'الامتحانات',
                        'العلامات' => 'العلامات',
                        'التقني' => 'التقني',
                        'الإداري' => 'الإداري',
                        'عام' => 'عام',
                    ])
                    ->multiple(),

                SelectFilter::make('course_id')
                    ->label('المادة')
                    ->relationship('course', 'name')
                    ->searchable()
                    ->preload(),

                Filter::make('general')
                    ->label('أسئلة عامة فقط')
                    ->query(fn($query) => $query->whereNull('course_id')),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make()->label('عرض'),
                    EditAction::make()->label('تعديل'),
                    DeleteAction::make()->label('حذف'),
                    
                    Action::make('approve')
                        ->label('موافقة ونشر')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->visible(fn (FAQ $record) => $record->status === FAQ::STATUS_PENDING && auth()->user()->hasRole('Academic Supervisor'))
                        ->action(fn (FAQ $record) => $record->update(['status' => FAQ::STATUS_PUBLISHED]))
                        ->requiresConfirmation(),
                        
                    Action::make('reject')
                        ->label('رفض النشر')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->visible(fn (FAQ $record) => $record->status === FAQ::STATUS_PENDING && auth()->user()->hasRole('Academic Supervisor'))
                        ->action(fn (FAQ $record) => $record->update(['status' => FAQ::STATUS_REJECTED]))
                        ->requiresConfirmation(),
                ]),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->label('حذف المحدد'),
                ]),
            ]);
    }
}
