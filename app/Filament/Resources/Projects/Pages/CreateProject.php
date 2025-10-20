<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProject extends CreateRecord
{
    protected static string $resource = ProjectResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Set balance from agreed price if not set
        if (isset($data['agreed_price']) && !isset($data['balance'])) {
            $data['balance'] = $data['agreed_price'] - ($data['deposit_paid'] ?? 0);
        }
        return $data;
    }
}
