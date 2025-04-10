<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Filament\Resources\ClientResource\RelationManagers;
use App\Models\Client;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $label = 'Cliente';
    protected static ?string $pluralLabel = 'Clientes';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('Nome')->required(),
                TextInput::make('cpf')->label('CPF')->mask('999.999.999-99')->required(),
                TextInput::make('email')->label('E-mail')->email()->required(),
                TextInput::make('whatsapp')->label('Whatsapp')->mask('(99)99999-9999')->tel()->required(),
                TextInput::make('address_street')->label('Endereço'),
                TextInput::make('address_number')->label('Número'),
                TextInput::make('address_neighborhood')->label('Bairro'),
                TextInput::make('address_city')->label('Cidade'),
                TextInput::make('address_zipcode')->label('CEP')->mask('99999-999'),
                TextInput::make('observations')->label('Observações')->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nome')->searchable(),
                TextColumn::make('cpf')->label('CPF')->searchable(),
                TextColumn::make('whatsapp')->label('Whatsapp'),
                TextColumn::make('email')->label('E-mail'),
            ])
            ->filters([])
            ->actions([
                EditAction::make(),
                DeleteAction::make()
            ]);
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
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        if (!Auth::user()->is_admin)
            return parent::getEloquentQuery()->where('user_id', Auth::id());
        return parent::getEloquentQuery();
    }
}
