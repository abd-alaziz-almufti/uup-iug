<?php

namespace App\Filament\Resources\FAQS\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FAQForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('السؤال والإجابة')
                    ->schema([
                        Textarea::make('question')
                            ->label('السؤال')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),

                        RichEditor::make('answer')
                            ->label('الإجابة')
                            ->required()
                            ->columnSpanFull(),
                    ]),

                Section::make('التصنيف')
                    ->schema([
                        TextInput::make('category')
                            ->label('التصنيف')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('مثال: التسجيل، المالي، الامتحانات')
                            ->datalist([
                                'التسجيل',
                                'المالي',
                                'الامتحانات',
                                'العلامات',
                                'التقني',
                                'الإداري',
                                'عام',
                            ]),

                        Select::make('course_id')
                            ->label('المادة (اختياري)')
                            ->relationship('course', 'name')
                            ->searchable()
                            ->preload()
                            ->placeholder('عام (غير مرتبط بمادة)')
                            ->native(false)
                            ->helperText('اترك فارغاً إذا كان السؤال عاماً'),
                    ])
                    ->columns(2),
            ]);
    }
}