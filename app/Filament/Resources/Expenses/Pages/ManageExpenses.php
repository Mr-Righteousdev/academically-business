<?php

namespace App\Filament\Resources\Expenses\Pages;

use App\Filament\Resources\Expenses\ExpenseResource;
use App\Filament\Resources\Expenses\Widgets\RevenueChart;
use App\Filament\Resources\Expenses\Widgets\StatsOverview;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ManageRecords;
use Filament\Schemas\Schema;
use Filament\Support\Enums\IconSize;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class ManageExpenses extends ManageRecords
{
    protected static string $resource = ExpenseResource::class;

    // public static function mutateFormDataBeforeCreate(function (array $data): array {}
    //     {
    //         $data['user_id'] = Auth::user()->id;
    //         return $data;
    //     }
    // }

    protected function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class,
            // RevenueChart::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            // StatsOverview::class,
            RevenueChart::class,
        ];
    }

    protected function getHeaderActions(): array
    {   
        return [
            CreateAction::make()
                ->mutateDataUsing(function (array $data): array {
                    $data['user_id'] = Auth::user()->id;
                    return $data;
                }),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('expense_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('category')
                    ->badge()
                    ->colors([
                        'danger' => 'printing',
                        'warning' => 'data_bundle',
                        'info' => 'transport',
                        'success' => 'marketing',
                    ]),
                TextColumn::make('description')
                    ->limit(50)
                    ->searchable(),
                TextColumn::make('project.project_number')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('amount')
                    ->money('UGX')
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Recorded By')
                    ->toggleable(),
                IconColumn::make('receipt_path')
                    ->size(IconSize::Large)
                    ->label('Receipt')
                    ->boolean(),
                
            ])
            ->filters([
                SelectFilter::make('category')
                    ->options([
                        'printing' => 'Printing',
                        'data_bundle' => 'Data',
                        'transport' => 'Transport',
                        'materials' => 'Materials',
                        'software' => 'Software',
                        'marketing' => 'Marketing',
                        'office_supplies' => 'Office Supplies',
                        'utilities' => 'Utilities',
                        'other' => 'Others' 
                    ]),
                Filter::make('expense_date')
                    ->schema([
                        DatePicker::make('from'),
                        DatePicker::make('until'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn ($q, $date) => $q->whereDate('expense_date', '>=', $date))
                            ->when($data['until'], fn ($q, $date) => $q->whereDate('expense_date', '<=', $date));
                    }),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('expense_date', 'desc');
    }

    public function form(Schema $schema): Schema
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