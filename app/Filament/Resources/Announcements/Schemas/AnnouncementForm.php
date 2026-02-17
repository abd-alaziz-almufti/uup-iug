<?php

namespace App\Filament\Resources\Announcements\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AnnouncementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('محتوى الإعلان')
                    ->schema([
                        TextInput::make('title')
                            ->label('العنوان')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        RichEditor::make('content')
                            ->label('المحتوى')
                            ->required()
                            ->columnSpanFull(),
                    ]),

                Section::make('التصنيف')
                    ->schema([
                        Select::make('type')
                            ->label('النوع')
                            ->options([
                                'general' => 'عام',
                                'academic' => 'أكاديمي',
                                'event' => 'حدث',
                                'emergency' => 'طوارئ',
                            ])
                            ->required()
                            ->native(false),

                        Select::make('priority')
                            ->label('الأولوية')
                            ->options([
                                'low' => 'منخفضة',
                                'normal' => 'عادية',
                                'high' => 'عالية',
                            ])
                            ->default('normal')
                            ->required()
                            ->native(false),

                        Select::make('department_id')
                            ->label('القسم')
                            ->relationship('department', 'name')
                            ->searchable()
                            ->preload()
                            ->placeholder('عام (كل الجامعة)')
                            ->native(false),

                        Select::make('published_by')
                            ->label('الناشر')
                            ->relationship('publisher', 'name')
                            ->default(fn() => auth()->id())
                            ->required()
                            ->disabled()
                            ->dehydrated(),
                    ])
                    ->columns(2),
            ]);
    }
}
