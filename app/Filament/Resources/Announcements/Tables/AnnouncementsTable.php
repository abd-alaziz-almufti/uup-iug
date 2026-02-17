<?php

namespace App\Filament\Resources\Announcements\Tables;

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

class AnnouncementsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('العنوان')
                    ->searchable()
                    ->limit(50),

                BadgeColumn::make('type')
                    ->label('النوع')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'general' => 'عام',
                        'academic' => 'أكاديمي',
                        'event' => 'حدث',
                        'emergency' => 'طوارئ',
                        default => $state,
                    })
                    ->colors([
                        'primary' => 'general',
                        'info' => 'academic',
                        'success' => 'event',
                        'danger' => 'emergency',
                    ]),

                BadgeColumn::make('priority')
                    ->label('الأولوية')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'low' => 'منخفضة',
                        'normal' => 'عادية',
                        'high' => 'عالية',
                        default => $state,
                    })
                    ->colors([
                        'gray' => 'low',
                        'primary' => 'normal',
                        'danger' => 'high',
                    ]),

                TextColumn::make('department.name')
                    ->label('القسم')
                    ->placeholder('عام')
                    ->toggleable(),

                TextColumn::make('publisher.name')
                    ->label('الناشر')
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('تاريخ النشر')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('type')
                    ->label('النوع')
                    ->options([
                        'general' => 'عام',
                        'academic' => 'أكاديمي',
                        'event' => 'حدث',
                        'emergency' => 'طوارئ',
                    ])
                    ->multiple(),

                SelectFilter::make('priority')
                    ->label('الأولوية')
                    ->options([
                        'low' => 'منخفضة',
                        'normal' => 'عادية',
                        'high' => 'عالية',
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