<?php

namespace App\Filament\Resources\Clients\Pages;

use App\Filament\Resources\Clients\ClientResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;

class ListClients extends ListRecords
{
    protected static string $resource = ClientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Clients'),
            'active' => Tab::make('Active')
                ->modifyQueryUsing(fn ($query) => $query->where('status', 'active')),
            'inquiry' => Tab::make('Inquiries')
                ->modifyQueryUsing(fn ($query) => $query->where('status', 'inquiry')),
            'high_value' => Tab::make('High Value')
                ->modifyQueryUsing(fn ($query) => $query->where('lifetime_value', '>', 500000)),
        ];
    }
}
