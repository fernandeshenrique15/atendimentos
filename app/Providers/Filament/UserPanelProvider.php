<?php

namespace App\Providers\Filament;

use App\Filament\Resources\AppointmentResource;
use App\Filament\Resources\ClientResource;
use App\Filament\Resources\ExpenseResource;
use App\Filament\Resources\ExpenseTypeResource;
use App\Filament\Resources\ServiceTypeResource;
use App\Filament\User\Pages\ChangePassword;
use App\Http\Middleware\CheckFirstLogin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
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
            ->profile()
            ->pages([
                Dashboard::class,
                ChangePassword::class,
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
