<?php

namespace App\Http\Controllers;

use App\Models\Tipus;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;

/** @OA\Tag(name="Tipus") */
class TipusController extends Controller
{
// ! GET DE TOTS
    /**
     * @OA\Get(
     *     path="/tipus",
     *     summary="Llista de tipus",
     *     tags={"Tipus"},
     *     @OA\Response(
     *     response=200,
     *     description="Llista de tipus",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Tipus")
     *   )
     * )
     * )
     * @OA\Schema(
     *     schema="Tipus",
     *     type="object",
     *     @OA\Property(property="ID_TIPUS", type="integer"),
     *     @OA\Property(property="NOM_TIPUS", type="string")
     * )
     */
    public function getAllTipus()
    {
        $tuples = Tipus::all();
        return response()->json([
            'status' => 'success',
            'data' => $tuples
        ], 200);
    }
// ! POST D'UN TIPUS
    /**
     * @OA\Post(
     *     path="/tipus",
     *     summary="Crea un nou tipus",
     *     tags={"Tipus"},
     *     security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *     required=true,
     *     description="Dades del nou tipus",
     *     @OA\JsonContent(
     *     required={"NOM_TIPUS"},
     *     @OA\Property(property="NOM_TIPUS", type="string")
     *  )
     * ),
     *     @OA\Response(
     *     response=200,
     *     description="Tipus creat",
     *     @OA\JsonContent(
     *     type="object",
     *     @OA\Property(property="status", type="string"),
     *     @OA\Property(property="data", ref="#/components/schemas/Tipus")
     *  )
     * ),
     *     @OA\Response(
     *     response=400,
     *     description="Error de validació",
     *     @OA\JsonContent(
     *     type="object",
     *     @OA\Property(property="status", type="string"),
     *     @OA\Property(property="message", type="string")
     * )
     * )
     * )
     */
    public function insertTipus(Request $request)
    {
        $reglesvalidacio = [
            'NOM_TIPUS' => 'required|string|max:50'
        ];
        $missatge = [
            'NOM_TIPUS.required' => 'El camp NOM_TIPUS és obligatori',
            'NOM_TIPUS.string' => 'El camp NOM_TIPUS ha de ser una cadena de caràcters',
            'NOM_TIPUS.max' => 'El camp NOM_TIPUS no pot tenir més de 50 caràcters',
        ];
        $validacio = Validator::make($request->all(), $reglesvalidacio, $missatge);
        if ($validacio->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validacio->errors()
            ], 400);
        } else {
            $tipus = Tipus::firstOrCreate(['NOM_TIPUS' => $request->NOM_TIPUS]);
            if ($tipus->wasRecentlyCreated) {
                return response()->json([
                    'status' => 'success',
                    'data' => $tipus
                ], 201);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'El tipus ja existeix'
                ], 409);
            }
        }
    }
// ! GET D'UN TIPUS
    /**
     * @OA\Get(
     *     path="/tipus/{id}",
     *     summary="Mostra un tipus",
     *     tags={"Tipus"},
     *     @OA\Parameter(
     *     description="ID del tipus",
     *     in="path",
     *     name="id",
     *     required=true,
     *     @OA\Schema(
     *     type="integer"
     *  )
     * ),
     *     @OA\Response(
     *     response=200,
     *     description="Tipus",
     *     @OA\JsonContent(
     *     type="object",
     *     @OA\Property(property="status", type="string"),
     *     @OA\Property(property="data", ref="#/components/schemas/Tipus")
     * )
     * ),
     *     @OA\Response(
     *     response=404,
     *     description="Tipus no trobat",
     *     @OA\JsonContent(
     *     type="object",
     *     @OA\Property(property="status", type="string"),
     *     @OA\Property(property="message", type="string")
     * )
     * )
     * )
     */
    public function getTipus($id)
    {
        try {
            $tipus = Tipus::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'data' => $tipus
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'El tipus amb id ' . $id . ' no existeix'
            ], 404);
        }
    }
// ! PUT DE TIPUS
    /**
     * @OA\Put(
     *     path="/tipus/put/{id}",
     *     summary="Actualitza un tipus",
     *     tags={"Tipus"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *     description="ID del tipus",
     *     in="path",
     *     name="id",
     *     required=true,
     *     @OA\Schema(
     *     type="integer"
     * )
     * ),
     *     @OA\RequestBody(
     *     description="Dades del tipus",
     *     required=true,
     *     @OA\JsonContent(
     *     required={"NOM_TIPUS"},
     *     @OA\Property(property="NOM_TIPUS", type="string")
     *   )
     * ),
     *     @OA\Response(
     *     response=200,
     *     description="Tipus actualitzat",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Tipus")
     *   )
     * ),
     *     @OA\Response(
     *     response=400,
     *     description="Error de validació",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Error")
     * )
     * )
     * )
     */
    public function updateTipus(Request $request, $id)
    {
        $reglesvalidacio = [
            'NOM_TIPUS' => 'required|string|max:50'
        ];
        $missatge = [
            'NOM_TIPUS.required' => 'El camp NOM_TIPUS és obligatori',
            'NOM_TIPUS.string' => 'El camp NOM_TIPUS ha de ser una cadena de caràcters',
            'NOM_TIPUS.max' => 'El camp NOM_TIPUS no pot tenir més de 50 caràcters'
        ];
        $validacio = Validator::make($request->all(), $reglesvalidacio, $missatge);
        if ($validacio->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validacio->errors()
            ], 400);
        } else {
            try {
                $tipus = Tipus::findOrFail($id);
                $nouNomTipus = $request->NOM_TIPUS;
                if ($tipus->NOM_TIPUS !== $nouNomTipus) {
                    $tipusExist = Tipus::where('NOM_TIPUS', $nouNomTipus)->first();
                    if ($tipusExist !== null) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Aquest tipus ja existeix'
                        ], 409);
                    }
                    $tipus->NOM_TIPUS = $nouNomTipus;
                }
                $tipus->save();
                return response()->json([
                    'status' => 'success',
                    'data' => $tipus
                ], 200);
            } catch (ModelNotFoundException $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No s\'ha trobat cap tipus amb la ID proporcionada',
                ], 404);
            }
        }
    }
// ! DELETE DE TIPUS
    /**
     * @OA\Delete(
     *     path="/tipus/destroy/{id}",
     *     summary="Elimina un tipus",
     *     tags={"Tipus"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *     description="ID del tipus",
     *     in="path",
     *     name="id",
     *     required=true,
     *     @OA\Schema(
     *     type="integer"
     * )
     * ),
     *     @OA\Response(
     *     response=200,
     *     description="Tipus eliminat",
     *     @OA\JsonContent(
     *     type="object",
     *     @OA\Property(property="status", type="string"),
     *     @OA\Property(property="data", ref="#/components/schemas/Tipus")
     * )
     * ),
     *     @OA\Response(
     *     response=404,
     *     description="Tipus no trobat",
     *     @OA\JsonContent(
     *     type="object",
     *     @OA\Property(property="status", type="string"),
     *     @OA\Property(property="message", type="string")
     * )
     * )
     * )
     *
     */
    public function deleteTipus($id)
    {
        try {
            $tuples = Tipus::findOrFail($id);
            $tuples->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Tipus eliminat correctament'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'No s\'ha trobat cap tipus amb la ID proporcionada',
            ], 404);
        }
    }
}
