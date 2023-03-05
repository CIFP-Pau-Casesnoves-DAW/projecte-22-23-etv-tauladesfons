<?php

namespace App\Http\Controllers;

use App\Models\Municipi;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;

/**
 *
 *
 * @OA\Tag(name="Municipis")
 *
 */
class MunicipiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/municipis",
     *     summary="Llista de municipis",
     *     tags={"Municipis"},
     *     @OA\Response(
     *     response=200,
     *     description="Llista de municipis",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Municipi")
     *   )
     * )
     * )
     * @OA\Schema(
     *     schema="Municipi",
     *     type="object",
     *     @OA\Property(property="ID_MUNICIPI", type="integer"),
     *     @OA\Property(property="NOM_MUNICIPI", type="string")
     * )
     */

    // ! GET DE TOTS
    public function getAllMunicipis()
    {
        $llistaMunicipis = Municipi::all();
        return response()->json([
            'status' => 'success',
            'data' => $llistaMunicipis
        ], 200);
    }



    /**
     * @OA\Post(
     *     path="/municipis",
     *     summary="Crea un municipi",
     *     tags={"Municipis"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *     required=true,
     *     description="Dades del municipi",
     *     @OA\JsonContent(
     *     required={"NOM_MUNICIPI"},
     *     @OA\Property(property="NOM_MUNICIPI", type="string")
     *  )
     * ),
     *     @OA\Response(
     *     response=200,
     *     description="Municipi creat",
     *     @OA\JsonContent(
     *     type="object",
     *     @OA\Property(property="status", type="string"),
     *     @OA\Property(property="data", ref="#/components/schemas/Municipi")
     * )
     * )
     * )
     */
    public function insertMunicipi(Request $request)
    {
        $reglesvalidacio = [
            'NOM_MUNICIPI' => 'required|string|max:50',
        ];
        $missatges = [
            'NOM_MUNICIPI.required' => 'El camp NOM_MUNICIPI és obligatori',
            'NOM_MUNICIPI.string' => 'El camp NOM_MUNICIPI ha de ser una cadena de caràcters',
            'NOM_MUNICIPI.max' => 'El camp NOM_MUNICIPI no pot tenir més de 50 caràcters',
        ];
        $validacio = Validator::make($request->all(), $reglesvalidacio, $missatges);
        if ($validacio->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validacio->errors()
            ], 400);
        } else {
            $municipi = Municipi::firstOrCreate(['NOM_MUNICIPI' => $request->NOM_MUNICIPI]);
            if ($municipi->wasRecentlyCreated) {
                return response()->json([
                    'status' => 'success',
                    'data' => $municipi
                ], 201);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'El municipi ja existeix'
                ], 409);
            }
        }
    }

    /**
     * @OA\Get(
     *     path="/municipis/{id}",
     *     summary="Mostra un municipi",
     *     tags={"Municipis"},
     *     @OA\Parameter(
     *     description="ID del municipi",
     *     in="path",
     *     name="id",
     *     required=true,
     *     @OA\Schema(
     *     type="integer"
     *  )
     * ),
     *     @OA\Response(
     *     response=200,
     *     description="Municipi",
     *     @OA\JsonContent(
     *     type="object",
     *     @OA\Property(property="status", type="string"),
     *     @OA\Property(property="data", ref="#/components/schemas/Municipi")
     * )
     * ),
     *     @OA\Response(
     *     response=404,
     *     description="Municipi no trobat",
     *     @OA\JsonContent(
     *     type="object",
     *     @OA\Property(property="status", type="string"),
     *     @OA\Property(property="data", type="string")
     * )
     * )
     * )
     *
     */
    public function getMunicipi($id)
    {
        try {
            $municipis = Municipi::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'data' => $municipis
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'El municipi amb id ' . $id . ' no existeix'
            ], 404);
        }
    }



    /**
     *  @OA\Put(
     *     path="/municipis/put/{id}",
     *     summary="Actualitza un municipi",
     *     tags={"Municipis"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *     description="ID del municipi",
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
     *     required={"NOM_MUNICIPI"},
     *     @OA\Property(property="NOM_MUNICIPI", type="string")
     * )
     * ),
     *     @OA\Response(
     *     response=200,
     *     description="Municipi actualitzat",
     *     @OA\JsonContent(
     *     type="object",
     *     @OA\Property(property="status", type="string"),
     *     @OA\Property(property="data", ref="#/components/schemas/Municipi")
     * )
     * ),
     *     @OA\Response(
     *     response=400,
     *     description="Error de validació",
     *     @OA\JsonContent(
     *     type="object",
     *     @OA\Property(property="status", type="string"),
     *     @OA\Property(property="errors", ref="#/components/schemas/Municipi")
     * )
     * ),
     *     @OA\Response(
     *     response=404,
     *     description="Municipi no trobat",
     *     @OA\JsonContent(
     *     type="object",
     *     @OA\Property(property="status", type="string"),
     *     @OA\Property(property="data", type="string")
     * )
     * )
     * )
     *
     */
    public function updateMunicipi(Request $request, $id)
    {
        $reglesvalidacio = [
            'NOM_MUNICIPI' => 'required|string|max:50',
        ];
        $missatges = [
            'NOM_MUNICIPI.required' => 'El camp NOM_MUNICIPI és obligatori',
            'NOM_MUNICIPI.string' => 'El camp NOM_MUNICIPI ha de ser una cadena de caràcters',
            'NOM_MUNICIPI.max' => 'El camp NOM_MUNICIPI no pot tenir més de 50 caràcters',
        ];
        $validacio = Validator::make($request->all(), $reglesvalidacio, $missatges);
        if ($validacio->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validacio->errors()
            ], 400);
        } else {
            try {
                $municipi = Municipi::findOrFail($id);
                $nouNomMunicipi = $request->NOM_MUNICIPI;
                if ($municipi->NOM_MUNICIPI !== $nouNomMunicipi) {
                    $municipiExist = Municipi::where('NOM_MUNICIPI', $nouNomMunicipi)->first();
                    if ($municipiExist !== null) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'el nom del Municipi ja existeix'
                        ], 409);
                    }
                    $municipi->NOM_MUNICIPI = $nouNomMunicipi;
                }
                $municipi->save();
                return response()->json([
                    'status' => 'success',
                    'data' => $municipi
                ], 200);
            } catch (ModelNotFoundException $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No s\'ha trobat cap municipi amb la ID proporcionada',
                ], 404);
            }
        }
    }

    /**
     * @OA\Delete(
     *     path="/municipis/destroy/{id}",
     *     summary="Elimina un municipi",
     *     tags={"Municipis"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *     description="ID del municipi",
     *     in="path",
     *     name="id",
     *     required=true,
     *     @OA\Schema(
     *     type="integer"
     * )
     * ),
     *     @OA\Response(
     *     response=200,
     *     description="Municipi eliminat",
     *     @OA\JsonContent(
     *     type="object",
     *     @OA\Property(property="status", type="string"),
     *     @OA\Property(property="message", type="string")
     * )
     * ),
     *     @OA\Response(
     *     response=404,
     *     description="Municipi no trobat",
     *     @OA\JsonContent(
     *     type="object",
     *     @OA\Property(property="status", type="string"),
     *     @OA\Property(property="message", type="string")
     * )
     * )
     * )
     */
    public function deleteMunicipi($id)
    {
        try {
            $tuples = Municipi::findOrFail($id);
            $tuples->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Municipi eliminat correctament'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'No s\'ha trobat cap municipi amb la ID proporcionada',
            ], 404);
        }

    }
}
