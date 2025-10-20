<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use App\Filament\Resources\Projects\ProjectResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ExpensesRelationManager extends RelationManager
{
    protected static string $relationship = 'expenses';

    protected static ?string $relatedResource = ProjectResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('expense_date')->date(),
                TextColumn::make('category')->badge(),
                TextColumn::make('description')->limit(40),
                TextColumn::make('amount')->money('UGX'),
            ])
            ->defaultSort('expense_date', 'desc');
    }
}
