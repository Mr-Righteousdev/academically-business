<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use App\Filament\Resources\Projects\ProjectResource;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TasksRelationManager extends RelationManager
{
    protected static string $relationship = 'tasks';

    protected static ?string $relatedResource = ProjectResource::class;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Textarea::make('description')
                    ->rows(3),
                Select::make('assigned_to')
                    ->relationship('assignedUser', 'name')
                    ->searchable(),
                Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'in_progress' => 'In Progress',
                        'completed' => 'Completed',
                        'blocked' => 'Blocked',
                    ])
                    ->default('pending')
                    ->required(),
                DatePicker::make('due_date'),
                TextInput::make('estimated_minutes')
                    ->numeric()
                    ->suffix('minutes'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),
                TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'secondary' => 'pending',
                        'warning' => 'in_progress',
                        'success' => 'completed',
                        'danger' => 'blocked',
                    ]),
                TextColumn::make('assignedUser.name'),
                TextColumn::make('due_date')->date(),
                TextColumn::make('actual_minutes')->suffix(' min'),
            ])
            ->reorderable('order')
            ->defaultSort('order')
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
