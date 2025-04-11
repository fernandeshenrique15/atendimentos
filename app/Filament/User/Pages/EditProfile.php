<?php

namespace App\Filament\User\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Hash;

class EditProfile extends Page
{
    protected static string $view = 'filament.user.pages.edit-profile';
    protected static bool $shouldRegisterNavigation = true;
    protected static ?string $title = 'Editar Perfil';
    public ?array $data = [];

    public function mount(): void
    {
        $this->data = auth()->user()->toArray();
        unset($this->data['password']);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nome')
                    ->required(),
                TextInput::make('cpf')
                    ->label('CPF')
                    ->mask('999.999.999-99')
                    ->required(),
                TextInput::make('email')
                    ->label('E-mail')
                    ->email()
                    ->required(),
                TextInput::make('whatsapp')
                    ->label('WhatsApp')
                    ->mask('(99)99999-9999')
                    ->tel()
                    ->required(),
                TextInput::make('password')
                    ->label('Nova Senha')
                    ->password()
                    ->autocomplete('new-password')
                    ->revealable()
                    ->nullable(),
                TextInput::make('password_confirm')
                    ->label('Confirme a Nova Senha')
                    ->password()
                    ->revealable()
                    ->same('password')
                    ->nullable()
                    ->dehydrated(fn($state) => !empty($state)),
                TextInput::make('commercial_address_street')
                    ->label('Rua do Endereço Comercial'),
                TextInput::make('commercial_address_number')
                    ->label('Número do Endereço Comercial'),
                TextInput::make('commercial_address_neighborhood')
                    ->label('Bairro do Endereço Comercial'),
                TextInput::make('commercial_address_city')
                    ->label('Cidade do Endereço Comercial'),
                TextInput::make('commercial_address_zipcode')
                    ->label('CEP do Endereço Comercial')
                    ->mask('99999-999'),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $user = auth()->user();

        if (!empty($data['password']))
            $data['password'] = Hash::make($data['password']);
        else
            unset($data['password']);

        unset($data['password_confirm']);
        $user->update($data);

        Notification::make()
            ->title('Perfil atualizado com sucesso!')
            ->success()
            ->send();

        $this->redirect(self::getUrl());
    }
}
