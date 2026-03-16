<?php

namespace App\Filament\Resources\ProfileEditRequests\Pages;

use App\Filament\Resources\ProfileEditRequests\ProfileEditRequestResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageProfileEditRequests extends ManageRecords
{
    protected static string $resource = ProfileEditRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
