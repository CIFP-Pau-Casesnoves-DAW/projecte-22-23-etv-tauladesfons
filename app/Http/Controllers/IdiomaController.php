<?php

namespace App\Http\Controllers;

use App\Models\Idioma;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;

/** @OA\Tag(name="Idiomes")*/
class IdiomaController extends Controller
// ! GET DE TOTS
{
    /**
     * @OA\Get(
     *     path="/idiomes",
     *     summary="Llista de idiomes",
     *     tags={"Idiomes"},
     *     @OA\Response(
     *     response=200,
     *     description="Llista de idiomes",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Idiomes")
     *    )
     *  )
     * )
     * @OA\Schema(
     *     schema="Idiomes",
     *     type="object",
     *     @OA\Property(property="NOM_IDIOMA", type="string")
     * )
     */
        // ! GET DE TOTS
    public function  getAllIdiomes()
    {
        $tuples = Idioma::all();
        return response()->json(['status' => 'success', 'data' => $tuples], 200);
    }
    // ! POST D'UN IDIOMA
    /**
     * @OA\Post(
     *     path="/idiomes",
     *     summary="Crea un idioma",
     *     tags={"Idiomes"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *     description="Dades del nou idioma",
     *     required=true,
     *     @OA\JsonContent(ref="#/components/schemas/Idiomes")
     * ),
     *     @OA\Response(
     *     response=200,
     *     description="Idioma creat",
     *     @OA\JsonContent(ref="#/components/schemas/Idiomes")
     * ),
     *     @OA\Response(
     *     response=400,
     *     description="Error de validació",
     *     @OA\JsonContent(ref="#/components/schemas/Error")
     * )
     * )
     * @OA\Schema(
     *     schema="Error",
     *     type="object",
     *     @OA\Property(property="message", type="string"),
     *     @OA\Property(property="errors", type="object")
     * )
     */
    public function insertIdioma(Request $request)
    {
        if ($request->esAdministrador) {
            $reglesvalidacio = [
                'NOM_IDIOMA' => 'required|string|max:50'
            ];
            $missatges = [
                'NOM_IDIOMA.required' => 'El camp NOM_IDIOMA és obligatori',
                'NOM_IDIOMA.string' => 'El camp NOM_IDIOMA ha de ser una cadena de caràcters',
                'NOM_IDIOMA.max' => 'El camp NOM_IDIOMA no pot tenir més de 50 caràcters.'
            ];
            $validador = Validator::make($request->all(), $reglesvalidacio, $missatges);
            if ($validador->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validador->errors()
                ], 400);
            } else {
                $idioma = Idioma::firstOrCreate(['NOM_IDIOMA' => $request->NOM_IDIOMA]);
                if ($idioma->wasRecentlyCreated) {
                    return response()->json([
                        'status' => 'success',
                        'data' => $idioma
                    ], 201);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'L\'idioma ja existeix'
                    ], 409);
                }
            }
        }else{
            return response()->json(['status' => 'error', 'message' => 'Permisos insuficients']);
        }

    }
    // ! GET DE UN IDIOMA
    /**
     * @OA\Get(
     *     path="/idiomes/{id}",
     *     summary="Mostra un idioma",
     *     tags={"Idiomes"},
     *     @OA\Parameter(
     *     description="ID del idioma",
     *     in="path",
     *     name="id",
     *     required=true,
     *     @OA\Schema(
     *     type="integer"
     *   )
     * ),
     *     @OA\Response(
     *     response=200,
     *     description="Idioma",
     *     @OA\JsonContent(ref="#/components/schemas/Idiomes")
     * ),
     *     @OA\Response(
     *     response=404,
     *     description="No s'ha trobat cap idioma amb aquest ID",
     *     @OA\JsonContent(ref="#/components/schemas/Error")
     * )
     * )
     */
    public function getIdioma($id)
    {
        try {
            $tuples = Idioma::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'data' => $tuples
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'L\'idioma amb id ' . $id . ' no existeix'
            ], 404);
        }
    }
    // ! PUT D'IDIOMA
    /**
     * @OA\Put(
     *     path="/idiomes/put/{id}",
     *     summary="Actualitza un idioma",
     *     tags={"Idiomes"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *     description="ID del idioma",
     *     in="path",
     *     name="id",
     *     required=true,
     *     @OA\Schema(
     *     type="integer"
     *  )
     * ),
     *     @OA\RequestBody(
     *     description="Dades de l'idioma",
     *     required=true,
     *     @OA\JsonContent(ref="#/components/schemas/Idiomes")
     * ),
     *     @OA\Response(
     *     response=200,
     *     description="Idioma actualitzat",
     *     @OA\JsonContent(ref="#/components/schemas/Idiomes")
     * ),
     *     @OA\Response(
     *     response=400,
     *     description="Error de validació",
     *     @OA\JsonContent(ref="#/components/schemas/Error")
     * ),
     *     @OA\Response(
     *     response=404,
     *     description="No s'ha trobat cap idioma amb aquest ID",
     *     @OA\JsonContent(ref="#/components/schemas/Error")
     * )
     * )
     *
     */
    public function updateIdioma(Request $request, $id)
    {
        if ($request->esAdministrador) {
            $reglesvalidacio = [
                'NOM_IDIOMA' => 'required|string|max:50',
            ];
            $missatges = [
                'NOM_IDIOMA.required' => 'El camp NOM_IDIOMA és obligatori',
                'NOM_IDIOMA.string' => 'El camp NOM_IDIOMA ha de ser una cadena de caràcters',
                'NOM_IDIOMA.max' => 'El camp NOM_IDIOMA no pot tenir més de 50 caràcters.'
            ];
            $validador = Validator::make($request->all(), $reglesvalidacio, $missatges);
            if ($validador->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validador->errors()->all()
                ], 400);
            } else {
                try {
                    $idioma = Idioma::findOrFail($id);
                    $nouidioma = $request->NOM_IDIOMA;
                    if ($idioma->NOM_IDIOMA != $nouidioma) {
                        $idiomaExist = Idioma::where('NOM_IDIOMA', $nouidioma)->first();
                        if ($idiomaExist != null) {
                            return response()->json([
                                'status' => 'error',
                                'message' => 'Aquest idioma ja existeix'
                            ], 400);
                        }
                        $idioma->NOM_IDIOMA = $nouidioma;
                    }
                    $idioma->save();
                    return response()->json([
                        'status' => 'success',
                        'data' => $idioma
                    ], 200);
                } catch (ModelNotFoundException $e) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'L\'idioma amb id ' . $id . ' no existeix'
                    ], 404);
                }
            }
        }else {
            return response()->json(['status' => 'error', 'message' => 'Permisos insuficients']);
        }
    }
    // ! DELETE D'UN IDIOMA
    /**
     * @OA\Delete(
     *     path="/idiomes/destroy/{id}",
     *     tags={"Idiomes"},
     *     security={{"bearerAuth":{}}},
     *     summary="Esborra un Idioma",
     *     description="Esborra un idioma, Sols per administradors",
     *     operationId="eliminarIdioma",
     *     @OA\Parameter(name="id", in="path",description="ID de l'idioma",required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="success"),
     *         @OA\Property(property="data",type="object")
     *       ),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Idioma no eliminat",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Idioma no trobat",
     *     ),
     * )
     */
    public function deleteIdioma(Request $request, $id)
    {
        try {
            if($request->esAdministrador){
                $tuples = Idioma::findOrFail($id);
                $tuples->delete();
                return response()->json(['status' => 'success', 'message' => 'S\'ha eliminat l\'idioma correctament'], 200);
            }else{
                return response()->json(['status' => 'error', 'message' => 'Permisos insuficients']);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'No s\'ha trobat cap idioma amb aquest ID'], 404);
        }
    }
}
