<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'Доступ запрещён.');
        }
        return $next($request);
    }
}
