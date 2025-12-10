<?php

namespace App\Http\Middleware; // ⬅️ Poprawna przestrzeń nazw

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin // ⬅️ Poprawna nazwa klasy
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            // Użyjemy trasy logowania, którą zainstalował Breeze
            return redirect()->route('login'); 
        }
        return $next($request);
    }
}