<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpenseTypeResource\Pages;
use App\Models\ExpenseType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ExpenseTypeResource extends Resource
{
    protected static ?string $model = ExpenseType::class;
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $label = 'Tipo de Despesa';
    protected static ?string $pluralLabel = 'Tipos de Despesas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('description')
                    ->label('Descrição')
                    ->required(),
                Select::make('frequency')
                    ->label('Recorrência')
                    ->placeholder('Selecione uma recorrência')
                    ->options([
                        '0' => 'Aleatória',
                        '1' => 'Diária',
                        '2' => 'Mensal',
                        '3' => 'Anual',
                    ])
                    ->required()
                    ->default('2')
                    ->reactive(),
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
                TextColumn::make('frequency')
                    ->label('Recorrência')
                    ->sortable()
                    ->formatStateUsing(fn($state) => match ($state) {
                        0 => 'Aleatória',
                        1 => 'Diária',
                        2 => 'Mensal',
                        3 => 'Anual',
                    })
                    ->html(),
            ])
            ->filters([])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExpenseTypes::route('/'),
            'create' => Pages\CreateExpenseType::route('/create'),
            'edit' => Pages\EditExpenseType::route('/{record}/edit'),
        ];
    }
}
