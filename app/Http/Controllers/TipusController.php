<?php

namespace App\Http\Controllers;

use App\Models\Tipus;
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
     *     required={"ID_TIPUS", "NOM_TIPUS"},
     *     @OA\Property(property="ID_TIPUS", type="integer"),
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
            'ID_TIPUS' => 'required|integer',
            'NOM_TIPUS' => 'required|string|max:50',
        ];
        $missatge = [
            'ID_TIPUS.required' => 'El camp ID_TIPUS és obligatori',
            'ID_TIPUS.integer' => 'El camp ID_TIPUS ha de ser un enter',
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
            $tuple = new Tipus();
            $tuple->ID_TIPUS = $request->input('ID_TIPUS');
            $tuple->NOM_TIPUS = $request->input('NOM_TIPUS');
            $tuple->save();
            return response()->json([
                'status' => 'success',
                'data' => $tuple
            ], 201);
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
                'message' => 'Tipus no trobat'
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
     *     required={"ID_TIPUS","NOM_TIPUS"},
     *     @OA\Property(property="ID_TIPUS", type="integer"),
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
            'ID_TIPUS' => 'required|integer',
            'NOM_TIPUS' => 'required|string|max:50'
        ];
        $missatge = [
            'ID_TIPUS.required' => 'El camp ID_TIPUS és obligatori',
            'ID_TIPUS.integer' => 'El camp ID_TIPUS ha de ser un enter',
            'NOM_TIPUS.required' => 'El camp NOM_TIPUS és obligatori',
            'NOM_TIPUS.string' => 'El camp NOM_TIPUS ha de ser una cadena de caràcters',
            'NOM_TIPUS.max' => 'El camp NOM_TIPUS no pot tenir més de 50 caràcters'
        ];
        $validacio = Validator::make($request->all(), $reglesvalidacio, $missatge);
        $tuples = Tipus::where('ID_TIPUS', $id)->update($request->except(['_token']));
        if ($validacio->fails()) {
            return response()->json([
                'error' => $validacio->errors()->all()
            ]);
        } else {
            return response()->json([
                'success' => 'Tipus modificat correctament.'
            ]);
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
        $tuples = Tipus::findOrFail($id);
        $tuples->delete();
        return response()->json([
            'status' => 'deleted',
            'data' => $tuples
        ], 200);
    }
}
