<?php

namespace App\Filament\Resources\ProfileEditRequests;

use App\Filament\Resources\ProfileEditRequests\Pages\ManageProfileEditRequests;
use App\Models\ProfileEditRequest;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Table;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class ProfileEditRequestResource extends Resource
{
    protected static ?string $model = ProfileEditRequest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;
    protected static ?string $navigationLabel = 'طلبات تعديل الطلاب';
    protected static ?string $modelLabel = 'طلب تعديل';
    protected static ?string $pluralModelLabel = 'طلبات التعديل';

    // Only allow Super Admin to access this resource
    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('super_admin');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('student_id')->label('معرف الطالب')->disabled(),
                TextInput::make('requested_by')->label('مقدم الطلب')->disabled(),
                Textarea::make('requested_data')->label('البيانات المقترحة')->disabled()->columnSpanFull(),
                TextInput::make('status')->label('حالة الطلب')->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student.name')
                    ->label('الطالب')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('requester.name')
                    ->label('مقدم الطلب')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('requested_data')
                    ->label('البيانات المقترحة')
                    ->limit(50)
                    ->formatStateUsing(fn ($state) => json_encode($state, JSON_UNESCAPED_UNICODE)),
                BadgeColumn::make('status')
                    ->label('الحالة')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ])
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'pending' => 'قيد الانتظار',
                        'approved' => 'مقبول',
                        'rejected' => 'مرفوض',
                        default => $state,
                    }),
                TextColumn::make('created_at')
                    ->label('تاريخ الطلب')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('approve')
                    ->label('اعتماد للتعديل')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (ProfileEditRequest $record) => $record->status === 'pending')
                    ->action(function (ProfileEditRequest $record) {
                        $student = $record->student;
                        if ($student) {
                            $student->update($record->requested_data);
                            $record->update(['status' => 'approved']);
                            Notification::make()->title('تم اعتماد التعديل بنجاح')->success()->send();
                        }
                    })
                    ->requiresConfirmation(),

                Action::make('reject')
                    ->label('رفض التعديل')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (ProfileEditRequest $record) => $record->status === 'pending')
                    ->action(function (ProfileEditRequest $record) {
                        $record->update(['status' => 'rejected']);
                        Notification::make()->title('تم رفض الطلب')->success()->send();
                    })
                    ->requiresConfirmation(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->with(['student', 'requester']);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageProfileEditRequests::route('/'),
        ];
    }
}
