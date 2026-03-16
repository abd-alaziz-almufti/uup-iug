<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use App\Models\ProfileEditRequest;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('#')
                    ->sortable(),

                TextColumn::make('university_id')
                    ->label('الرقم الجامعي')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('تم النسخ'),

                TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('البريد الإلكتروني')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                BadgeColumn::make('roles.name')
                    ->label('الدور')
                    ->colors([
                        'danger' => 'Super Admin',
                        'warning' => 'Support Agent',
                        'info' => 'Academic Supervisor',
                        'success' => 'Student',
                    ])
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'Super Admin' => 'مدير',
                        'super_admin' => 'مدير',
                        'Support Agent' => 'موظف دعم',
                        'Academic Supervisor' => 'مشرف أكاديمي',
                        'Content Manager' => 'مدير محتوى',
                        'Student' => 'طالب',
                        default => $state,
                    }),

                TextColumn::make('department.name')
                    ->label('القسم')
                    ->placeholder('غير محدد')
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('تاريخ التسجيل')
                    ->dateTime('Y-m-d')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')

            ->filters([
                SelectFilter::make('roles')
                    ->label('الدور')
                    ->relationship('roles', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('department_id')
                    ->label('القسم')
                    ->relationship('department', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make()
                        ->label('عرض'),
                    EditAction::make()
                        ->label('تعديل')
                        ->visible(fn () => auth()->user()->hasRole('Super Admin')), // Only Super Admin can edit directly
                    DeleteAction::make()
                        ->label('حذف')
                        ->visible(fn () => auth()->user()->hasRole('Super Admin')),
                        
                    Action::make('suggest_edit')
                        ->label('اقتراح تعديل بيانات')
                        ->icon('heroicon-o-pencil-square')
                        ->color('warning')
                        ->visible(fn (User $record) => auth()->user()->hasRole('Academic Supervisor') && $record->hasRole('Student'))
                        ->form([
                            TextInput::make('name')
                                ->label('الاسم')
                                ->required()
                                ->default(fn (User $record) => $record->name),
                            TextInput::make('email')
                                ->label('البريد الإلكتروني')
                                ->email()
                                ->required()
                                ->default(fn (User $record) => $record->email),
                            TextInput::make('university_id')
                                ->label('الرقم الجامعي')
                                ->required()
                                ->default(fn (User $record) => $record->university_id),
                        ])
                        ->action(function (array $data, User $record) {
                            ProfileEditRequest::create([
                                'student_id' => $record->id,
                                'requested_by' => auth()->id(),
                                'requested_data' => $data,
                                'status' => 'pending',
                            ]);
                            Notification::make()
                                ->title('تم إرسال اقتراح التعديل بنجاح لمدير النظام')
                                ->success()
                                ->send();
                        }),
                ]),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('حذف المحدد'),
                ]),
            ]);
    }
}
