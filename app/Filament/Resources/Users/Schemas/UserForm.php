<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('المعلومات الأساسية')
                    ->schema([
                        TextInput::make('university_id')
                            ->label('الرقم الجامعي')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(20),

                        TextInput::make('name')
                            ->label('الاسم الكامل')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('email')
                            ->label('البريد الإلكتروني')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        TextInput::make('password')
                            ->label('كلمة المرور')
                            ->password()
                            ->dehydrateStateUsing(fn($state) => Hash::make($state))
                            ->dehydrated(fn($state) => filled($state))
                            ->required(fn(string $context): bool => $context === 'create')
                            ->maxLength(255)
                            ->helperText('اتركها فارغة للحفاظ على كلمة المرور الحالية'),
                    ])
                    ->columns(2),

                Section::make('الدور والقسم')
                    ->schema([
                        Select::make('role_id')
                            ->label('الدور')
                            ->relationship('role', 'role_name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->native(false),

                        Select::make('department_id')
                            ->label('القسم/الكلية')
                            ->relationship('department', 'name')
                            ->searchable()
                            ->preload()
                            ->placeholder('اختر القسم')
                            ->native(false),
                    ])
                    ->columns(2),
            ]);
    }
}