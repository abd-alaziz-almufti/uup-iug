<?php

namespace App\Filament\Resources\Contacts\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('المعلومات الأساسية')
                    ->schema([
                        TextInput::make('name')
                            ->label('الاسم الكامل')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('position')
                            ->label('المنصب')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('مثال: عميد الكلية، رئيس القسم'),

                        TextInput::make('email')
                            ->label('البريد الإلكتروني')
                            ->email()
                            ->required()
                            ->maxLength(255),

                        TextInput::make('phone')
                            ->label('رقم الهاتف')
                            ->tel()
                            ->required()
                            ->maxLength(20),

                        TextInput::make('office')
                            ->label('مكان المكتب')
                            ->maxLength(255)
                            ->placeholder('مثال: مبنى الإدارة، الطابق الثالث'),
                    ])
                    ->columns(2),

                Section::make('الارتباط')
                    ->schema([
                        Select::make('department_id')
                            ->label('القسم/الكلية')
                            ->relationship('department', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->native(false),

                        Select::make('user_id')
                            ->label('حساب المستخدم (اختياري)')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->placeholder('ربط بحساب موجود')
                            ->native(false)
                            ->helperText('اترك فارغاً إذا لم يكن لديه حساب في النظام'),
                    ])
                    ->columns(2),
            ]);
    }
}