<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use App\Filament\Resources\Projects\ProjectResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DocumentsRelationManager extends RelationManager
{
    protected static string $relationship = 'documents';

    protected static ?string $relatedResource = ProjectResource::class;

    public function schema(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('type')
                    ->options([
                        'client_brief' => 'Client Brief',
                        'contract' => 'Contract',
                        'deliverable' => 'Deliverable',
                        'revision' => 'Revision',
                        'reference' => 'Reference Material',
                        'other' => 'Other',
                    ])
                    ->required(),
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Textarea::make('description')
                    ->rows(2),
                FileUpload::make('file_path')
                    ->required()
                    ->directory('project-documents')
                    ->preserveFilenames()
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),
                TextColumn::make('type')->badge(),
                TextColumn::make('file_name')->limit(30),
                TextColumn::make('version'),
                TextColumn::make('uploadedBy.name'),
                TextColumn::make('created_at')->date(),
            ])
            ->defaultSort('created_at', 'desc')
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                Action::make('download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn ($record) => asset('storage/' . $record->file_path))
                    ->openUrlInNewTab(),
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
