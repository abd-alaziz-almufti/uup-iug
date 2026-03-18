<?php

namespace App\Filament\Resources\Tickets\RelationManagers;

use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RepliesRelationManager extends RelationManager
{
    protected static string $relationship = 'replies';

    protected static ?string $title = 'الردود والمحادثة';

    protected static ?string $modelLabel = 'رد';

    protected static ?string $pluralModelLabel = 'الردود';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Textarea::make('reply_text')
                    ->label('نص الرد')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
                
                Forms\Components\Hidden::make('user_id')
                    ->default(auth()->id())
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('reply_text')
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('المرسل')
                    ->description(fn ($record) => $record->user->hasRole(['Support Agent', 'Super Admin', 'super_admin']) ? 'موظف' : 'طالب')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('reply_text')
                    ->label('الرسالة')
                    ->wrap()
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('التوقيت')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'asc')
            ->filters([
                //
            ])
            ->headerActions([
                \Filament\Actions\CreateAction::make()
                    ->label('إضافة رد جديد')
                    ->modalHeading('كتابة رد على التذكرة')
                    ->successNotificationTitle('تم إرسال الرد بنجاح')
                    ->visible(fn () => 
                        auth()->user()->hasRole(['Super Admin', 'super_admin']) || 
                        $this->getOwnerRecord()->assigned_to === auth()->id() ||
                        $this->getOwnerRecord()->department_id === auth()->user()->department_id
                    ),
            ])
            ->actions([
                \Filament\Actions\EditAction::make()
                    ->visible(fn ($record) => $record->user_id === auth()->id()),
                \Filament\Actions\DeleteAction::make()
                    ->visible(fn ($record) => auth()->user()->hasRole(['Super Admin', 'super_admin'])),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make()
                        ->visible(fn () => auth()->user()->hasRole(['Super Admin', 'super_admin'])),
                ]),
            ]);
    }
}
