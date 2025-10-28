<?php

namespace App\Filament\Resources\Disbursements;

use App\Filament\Resources\Disbursements\Pages\CreateDisbursement;
use App\Filament\Resources\Disbursements\Pages\EditDisbursement;
use App\Filament\Resources\Disbursements\Pages\ListDisbursements;
use App\Filament\Resources\Disbursements\Pages\ViewDisbursement;
use App\Filament\Resources\Disbursements\Schemas\DisbursementForm;
use App\Filament\Resources\Disbursements\Schemas\DisbursementInfolist;
use App\Filament\Resources\Disbursements\Tables\DisbursementsTable;
use App\Models\Disbursement;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;

class DisbursementResource extends Resource
{
    protected static ?string $model = Disbursement::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Banknotes;

    public static function form(Schema $schema): Schema
    {
        // return DisbursementForm::configure($schema);
        return $schema->schema([
            Select::make('user_id')
                ->label('Recipient')
                ->relationship('user', 'name')
                ->searchable()
                ->required(),

            TextInput::make('amount')
                ->numeric()
                ->prefix('UGX')
                ->required(),

            DatePicker::make('disbursed_on')
                ->label('Disbursed On')
                ->default(now())
                ->required(),

            Select::make('method')
                ->options([
                    'cash' => 'Cash',
                    'mobile_money' => 'Mobile Money',
                    'bank' => 'Bank Transfer',
                ])
                ->required(),

            Textarea::make('notes')
                ->rows(2)
                ->placeholder('Notes or reason for this disbursement...'),
        ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DisbursementInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        // return DisbursementsTable::configure($table);
        return $table
            ->columns([
                TextColumn::make('user.name')->label('Recipient'),
                TextColumn::make('amount')->money('UGX'),
                TextColumn::make('method')->badge(),
                TextColumn::make('disbursed_on')->date(),
                TextColumn::make('recorder.name')->label('Recorded By'),
                TextColumn::make('created_at')->since(),
            ])
            ->filters([
                Filter::make('this_month')
                    ->query(fn($query) => $query->whereMonth('disbursed_on', now()->month))
                    ->label('This Month'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->defaultSort('disbursed_on', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDisbursements::route('/'),
            // 'create' => CreateDisbursement::route('/create'),
            'view' => ViewDisbursement::route('/{record}'),
            // 'edit' => EditDisbursement::route('/{record}/edit'),
        ];
    }
}
