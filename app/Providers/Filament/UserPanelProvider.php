<?php

namespace App\Providers\Filament;

use App\Filament\User\Pages\Finances;
use App\Filament\Resources\AppointmentResource;
use App\Filament\Resources\ClientResource;
use App\Filament\Resources\ExpenseResource;
use App\Filament\Resources\ExpenseTypeResource;
use App\Filament\Resources\ServiceTypeResource;
use App\Filament\User\Pages\ChangePassword;
use App\Filament\User\Pages\EditProfile;
use App\Http\Middleware\CheckFirstLogin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class UserPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('user')
            ->path('user')
            ->login()
            ->passwordReset()
            ->colors([
                'primary' => Color::Red,
            ])
            ->pages([
                ChangePassword::class,
                EditProfile::class,
                Finances::class,
            ])
            ->navigationItems([
                NavigationItem::make('Calendário')
                    ->url('/user/calendar')
                    ->icon('heroicon-o-calendar')
                    ->sort(1),
                NavigationItem::make('Finanças')
                    ->url(fn () => Finances::getUrl())
                    ->icon('heroicon-o-banknotes')
                    ->sort(2),
                NavigationItem::make('Clientes')
                    ->url(fn() => ClientResource::getUrl())
                    ->icon('heroicon-o-users')
                    ->sort(3),
                NavigationItem::make('Atendimentos')
                    ->url(fn() => AppointmentResource::getUrl())
                    ->icon('heroicon-o-clipboard-document-list')
                    ->sort(4),
                NavigationItem::make('Despesas')
                    ->url(fn() => ExpenseResource::getUrl())
                    ->icon('heroicon-o-banknotes')
                    ->sort(5),
                NavigationItem::make('Tipos de Despesas')
                    ->url(fn() => ExpenseTypeResource::getUrl())
                    ->icon('heroicon-o-document-text')
                    ->sort(6),
                NavigationItem::make('Tipos de Serviços')
                    ->url(fn() => ServiceTypeResource::getUrl())
                    ->icon('heroicon-o-wrench-screwdriver')
                    ->sort(7),
            ])
            ->resources([
                ClientResource::class,
                ServiceTypeResource::class,
                AppointmentResource::class,
                ExpenseTypeResource::class,
                ExpenseResource::class,
            ])->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                CheckFirstLogin::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
