<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpenseResource\Pages;
use App\Models\Expense;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class ExpenseResource extends Resource
{
    protected static ?string $model = Expense::class;
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $label = 'Despesa';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('description')
                    ->label('Descrição')
                    ->required(),
                TextInput::make('price')
                    ->label('Valor')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(999999.99)
                    ->placeholder('0,00')
                    ->prefix('R$ '),
                DatePicker::make('date')
                    ->label('Data')
                    ->required()
                    ->placeholder('Selecione uma data'),
                Toggle::make('is_paid')
                    ->label('Pago')
                    ->required()
                    ->default(false),
                Select::make('expense_type_id')
                    ->label('Tipo de Despesa')
                    ->relationship('expenseType', 'description')
                    ->required()
                    ->searchable()
                    ->placeholder('Selecione um tipo de despesa'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('description')
                    ->label('Descrição')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('price')
                    ->label('Valor')
                    ->money('BRL', true)
                    ->sortable(),
                TextColumn::make('date')
                    ->label('Data')
                    ->date()
                    ->sortable(),
                ToggleColumn::make('is_paid')
                    ->label('Pago')
                    ->sortable(),
                TextColumn::make('expenseType.description')
                    ->label('Tipo de Despesa')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([])
            ->actions([
                EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExpenses::route('/'),
            'create' => Pages\CreateExpense::route('/create'),
            'edit' => Pages\EditExpense::route('/{record}/edit'),
        ];
    }
}
