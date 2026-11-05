<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\User;
use Symfony\Component\HttpFoundation\Response;

class Authaw
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
        if (!Session::has('empresas')) {
            if (!Session::has('usuario')) {
                return Redirect::to('/login');
            } else {
                return Redirect::to('/acceso');
            }
        } else {
            if (Session::has('usuario')) {
                /********* verificación de usuario activo **********/
                $usuario = User::where('id', '=', Session::get('usuario')->id)
                                ->where('activo', '=', 1)
                                ->first();                             
                if (!$usuario) {
                    Session::forget('usuario');
                    Session::forget('listamenu');
                    Session::forget('empresas');
                    Session::forget('centros');
                    Session::forget('listaopciones');
                    Session::forget('color');
                    return Redirect::to('/login');
                }  
                /**************************/

                return $next($request);
            } else {
                return Redirect::to('/login');
            }
        }
    }
}
