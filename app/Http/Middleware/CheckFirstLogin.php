<?php

namespace App\Http\Middleware;

use App\Filament\User\Pages\ChangePassword;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckFirstLogin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user == null)
            return $next($request);

        if ($user->first_login && $request->path() !== 'user/change-password') {
            return redirect(ChangePassword::getUrl());
        }

        if (!$user->first_login && $request->path() == 'user/change-password') {
            return redirect('user');
        }

        return $next($request);
    }
}
