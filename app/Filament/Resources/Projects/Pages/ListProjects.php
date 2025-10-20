<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use App\Models\Project;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Support\Facades\Auth;

class ListProjects extends ListRecords
{
    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Projects'),
            'in_progress' => Tab::make('In Progress')
                ->modifyQueryUsing(fn ($query) => $query->where('status', 'in_progress'))
                ->badge(fn () => \App\Models\Project::where('status', 'in_progress')->count()),
            'overdue' => Tab::make('Overdue')
                ->modifyQueryUsing(fn ($query) => $query->where('deadline', '<', now())
                    ->whereNotIn('status', ['completed', 'delivered', 'cancelled']))
                ->badge(fn () => \App\Models\Project::where('deadline', '<', now())
                    ->whereNotIn('status', ['completed', 'delivered', 'cancelled'])->count())
                ->badgeColor('danger'),
            'unpaid' => Tab::make('Unpaid Balance')
                ->modifyQueryUsing(fn ($query) => $query->where('balance', '>', 0))
                ->badge(fn () => \App\Models\Project::where('balance', '>', 0)->count())
                ->badgeColor('warning'),
            'my_projects' => Tab::make('My Projects')
                ->modifyQueryUsing(fn ($query) => $query->where('assigned_to', Auth::user()->id)),
        ];
    }
}
