<?php

namespace App\Http\Middleware;

use App\Models\Usuari;
use Closure;
use Illuminate\Http\Request;

class TokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->header('Authorization')) { // Hem rebut el header d’autorització?
            $key = explode(' ',$request->header('Authorization'));
            if (count($key)!=2) {
                return response()->json(["error" => "Access no autoritzat"], 401);
            }
            $token=$key[1];

            if ($token === null || trim($token) === "") {
                return response()->json(['error' => "Acces no autoritzat"],401);
            }
            $usuari = Usuari::where("TOKEN",$token)->first();
            if (!empty($usuari)) {
                $admin = $usuari->ADMINISTRADOR;
                $id = $usuari->ID_USUARI;
                $request->merge(["esAdministrador"=>$admin, "validat_id" => $id]);
                return($next($request));
            }else {
                return response()->json(['error' => 'Accés no autoritzat'], 401);
            }
        } else {
            return response()->json(['error' => 'Token no rebut'], 401);
        }
    }
}