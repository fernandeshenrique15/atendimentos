<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $label = 'Usuário';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('Nome')->required(),
                TextInput::make('cpf')->label('CPF')->mask('999.999.999-99')->required(),
                TextInput::make('email')->label('E-mail')->email()->required(),
                TextInput::make('whatsapp')->label('Whatsapp')->mask('(99)99999-9999')->tel()->required(),
                TextInput::make('password')->label('Senha')->password()->autocomplete('new-password')->revealable()->required()->dehydrateStateUsing(fn ($state) => Hash::make($state)),
                TextInput::make('password_confirm')->label('Confirma senha')->password()->revealable()->required(),
                TextInput::make('commercial_address_street')->label('Endereço comercial'),
                TextInput::make('commercial_address_number')->label('Número'),
                TextInput::make('commercial_address_neighborhood')->label('Bairro'),
                TextInput::make('commercial_address_city')->label('Cidade'),
                TextInput::make('commercial_address_zipcode')->label('CEP')->mask('99999-999'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('email'),
                TextColumn::make('cpf'),
                TextColumn::make('whatsapp'),
                ToggleColumn::make('is_admin')->label('Admin')
                    ->updateStateUsing(function ($record, $state) {
                        $hasAdmin = User::where('is_admin', true)
                            ->where('id', '!=', $record->id)
                            ->exists();

                        if (!$hasAdmin && !$state) {
                            Notification::make()
                                ->title('Ação Bloqueada')
                                ->body('Não é possível remover o último usuário admin.')
                                ->warning()
                                ->send();
                            return true;
                        }

                        $record->update(['is_admin' => $state]);
                        return $state;
                    }),
            ])
            ->filters([/* Filtros */])
            ->actions([EditAction::make(), DeleteAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageUsers::route('/'),
        ];
    }
}
