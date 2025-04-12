<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentResource\Pages;
use App\Models\Appointment;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $label = 'Atendimento';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('client_id')
                    ->relationship('client', 'name')
                    ->required()
                    ->searchable()
                    ->label('Cliente'),
                Select::make('service_type_id')
                    ->relationship('serviceType', 'description')
                    ->required()
                    ->searchable()
                    ->label('Tipo de Serviço'),
                DateTimePicker::make('date')
                    ->required()
                    ->label('Data e Hora')
                    ->minDate(now())
                    ->displayFormat('d/m/Y H:i'),
                TextInput::make('duration')
                    ->required()
                    ->label('Duração (minutos)')
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(480)
                    ->default(60),
                TextInput::make('price')
                    ->required()
                    ->label('Preço')
                    ->numeric()
                    ->prefix('R$ ')
                    ->minValue(0)
                    ->maxValue(10000)
                    ->placeholder('0,00'),
                Toggle::make('is_paid')
                    ->label('Pago')
                    ->default(false),
                Toggle::make('is_recurring')
                    ->label('Recorrente')
                    ->default(false)
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('recurrence_count', $state ? 0 : null);
                    }),
                Select::make('recurrence_count')
                    ->label('Recorrência')
                    ->placeholder('Selecione a recorrência')
                    ->options([
                        1 => 'Uma vez',
                        2 => 'Duas vezes',
                        3 => 'Três vezes',
                        4 => 'Quatro vezes',
                        5 => 'Cinco vezes',
                    ])
                    ->default(0)
                    ->hidden(fn (callable $get) => !$get('is_recurring'))
                    ->reactive(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('client.name')
                    ->label('Cliente')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('serviceType.description')
                    ->label('Tipo de Serviço')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('date')
                    ->label('Data e Hora')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                TextColumn::make('duration')
                    ->label('Duração (minutos)')
                    ->sortable(),
                TextColumn::make('price')   
                    ->label('Preço')
                    ->money('BRL', true)
                    ->sortable(),
                ToggleColumn::make('is_paid')
                    ->label('Pago')
                    ->sortable(),
                TextColumn::make('is_recurring')
                    ->label('Recorrente')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => $state === '1' ? 'Sim' : 'Não')
                    ->color(fn (string $state): string => $state === '1' ? 'success' : 'danger')
                    ->sortable(),
                TextColumn::make('recurrence_count')
                    ->label('Recorrência')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}
