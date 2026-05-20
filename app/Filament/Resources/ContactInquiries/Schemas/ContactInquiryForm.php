<?php

namespace App\Filament\Resources\ContactInquiries\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactInquiryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('تفاصيل الاستفسار')
                    ->schema([
                        TextInput::make('name')
                            ->label('الاسم')
                            ->disabled()
                            ->required(),

                        TextInput::make('email')
                            ->label('البريد الإلكتروني')
                            ->disabled()
                            ->required(),

                        TextInput::make('subject')
                            ->label('الموضوع')
                            ->disabled(),

                        Textarea::make('message')
                            ->label('الرسالة')
                            ->disabled()
                            ->required()
                            ->rows(5)
                            ->columnSpanFull(),
                    ])
                    ->columns(3),

                Section::make('الحالة والمتابعة')
                    ->schema([
                        Select::make('status')
                            ->label('حالة الاستفسار')
                            ->options([
                                'pending' => 'قيد الانتظار',
                                'replied' => 'تم الرد',
                                'archived' => 'مؤرشف',
                            ])
                            ->required()
                            ->native(false),
                    ]),
            ]);
    }
}
