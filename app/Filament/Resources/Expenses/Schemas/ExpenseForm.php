<?php

namespace App\Filament\Resources\Expenses\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class ExpenseForm
{
    // public static function configure(Schema $schema): Schema
    // {
    //     return $schema
    //         ->components([
    //             Select::make('user_id')
    //                 ->relationship('user', 'name')
    //                 ->required(),
    //             Select::make('project_id')
    //                 ->relationship('project', 'title')
    //                 ->default(null),
    //             Select::make('category')
    //                 ->options([
    //         'printing' => 'Printing',
    //         'data_bundle' => 'Data bundle',
    //         'transport' => 'Transport',
    //         'materials' => 'Materials',
    //         'software' => 'Software',
    //         'marketing' => 'Marketing',
    //         'office_supplies' => 'Office supplies',
    //         'utilities' => 'Utilities',
    //         'other' => 'Other',
    //     ])
    //                 ->required(),
    //             TextInput::make('amount')
    //                 ->required()
    //                 ->numeric(),
    //             Textarea::make('description')
    //                 ->required()
    //                 ->columnSpanFull(),
    //             DatePicker::make('expense_date')
    //                 ->required(),
    //             TextInput::make('receipt_path')
    //                 ->default(null),
    //         ]);
    // }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('category')
                    ->options([
                        'printing' => 'Printing',
                        'data_bundle' => 'Data Bundle',
                        'transport' => 'Transport',
                        'materials' => 'Materials',
                        'software' => 'Software',
                        'marketing' => 'Marketing',
                        'office_supplies' => 'Office Supplies',
                        'utilities' => 'Utilities',
                        'other' => 'Other',
                    ])
                    ->required(),
                Select::make('project_id')
                    ->relationship('project', 'project_number')
                    ->searchable()
                    ->placeholder('Link to project (optional)'),
                TextInput::make('amount')
                    ->numeric()
                    ->prefix('UGX')
                    ->required(),
                DatePicker::make('expense_date')
                    ->required()
                    ->default(now()),
                Textarea::make('description')
                    ->required()
                    ->rows(3)
                    ->columnSpanFull(),
                FileUpload::make('receipt_path')
                    ->label('Receipt')
                    ->image()
                    ->directory('receipts')
                    ->columnSpanFull(),
            ]);
    }
}
