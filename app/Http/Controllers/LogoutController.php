<?php

namespace App\Http\Controllers;

use App\Models\Usuari;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LogoutController extends Controller
{
    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @OA\Post(
     *    path="/logout",
     *    tags={"Logout"},
     *    summary="Logout",
     *    description="Fa logout del actual usuari, eliminant el seu token de la base de dades",
     *    security={{"bearerAuth":{}}},
     *    @OA\Response(
     *         response=200,
     *         description="success"
     *    )
     *  )
     */
    public function logout(Request $request)
    {
        $usuari = Usuari::where("ID_USUARI",$request->validat_id)->first();
        $usuari->TOKEN =null;

        if ($usuari->save()) {
            return response()->json(['status' => 'success','message' => ""], 200);
        } else {
            return response()->json(['status' => 'error','message' => 'Error fent logout'], 400);
        }
    }
}