<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceTypeResource\Pages;
use App\Models\ServiceType;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ServiceTypeResource extends Resource
{
    protected static ?string $model = ServiceType::class;
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $label = 'Tipo de Serviço';
    protected static ?string $pluralLabel = 'Tipos de Serviços';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('description')
                    ->label('Descrição')
                    ->required(),
                TextInput::make('default_price')
                    ->label('Preço Padrão')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->default(0),
                TextInput::make('default_duration')
                    ->label('Duração Padrão')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->default(0)
                    ->helperText('Em minutos'),
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
                TextColumn::make('default_price')
                    ->label('Preço Padrão')
                    ->money('BRL')
                    ->sortable(),
                TextColumn::make('default_duration')
                    ->label('Duração Padrão')
                    ->sortable()
                    ->formatStateUsing(fn($state) => $state . ' min')
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
            'index' => Pages\ListServiceTypes::route('/'),
            'create' => Pages\CreateServiceType::route('/create'),
            'edit' => Pages\EditServiceType::route('/{record}/edit'),
        ];
    }
}
