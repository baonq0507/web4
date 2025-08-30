<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LanguageAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session('language-admin')) {
            app()->setLocale(session('language-admin'));
        } else {
            session(['language-admin' => 'vi']);
            app()->setLocale('vi');
        }
        return $next($request);
    }
}
