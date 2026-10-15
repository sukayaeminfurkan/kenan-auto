<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Giriş yapmamışsa login'e yönlendir
        if (!auth()->check()) {
            return redirect('/login');
        }

        // Admin değilse anasayfaya yönlendir
        if (!auth()->user()->is_admin) {
            return redirect('/')->with('error', 'Bu sayfaya erişim yetkiniz yok.');
        }

        return $next($request);
    }
}
