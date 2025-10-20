<?php

namespace App\Filament\Resources\Clients\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CommunicationsRelationManager extends RelationManager
{
    protected static string $relationship = 'communications';

    // public function form(Schema $schema): Schema
    // {
    //     return $schema
    //         ->components([
    //             Select::make('project_id')
    //                 ->relationship('project', 'title')
    //                 ->default(null),
    //             Select::make('user_id')
    //                 ->relationship('user', 'name')
    //                 ->required(),
    //             Select::make('type')
    //                 ->options([
    //         'call' => 'Call',
    //         'whatsapp' => 'Whatsapp',
    //         'email' => 'Email',
    //         'sms' => 'Sms',
    //         'meeting' => 'Meeting',
    //         'other' => 'Other',
    //     ])
    //                 ->required(),
    //             Select::make('direction')
    //                 ->options(['inbound' => 'Inbound', 'outbound' => 'Outbound'])
    //                 ->required(),
    //             Textarea::make('summary')
    //                 ->required()
    //                 ->columnSpanFull(),
    //             Textarea::make('notes')
    //                 ->default(null)
    //                 ->columnSpanFull(),
    //             DateTimePicker::make('communicated_at')
    //                 ->required(),
    //         ]);
    // }

    // public function infolist(Schema $schema): Schema
    // {
    //     return $schema
    //         ->components([
    //             TextEntry::make('project.title')
    //                 ->label('Project')
    //                 ->placeholder('-'),
    //             TextEntry::make('user.name')
    //                 ->label('User'),
    //             TextEntry::make('type')
    //                 ->badge(),
    //             TextEntry::make('direction')
    //                 ->badge(),
    //             TextEntry::make('summary')
    //                 ->columnSpanFull(),
    //             TextEntry::make('notes')
    //                 ->placeholder('-')
    //                 ->columnSpanFull(),
    //             TextEntry::make('communicated_at')
    //                 ->dateTime(),
    //             TextEntry::make('created_at')
    //                 ->dateTime()
    //                 ->placeholder('-'),
    //             TextEntry::make('updated_at')
    //                 ->dateTime()
    //                 ->placeholder('-'),
    //         ]);
    // }

    // public function table(Table $table): Table
    // {
    //     return $table
    //         ->recordTitleAttribute('communication')
    //         ->columns([
    //             TextColumn::make('project.title')
    //                 ->searchable(),
    //             TextColumn::make('user.name')
    //                 ->searchable(),
    //             TextColumn::make('type')
    //                 ->badge(),
    //             TextColumn::make('direction')
    //                 ->badge(),
    //             TextColumn::make('communicated_at')
    //                 ->dateTime()
    //                 ->sortable(),
    //             TextColumn::make('created_at')
    //                 ->dateTime()
    //                 ->sortable()
    //                 ->toggleable(isToggledHiddenByDefault: true),
    //             TextColumn::make('updated_at')
    //                 ->dateTime()
    //                 ->sortable()
    //                 ->toggleable(isToggledHiddenByDefault: true),
    //         ])
    //         ->filters([
    //             //
    //         ])
    //         ->headerActions([
    //             CreateAction::make(),
    //             AssociateAction::make(),
    //         ])
    //         ->recordActions([
    //             ViewAction::make(),
    //             EditAction::make(),
    //             DissociateAction::make(),
    //             DeleteAction::make(),
    //         ])
    //         ->toolbarActions([
    //             BulkActionGroup::make([
    //                 DissociateBulkAction::make(),
    //                 DeleteBulkAction::make(),
    //             ]),
    //         ]);
    // }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('communicated_at')->dateTime(),
                TextColumn::make('type')->badge(),
                TextColumn::make('summary')->limit(50),
                TextColumn::make('user.name'),
            ])
            ->defaultSort('communicated_at', 'desc');
    }
}
