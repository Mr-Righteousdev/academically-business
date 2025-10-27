<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use App\Filament\Resources\Projects\ProjectResource;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TimeLogsRelationManager extends RelationManager
{
    protected static string $relationship = 'timelogs';

    protected static ?string $relatedResource = ProjectResource::class;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('task_id')
                    ->relationship('task', 'title')
                    ->searchable(),
                DateTimePicker::make('started_at')
                    ->required(),
                DateTimePicker::make('ended_at'),
                TextInput::make('minutes')
                    ->numeric()
                    ->suffix('minutes')
                    ->helperText('Auto-calculated if start/end times are set'),
                Textarea::make('description')
                    ->rows(2)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('started_at')->dateTime(),
                TextColumn::make('user.name'),
                TextColumn::make('task.title')->limit(30),
                TextColumn::make('minutes')->suffix(' min'),
                TextColumn::make('description')->limit(40),
            ])
            ->defaultSort('started_at', 'desc')
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
