<?php

namespace App\Http\Controllers;

use App\Models\Usuari;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /**
     *
     * @OA\Post(
     *    path="/login",
     *    tags={"Login"},
     *    summary="Login per obtenir token de autoritzacio",
     *    description="Utilitza el login per tal de entrar amb les teves credencials i obtenir el token de autoritzacio. Es pot enviar la informacio com a JSON o com a x-www-form-urlencoded.",
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *           @OA\Property(property="CORREU_ELECTRONIC", type="string", format="string", example="isaacpalou@paucasesnovescifp.cat"),
     *           @OA\Property(property="CONTRASENYA", type="string", format="string", example="A_asRna76*e")
     *        ),
     *     ),
     *    @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *              @OA\Property(property="status", type="string", example="Success"),
     *              @OA\Property(property="result",type="string", example="apiKey")
     *         ),
     *    ),
     *    @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *              @OA\Property(property="status", type="string", example="Error"),
     *              @OA\Property(property="result", type="string", example="Les teves credencials son incorrectes")
     *         ),
     *     )
     *  )
     */
    public function login(Request $request)
    {
        $usuari = Usuari::where("CORREU_ELECTRONIC", $request->input("CORREU_ELECTRONIC"))->first();

        if ($usuari && Hash::check($request->input("contrasenya"), $usuari->CONTRASENYA)) {
            $apiKey = base64_encode(Str::random(40));
            $usuari['TOKEN'] = $apiKey;
            $usuari->save();
            return response()->json(['status' => 'Login OK', 'result' => $apiKey]);
        } else {
            return response()->json(['status' => 'Error', 'result' => "Les teves credencials son incorrectes"], 401);
        }
    }
}
