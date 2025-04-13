<?php

namespace App\Filament\User\Pages;

use App\Filament\Resources\UserResource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Hash;

class ChangePassword extends Page
{
    protected static string $view = 'filament.user.pages.change-password';
    protected static string $resource = UserResource::class;
    protected static ?string $title = 'Alterar Senha';
    protected static bool $shouldRegisterNavigation = false;
    public array $data = [];

    public function mount(): void
    {
        if (!auth()->user()->needsPasswordChange()) {
            $this->redirect($this->getResource()::getUrl('index'));
        }
    }

    public function form(Form $form): Form
    {
        return
            $this->makeForm()
            ->schema([
                TextInput::make('password')->password()->autocomplete('new-password')->revealable()->required(),
                TextInput::make('password_confirm')->password()->revealable()->required(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $user = auth()->user();
        $user->password = Hash::make($data['password']);
        $user->first_login = false;
        $user->save();

        Notification::make()
            ->title('Senha alterada com sucesso!')
            ->success()
            ->send();

        $this->redirect(Finances::getUrl());
    }

    protected function getResource(): string
    {
        return UserResource::class;
    }
}
