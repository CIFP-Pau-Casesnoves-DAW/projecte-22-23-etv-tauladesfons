<?php

namespace App\Http\Controllers;

use App\Models\Valoracio;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;

/** @OA\Tag(name="Valoracions") */
class ValoracioController extends Controller
{
    /** @OA\Get(
     *     path="/valoracions",
     *     tags={"Valoracions"},
     *     summary="Obtenir totes les valoracions",
     *     description="Retorna totes les valoracions",
     *     operationId="indexValoracions",
     *     @OA\Response(
     *         response=200,
     *         description="Valoracions response",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Valoracio")
     *         ),
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="unexpected error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="An error occurred")
     *         )
     *     )
     * )
     * @OA\Schema(
     *     schema="Valoracio",
     *     type="object",
     *     title="Valoracio model",
     *     @OA\Property(property="PUNTUACIO", type="integer", format="int64", description="Puntuacio de la valoracio"),
     *     @OA\Property(property="FK_ID_USUARI", type="integer", format="int64", description="ID de l'usuari que ha valorat"),
     *     @OA\Property(property="FK_ID_ALLOTJAMENT", type="integer", format="int64", description="ID de l'allotjament que ha estat valorat")
     * )
     */
    // ! GET DE TOTS
    public function getAllValoracions()
    {
        $tuples = Valoracio::all();
        return response()->json([
            'status' => 'success',
            'result' => $tuples
        ], 200);
    }
    /**
     * @OA\Post(
     *     path="/valoracions",
     *     tags={"Valoracions"},
     *     security={{"bearerAuth":{}}},
     *     summary="Inserir una nova valoracio",
     *     description="Inserir una nova valoracio",
     *     operationId="insertValoracio",
     *     @OA\RequestBody(
     *         description="Objecte valoracio",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Valoracio"),
     *             @OA\Schema(ref="#/components/schemas/Valoracio")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Valoracio response",
     *         @OA\JsonContent(ref="#/components/schemas/Valoracio"),
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="unexpected error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="An error occurred")
     *         )
     *     )
     * )
     */
    public function insertValoracio(Request $request)
    {
        $reglesvalidacio  = [
            'PUNTUACIO' => 'required|integer',
            'FK_ID_USUARI' => 'required|integer',
            'FK_ID_ALLOTJAMENT' => 'required|integer'
        ];
        $missatges = [
            'PUNTUACIO.required' => 'El camp PUNTUACIO és obligatori.',
            'PUNTUACIO. integer' => 'El camp PUNTUACIO ha de ser un número enter.',
            'FK_ID_USUARI.required' => 'El camp FK_ID_USUARI és obligatori.',
            'FK_ID_USUARI.integer' => 'El camp FK_ID_USUARI ha de ser un número enter.',
            'FK_ID_ALLOTJAMENT.required' => 'El camp FK_ID_ALLOTJAMENT és obligatori.',
            'FK_ID_ALLOTJAMENT.integer' => 'El camp FK_ID_ALLOTJAMENT ha de ser un número enter.'
        ];
        $validacio = Validator::make($request->all(), $reglesvalidacio, $missatges);
        if ($validacio->fails()) {
            return response()->json([
                'stauts' => 'error',
                $validacio->errors()
            ], 400);
        } else {
            $valoracio = Valoracio::firstOrCreate(['PUNTUACIO' => $request->PUNTUACIO,
                                                'FK_ID_USUARI' => $request->FK_ID_USUARI,
                                                'FK_ID_ALLOTJAMENT' => $request->FK_ID_ALLOTJAMENT]);
            if ($valoracio->wasRecentlyCreated) {
                return response()->json([
                    'status' => 'success',
                    'data' => $valoracio
                ], 201);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'La valoració ja existeix'
                ], 409);
            }
        }
    }

    /**
     * @OA\Get(
     *     path="/valoracions/{id}",
     *     tags={"Valoracions"},
     *     summary="Mostrar una valoracio",
     *     description="Mostrar una valoracio",
     *     operationId="getValoracio",
     *     @OA\Parameter(
     *         description="ID de la valoracio",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Valoracio obtinguda",
     *         @OA\JsonContent(ref="#/components/schemas/Valoracio"),
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="unexpected error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="An error occurred")
     *         )
     *     )
     * )
     */
    // ! GET de un especific
    public function getValoracio($id)
    {
        try {
            $valoracions = Valoracio::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'data' => $valoracions
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'La valoració amb id ' . $id . ' no existeix'
            ], 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/valoracions/put/{id}",
     *     tags={"Valoracions"},
     *     security={{"bearerAuth":{}}},
     *     summary="Actualitzar una valoracio",
     *     description="Actualitzar una valoracio",
     *     operationId="updateValoracio",
     *     @OA\Parameter(
     *         description="ID de la valoracio",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Valoracio"),
     *             @OA\Schema(ref="#/components/schemas/Valoracio")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Valoracio actualitzada",
     *         @OA\JsonContent(ref="#/components/schemas/Valoracio"),
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="unexpected error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="An error occurred")
     *         )
     *     )
     * )
     */
    public function updateValoracio(Request $request, $id)
    {
        $reglesvalidacio  = [
            'PUNTUACIO' => 'required|integer',
            'FK_ID_USUARI' => 'required|integer',
            'FK_ID_ALLOTJAMENT' => 'required|integer'
        ];
        $missatges = [
            'PUNTUACIO.required' => 'El camp PUNTUACIO és obligatori.',
            'PUNTUACIO. integer' => 'El camp PUNTUACIO ha de ser un número enter.',
            'FK_ID_USUARI.required' => 'El camp FK_ID_USUARI és obligatori.',
            'FK_ID_USUARI.integer' => 'El camp FK_ID_USUARI ha de ser un número enter.',
            'FK_ID_ALLOTJAMENT.required' => 'El camp FK_ID_ALLOTJAMENT és obligatori.',
            'FK_ID_ALLOTJAMENT.integer' => 'El camp FK_ID_ALLOTJAMENT ha de ser un número enter.'
        ];
        $validacio = Validator::make($request->all(), $reglesvalidacio, $missatges);
        if ($validacio->fails()) {
            return response()->json([
                'stauts' => 'error',
                $validacio->errors()
            ], 400);
        } else {
            try {
                $valoracio = Valoracio::findOrFail($id);
                if($request->esAdministrador || $request->validar_id == $valoracio->FK_ID_USUARI){
                    $valoracio->PUNTUACIO = $request->PUNTUACIO;
                    $valoracio->FK_ID_USUARI = $request->FK_ID_USUARI;
                    $valoracio->FK_ID_ALLOTJAMENT = $request->FK_ID_ALLOTJAMENT;
                    $valoracio->save();
                    return response()->json([
                        'status' => 'success',
                        'data' => $valoracio
                    ], 200);

    } else {
        return response()->json([
            'status' => 'error',
            'message' => 'No tens permisos per actualitzar aquesta valoració'
        ], 403);
    }
} catch (ModelNotFoundException $e) {
    return response()->json([
        'status' => 'error',
        'message' => 'La valoració amb id ' . $id . ' no existeix'], 404);
            }
        }
    }

    /**
     * @OA\Delete(
     *     path="/valoracions/destroy/{id}",
     *     tags={"Valoracions"},
     *     security={{"bearerAuth":{}}},
     *     summary="Eliminar una valoracio",
     *     description="Eliminar una valoracio",
     *     operationId="deleteValoracio",
     *     @OA\Parameter(
     *         description="ID de la valoracio",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Valoracio eliminada",
     *         @OA\JsonContent(ref="#/components/schemas/Valoracio"),
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="unexpected error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="An error occurred")
     *         )
     *     )
     * )
     */
    public function deleteValoracio($id, Request $request)
    {
       try {
                $valoracio = Valoracio::findOrFail($id);
                if($request->esAdministrador || $request->validar_id == $valoracio->FK_ID_USUARI){
                    $valoracio->delete();
                    return response()->json([
                        'status' => 'success',
                        'message' => 'La valoració amb id ' . $id . ' s\'ha eliminat correctament'
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'No tens permisos per eliminar aquesta valoració'
                    ], 403);
                }
            } catch (ModelNotFoundException $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'La valoració amb id ' . $id . ' no existeix'
                ], 404);
            }
        }
    }
