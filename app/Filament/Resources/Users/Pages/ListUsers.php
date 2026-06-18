<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ListUsers extends ManageRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => \Filament\Schemas\Components\Tabs\Tab::make('الكل'),
            'students' => \Filament\Schemas\Components\Tabs\Tab::make('الطلاب')
                ->modifyQueryUsing(fn ($query) => $query->role('Student')),
            'deans' => \Filament\Schemas\Components\Tabs\Tab::make('العمداء')
                ->modifyQueryUsing(fn ($query) => $query->role('Dean')),
            'instructors' => \Filament\Schemas\Components\Tabs\Tab::make('المدرسون')
                ->modifyQueryUsing(fn ($query) => $query->role('Instructor')),
            'supervisors' => \Filament\Schemas\Components\Tabs\Tab::make('المشرفون الأكاديميون')
                ->modifyQueryUsing(fn ($query) => $query->role('Academic Supervisor')),
            'admission' => \Filament\Schemas\Components\Tabs\Tab::make('موظفو القبول والتسجيل')
                ->modifyQueryUsing(fn ($query) => $query->role('Admission Officer')),
            'support' => \Filament\Schemas\Components\Tabs\Tab::make('موظفو الدعم')
                ->modifyQueryUsing(fn ($query) => $query->role('Support Agent')),
        ];
    }
}
