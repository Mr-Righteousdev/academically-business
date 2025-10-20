<?php

namespace App\Filament\Resources\Leads\Tables;

use App\Models\Lead;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class LeadsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('service_interested')
                    ->searchable()
                    ->limit(30),
                TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'secondary' => 'new',
                        'info' => 'contacted',
                        'warning' => 'qualified',
                        'primary' => 'quoted',
                        'success' => 'won',
                        'danger' => 'lost',
                    ]),
                TextColumn::make('source')
                    ->badge(),
                TextColumn::make('created_at')
                    ->label('Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('contacted_at')
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status'),
                SelectFilter::make('source'),
            ])
            ->recordActions([
                Action::make('convert')
                    ->label('Convert to Client')
                    ->icon('heroicon-o-arrow-right')
                    ->color('success')
                    ->visible(fn (Lead $record) => !in_array($record->status, ['won', 'lost']))
                    ->requiresConfirmation()
                    ->action(function (Lead $record) {
                        $client = $record->convertToClient($record);
                        Notification::make()
                            ->title('Lead converted to client!')
                            ->success()
                            ->send();
                        return redirect()->route('filament.admin.resources.clients.view', $client);
                    }),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
