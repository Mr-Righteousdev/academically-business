<?php

namespace App\Filament\Resources\Clients\RelationManagers;

use App\Filament\Resources\Clients\ClientResource;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class ProjectsRelationManager extends RelationManager
{
    protected static string $relationship = 'projects';

    protected static ?string $relatedResource = ClientResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('project_number'),
                TextColumn::make('title')->limit(30),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('deadline')->date(),
                TextColumn::make('agreed_price')->money('UGX'),
                TextColumn::make('balance')->money('UGX'),
            ])
            ->filters([
                SelectFilter::make('status'),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ]);
    }

}
