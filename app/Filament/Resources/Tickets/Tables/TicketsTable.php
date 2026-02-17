<?php

namespace App\Filament\Resources\Tickets\Tables;

use App\Models\Ticket;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Tables\Actions;

class TicketsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('#')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('title')
                    ->label('العنوان')
                    ->searchable()
                    ->limit(40)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 40) {
                            return null;
                        }
                        return $state;
                    }),

                BadgeColumn::make('status')
                    ->label('الحالة')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'open' => 'مفتوحة',
                        'in_progress' => 'قيد المعالجة',
                        'resolved' => 'محلولة',
                        'closed' => 'مغلقة',
                        default => $state,
                    })
                    ->colors([
                        'danger' => 'open',
                        'warning' => 'in_progress',
                        'success' => 'resolved',
                        'gray' => 'closed',
                    ])
                    ->icon(fn(string $state): string => match ($state) {
                        'open' => 'heroicon-m-exclamation-circle',
                        'in_progress' => 'heroicon-m-clock',
                        'resolved' => 'heroicon-m-check-circle',
                        'closed' => 'heroicon-m-lock-closed',
                        default => 'heroicon-m-question-mark-circle',
                    }),

                BadgeColumn::make('priority')
                    ->label('الأولوية')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'low' => 'منخفضة',
                        'medium' => 'متوسطة',
                        'high' => 'عالية',
                        'urgent' => 'عاجلة',
                        default => $state,
                    })
                    ->colors([
                        'gray' => 'low',
                        'warning' => 'medium',
                        'danger' => ['high', 'urgent'],
                    ]),

                TextColumn::make('category')
                    ->label('التصنيف')
                    ->badge()
                    ->searchable(),

                TextColumn::make('student.name')
                    ->label('الطالب')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('department.name')
                    ->label('القسم')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('assignedUser.name')
                    ->label('المعين')
                    ->placeholder('غير معين')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('الحالة')
                    ->options([
                        'open' => 'مفتوحة',
                        'in_progress' => 'قيد المعالجة',
                        'resolved' => 'محلولة',
                        'closed' => 'مغلقة',
                    ])
                    ->multiple(),

                SelectFilter::make('priority')
                    ->label('الأولوية')
                    ->options([
                        'low' => 'منخفضة',
                        'medium' => 'متوسطة',
                        'high' => 'عالية',
                        'urgent' => 'عاجلة',
                    ])
                    ->multiple(),

                SelectFilter::make('category')
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
                    ->multiple(),

                SelectFilter::make('department_id')
                    ->label('القسم')
                    ->relationship('department', 'name')
                    ->searchable()
                    ->preload(),

                Filter::make('unassigned')
                    ->label('غير معينة')
                    ->query(fn($query) => $query->whereNull('assigned_to')),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make()
                        ->label('عرض'),

                    EditAction::make()
                        ->label('تعديل'),

                    Action::make('assign')
                        ->label('تعيين لموظف')
                        ->icon('heroicon-m-user-plus')
                        ->color('warning')
                        ->form([
                            Forms\Components\Select::make('assigned_to')
                                ->label('اختر موظف')
                                ->relationship('assignedUser', 'name', function ($query) {
                                    return $query->whereHas('role', function ($q) {
                                        $q->whereIn('role_name', ['Staff', 'Advisor', 'Admin']);
                                    });
                                })
                                ->searchable()
                                ->required(),
                        ])
                        ->action(function (Ticket $record, array $data) {
                            $record->update([
                                'assigned_to' => $data['assigned_to'],
                                'status' => $record->status === 'open' ? 'in_progress' : $record->status,
                            ]);
                        })
                        ->successNotificationTitle('تم تعيين التذكرة بنجاح'),

                    Action::make('changeStatus')
                        ->label('تغيير الحالة')
                        ->icon('heroicon-m-arrow-path')
                        ->color('info')
                        ->form([
                            Forms\Components\Select::make('status')
                                ->label('الحالة الجديدة')
                                ->options([
                                    'open' => 'مفتوحة',
                                    'in_progress' => 'قيد المعالجة',
                                    'resolved' => 'محلولة',
                                    'closed' => 'مغلقة',
                                ])
                                ->required()
                                ->native(false),
                        ])
                        ->action(function (Ticket $record, array $data) {
                            $record->update(['status' => $data['status']]);
                        })
                        ->successNotificationTitle('تم تحديث الحالة بنجاح'),

                    DeleteAction::make()
                        ->label('حذف'),
                ]),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('حذف المحدد'),

                    BulkAction::make('updateStatus')
                        ->label('تحديث الحالة')
                        ->icon('heroicon-m-arrow-path')
                        ->form([
                            Forms\Components\Select::make('status')
                                ->label('الحالة')
                                ->options([
                                    'open' => 'مفتوحة',
                                    'in_progress' => 'قيد المعالجة',
                                    'resolved' => 'محلولة',
                                    'closed' => 'مغلقة',
                                ])
                                ->required()
                                ->native(false),
                        ])
                        ->action(function ($records, array $data) {
                            $records->each->update(['status' => $data['status']]);
                        }),
                ]),
            ]);
    }
}