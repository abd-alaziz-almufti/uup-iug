<?php

namespace App\Filament\Resources\ContactInquiries\Pages;

use App\Filament\Resources\ContactInquiries\ContactInquiryResource;
use Filament\Resources\Pages\ManageRecords;

class ListContactInquiries extends ManageRecords
{
    protected static string $resource = ContactInquiryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // No CreateAction needed since inquiries are sent by students/visitors only
        ];
    }
}
