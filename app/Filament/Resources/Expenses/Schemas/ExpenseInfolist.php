<?php

namespace App\Filament\Resources\Expenses\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ExpenseInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('User'),
                TextEntry::make('project.title')
                    ->label('Project')
                    ->placeholder('-'),
                TextEntry::make('category')
                    ->badge(),
                TextEntry::make('amount')
                    ->numeric(),
                TextEntry::make('description')
                    ->columnSpanFull(),
                TextEntry::make('expense_date')
                    ->date(),
                TextEntry::make('receipt_path')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
