<?php

namespace App\Http\Controllers;

use App\Models\Servei;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;

/** 
 * @OA\Tag (name="Serveis") 
 */
class ServeiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/serveis",
     *     summary="Mostra tots els serveis",
     *     tags={"Serveis"},
     *     @OA\Response(
     *     response=200,
     *     description="Retorna tots els serveis",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Servei")
     *    )
     *  )
     * )
     * @OA\Schema(
     *     schema="Servei",
     *     type="object",
     *     @OA\Property(property="ID_SERVEI", type="integer"),
     *     @OA\Property(property="NOM_SERVEI", type="string")
     * )
     */
    // ! GET DE TOTS
    public function getAllServeis()
    {
        $tuples = Servei::all();
        return response()->json([
            'status' => 'success',
            'data' => $tuples
        ], 200);
    }
    /**
     * @OA\Post(
     *     path="/serveis",
     *     summary="Crea un servei",
     *     tags={"Serveis"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *     required=true,
     *     description="Dades del servei",
     *     @OA\JsonContent(
     *     required={"NOM_SERVEI"},
     *     @OA\Property(property="NOM_SERVEI", type="string")
     *  )
     * ),
     *     @OA\Response(
     *     response=200,
     *     description="Servei creat",
     *     @OA\JsonContent(
     *     type="object",
     *     @OA\Property(property="status", type="string"),
     *     @OA\Property(property="data", ref="#/components/schemas/Servei")
     * )
     * )
     * )
     */
    public function insertServei(Request $request)
    {
        $reglesvalidacio = [
            'NOM_SERVEI' => 'required|string|max:50'
        ];
        $missatges = [
            'NOM_SERVEI.required' => 'El camp NOM_SERVEI és obligatori.',
            'NOM_SERVEI.string' => 'El camp NOM_SERVEI ha de ser una cadena de caràcters.',
            'NOM_SERVEI.max' => 'El camp NOM_SERVEI no pot tenir més de 50 caràcters.'
        ];
        $validacio = Validator::make($request->all(), $reglesvalidacio, $missatges);
        if ($validacio->fails()) {
            return response()->json($validacio->errors(), 400);
        } else {
            $servei = Servei::firstOrCreate(['NOM_SERVEI' => $request->NOM_SERVEI]);
            if ($servei->wasRecentlyCreated) {
                return response()->json([
                    'status' => 'success',
                    'data' => $servei
                ], 201);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'El servei ja existeix'
                ], 409);
            }
        }
    }
    /**
     * @OA\Get(
     *     path="/serveis/{id}",
     *     summary="Mostra un servei",
     *     tags={"Serveis"},
     *     @OA\Parameter(
     *     description="ID del servei",
     *     in="path",
     *     name="id",
     *     required=true,
     *     @OA\Schema(
     *     type="integer"
     *   )
     * ),
     *     @OA\Response(
     *     response=200,
     *     description="Retorna el servei",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Servei")
     *   )
     * ),
     *      @OA\Response(
     *     response=404,
     *     description="Servei no trobat",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Error")
     *  )
     * )
     * )
     */
    public function getServei($id)
    {
        try {
            $serveis = Servei::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'data' => $serveis
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'El servei amb id ' . $id . ' no existeix'
            ], 404);
        }
    }

    /**
     *  @OA\Put(
     *     path="/serveis/put/{id}",
     *     summary="Actualitza un Servei",
     *     tags={"Serveis"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *     description="ID del Servei",
     *     in="path",
     *     name="id",
     *     required=true,
     *     @OA\Schema(
     *     type="integer"
     * )
     * ),
     *     @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *     required={"NOM_SERVEI"},
     *     @OA\Property(property="NOM_SERVEI", type="string")
     * )
     * ),
     *     @OA\Response(
     *     response=200,
     *     description="Servei actualitzat",
     *     @OA\JsonContent(
     *     type="object",
     *     @OA\Property(property="status", type="string"),
     *     @OA\Property(property="data", ref="#/components/schemas/Servei")
     * )
     * ),
     *     @OA\Response(
     *     response=400,
     *     description="Error de validació",
     *     @OA\JsonContent(
     *     type="object",
     *     @OA\Property(property="status", type="string"),
     *     @OA\Property(property="errors", ref="#/components/schemas/Servei")
     * )
     * ),
     *     @OA\Response(
     *     response=404,
     *     description="Servei no trobat",
     *     @OA\JsonContent(
     *     type="object",
     *     @OA\Property(property="status", type="string"),
     *     @OA\Property(property="data", type="string")
     * )
     * )
     * )
     *
     */
    public function updateServei(Request $request, $id)
    {
        $reglesvalidacio = [
            'NOM_SERVEI' => 'required|string|max:50'
        ];
        $missatges = [
            'NOM_SERVEI.required' => 'El camp NOM_SERVEI és obligatori.',
            'NOM_SERVEI.string' => 'El camp NOM_SERVEI ha de ser una cadena de caràcters.',
            'NOM_SERVEI.max' => 'El camp NOM_SERVEI no pot tenir més de 50 caràcters.'
        ];
        $validacio = Validator::make($request->all(), $reglesvalidacio, $missatges);
        if ($validacio->fails()) {
            return response()->json([
                'error' => $validacio->errors()->all()
            ]);
        } else {
            try {
                $servei = Servei::findOrFail($id);
                $nouNomServei = $request->NOM_SERVEI;
                if ($servei->NOM_SERVEI !== $nouNomServei) {
                    $serveiExist = Servei::where('NOM_SERVEI', $nouNomServei)->first();
                    if ($serveiExist !== null) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'el nom del servei ja existeix'
                        ], 409);
                    }
                    $servei->NOM_SERVEI = $nouNomServei;
                }
                $servei->save();
                return response()->json([
                    'status' => 'success',
                    'data' => $servei
                ], 200);
            } catch (ModelNotFoundException $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No s\'ha trobat cap servei amb la ID proporcionada',
                ], 404);
            }
        }
    }

    /**
     * @OA\Delete(
     *     path="/serveis/destroy/{id}",
     *     summary="Elimina un servei",
     *     tags={"Serveis"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *     description="ID del servei",
     *     in="path",
     *     name="id",
     *     required=true,
     *     @OA\Schema(
     *     type="integer"
     * )
     * ),
     *     @OA\Response(
     *     response=200,
     *     description="Servei eliminat",
     *     @OA\JsonContent(
     *     type="object",
     *     @OA\Property(property="status", type="string"),
     *     @OA\Property(property="message", type="string")
     * )
     * ),
     *     @OA\Response(
     *     response=404,
     *     description="Servei no trobat",
     *     @OA\JsonContent(
     *     type="object",
     *     @OA\Property(property="status", type="string"),
     *     @OA\Property(property="message", type="string")
     * )
     * )
     * )
     */
    public function deleteServei($id)
    {
        try {
            $tuples = Servei::findOrFail($id);
            $tuples->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Servei eliminat correctament'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'No s\'ha trobat cap servei amb la ID proporcionada',
            ], 404);
        }
    }
}
