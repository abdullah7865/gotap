<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // dd("working");
         // Check header request and determine localizaton
        $local = ($request->hasHeader('lang')) ? $request->header('lang') : 'es';
        // set laravel localization
        app()->setLocale($local);
        // continue request
        return $next($request);
    }
}
