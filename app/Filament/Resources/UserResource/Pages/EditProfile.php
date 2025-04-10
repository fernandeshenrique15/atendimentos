<?php

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\EditProfile as AuthEditProfile;

class EditProfile extends AuthEditProfile
{
    public function mount(): void
    {
        parent::mount();
        if (auth()->user()->password_changed_at === null) {
            $this->form->fill(['password' => null]);
        }
    }

    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        TextInput::make('name')->required(),
                        TextInput::make('cpf')->mask('999.999.999-99')->required()->unique(),
                        TextInput::make('email')->email()->required()->unique(),
                        TextInput::make('whatsapp')->mask('(99)99999-9999')->tel()->required(),
                        TextInput::make('password')->password()->autocomplete('new-password')->revealable()->required(),
                        TextInput::make('password_confirm')->password()->revealable()->required(),
                        TextInput::make('commercial_address_street'),
                        TextInput::make('commercial_address_number'),
                        TextInput::make('commercial_address_neighborhood'),
                        TextInput::make('commercial_address_city'),
                        TextInput::make('commercial_address_zipcode'),
                    ])
                    ->statePath('data')
                    ->model($this->getUser())
            ),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
