<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class Guestaw
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Session::has('usuario')) {
            return $next($request);
        } else {
            if (!Session::has('empresas')) {
                return $next($request);
            } else {
                return Redirect::to('/bienvenido');
            }
        }
    }
}
