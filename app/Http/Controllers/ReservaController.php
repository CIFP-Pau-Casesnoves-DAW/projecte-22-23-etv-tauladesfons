<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;
/**
 * @OA\Tag(name="Reserves")
 */
class ReservaController extends Controller
{
    /**
     * @OA\Get(
     *     path="/reserves",
     *     summary="Llista de reserves",
     *     tags={"Reserves"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *     response=200,
     *     description="Llista de reserves",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Reserva")
     *    )
     *  )
     * )
     * @OA\Schema(
     *     schema="Reserva",
     *     type="object",
     *     @OA\Property(property="FK_ID_USUARI", type="integer"),
     *     @OA\Property(property="FK_ID_ALLOTJAMENT", type="integer"),
     *     @OA\Property(property="DATA_INICIAL", type="string"),
     *     @OA\Property(property="DATA_FINAL", type="string"),
     *     @OA\Property(property="CONFIRMADA", type="boolean")
     * )
     */
    // ! GET DE TOTS
    public function getAllReserves()
    {
        $tuples=Reserva::all();
        return response()->json([
            'status'=>'success',
            'result' => $tuples
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/reserves",
     *     tags={"Reserves"},
     *     security={{"bearerAuth":{}}},
     *     summary="Añaade una nueva reserva",
     *     description="Añade una nueva reserva",
     *     operationId="insertReserva",
     *     @OA\RequestBody(
     *     required=true,
     *     description="Pass reserva data",
     *     @OA\JsonContent(
     *     required={"FK_ID_USUARI","FK_ID_ALLOTJAMENT","DATA_INICIAL","DATA_FINAL","CONFIRMADA"},
     *     @OA\Property(property="FK_ID_USUARI", type="integer", format="int64", example=1),
     *     @OA\Property(property="FK_ID_ALLOTJAMENT", type="integer", format="int64", example=1),
     *     @OA\Property(property="DATA_INICIAL", type="string", format="date", example="2021-01-01"),
     *     @OA\Property(property="DATA_FINAL", type="string", format="date", example="2021-01-01"),
     *     @OA\Property(property="CONFIRMADA", type="boolean", example=true),
     *     ),
     *     ),
     *     @OA\Response(
     *     response=200,
     *     description="Successful operation",
     *     @OA\JsonContent(
     *     @OA\Property(property="status", type="string", example="success"),
     *     @OA\Property(property="result", type="object",
     *     @OA\Property(property="FK_ID_USUARI", type="integer", format="int64", example=1),
     *     @OA\Property(property="FK_ID_ALLOTJAMENT", type="integer", format="int64", example=1),
     *     @OA\Property(property="DATA_INICIAL", type="string", format="date", example="2021-01-01"),
     *     @OA\Property(property="DATA_FINAL", type="string", format="date", example="2021-01-01"),
     *     @OA\Property(property="CONFIRMADA", type="boolean", example=true),
     *     ),
     *     ),
     *     ),
     *     @OA\Response(
     *     response=400,
     *     description="Bad request",
     *     @OA\JsonContent(
     *     @OA\Property(property="status", type="string", example="error"),
     *     @OA\Property(property="result", type="object",
     *     @OA\Property(property="FK_ID_USUARI", type="string", example="El camp FK_ID_USUARI és obligatori"),
     *     @OA\Property(property="FK_ID_ALLOTJAMENT", type="string", example="El camp FK_ID_ALLOTJAMENT és obligatori"),
     *     @OA\Property(property="DATA_INICIAL", type="string", example="El camp DATA_INICIAL és obligatori"),
        *     @OA\Property(property="DATA_FINAL", type="string", example="El camp DATA_FINAL és obligatori"),
     *     @OA\Property(property="CONFIRMADA", type="string", example="El camp CONFIRMADA és obligatori"),
     *     ),
     *     ),
     *     ),
     *     @OA\Response(
     *     response=500,
     *     description="Internal server error",
     *     @OA\JsonContent(
     *     @OA\Property(property="status", type="string", example="error"),
     *     @OA\Property(property="result", type="string", example="Internal server error"),
     *     ),
     *     ),
     *     )
     */
    public function insertReserva(Request $request)
    {
        $reglesvalidacio = [
            'FK_ID_USUARI' => 'required',
            'FK_ID_ALLOTJAMENT' => 'required',
            'DATA_INICIAL' => 'required|date_format:Y-m-d',
            'DATA_FINAL' => 'required|date_format:Y-m-d',
            'CONFIRMADA' => 'required|boolean'
        ];
        $missatges = [
            'FK_ID_USUARI.required' => 'El camp FK_ID_USUARI és obligatori',
            'FK_ID_ALLOTJAMENT.required' => 'El camp FK_ID_ALLOTJAMENT és obligatori',
            'DATA_INICIAL.required' => 'El camp DATA_INICIAL és obligatori',
            'DATA_INICIAL.date_format' => 'El camp DATA_INICIAL ha de tenir el format Y-m-d',
            'DATA_FINAL.required' => 'El camp DATA_FINAL és obligatori',
            'DATA_FINAL.date_format' => 'El camp DATA_FINAL ha de tenir el format Y-m-d',
            'CONFIRMADA.required' => 'El camp CONFIRMADA és obligatori',
            'CONFIRMADA.boolean' => 'El camp CONFIRMADA ha de ser un booleà'
        ];
        $validator = Validator::make($request->all(), $reglesvalidacio, $missatges);
        if ($validator->fails()) {
            return response()->json(['status'=>'error','errors'=>$validator->errors()], 400);
        }else {
            $reserva=Reserva::firstOrCreate([
                'FK_ID_USUARI' => $request->FK_ID_USUARI,
                'FK_ID_ALLOTJAMENT' => $request->FK_ID_ALLOTJAMENT,
                'DATA_INICIAL' => $request->DATA_INICIAL,
                'DATA_FINAL' => $request->DATA_FINAL,
                'CONFIRMADA' => $request->CONFIRMADA
            ]);
            if ($reserva->wasRecentlyCreated) {
                return response()->json(['status' => 'success', 'data' => $reserva], 200);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Reserva ja existent'], 400);

            }
        }

    }

    /**
     * @OA\Get(
     *     path="/reserves/{id}",
     *     tags={"Reserves"},
     *     security={{"bearerAuth":{}}},
     *     summary="Mostra una reserva",
     *     description="Mostra una reserva",
     *     operationId="getReserva",
     *     @OA\Parameter(
     *     description="ID de la reserva",
     *     in="path",
     *     name="id",
     *     required=true,
     *     @OA\Schema(
     *     type="integer",
     *     format="int64",
     *     ),
     *     ),
     *     @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *     @OA\Property(property="status", type="string", example="success"),
     *     @OA\Property(property="result", type="object",
     *     @OA\Property(property="FK_ID_USUARI", type="integer", example="1"),
     *     @OA\Property(property="FK_ID_ALLOTJAMENT", type="integer", example="1"),
     *     @OA\Property(property="DATA_INICIAL", type="string", example="2020-01-01"),
     *     @OA\Property(property="DATA_FINAL", type="string", example="2020-01-01"),
     *     @OA\Property(property="CONFIRMADA", type="boolean", example="true"),
     *     ),
     *     ),
     *     ),
     *     @OA\Response(
     *     response=404,
     *     description="Not found",
     *     @OA\JsonContent(
     *     @OA\Property(property="status", type="string", example="error"),
     *     @OA\Property(property="result", type="string", example="No existeix aquesta reserva"),
     *     ),
     *     )
     *    )
     */
    public function getReserva($id)
    {
        try {
            $tuples=Reserva::findOrFail($id);
            return response()->json([
                'status'=>'success',
                'data' => $tuples
            ],200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status'=>'error',
                'message' => 'La reserva amb id ' . $id . ' no existeix'
            ], 404);
        }
    }

    /**
     * @OA\Put(
     *    path="/reserves/put/{id}",
     *     tags={"Reserves"},
     *     security={{"bearerAuth":{}}},
     *     summary="Actualitza una reserva",
     *     description="Actualitza una reserva",
     *     operationId="update",
     *     @OA\Parameter(
     *     description="ID de la reserva",
     *     in="path",
     *     name="id",
     *     required=true,
     *     @OA\Schema(
     *     type="integer",
     *     format="int64",
     *     ),
     *     ),
     *     @OA\RequestBody(
     *     required=true,
     *     description="Dades de la reserva",
     *     @OA\JsonContent(
     *     required={"FK_ID_USUARI","FK_ID_ALLOTJAMENT","DATA_INICIAL","DATA_FINAL","CONFIRMADA"},
     *     @OA\Property(property="FK_ID_USUARI", type="integer", example="1"),
     *     @OA\Property(property="FK_ID_ALLOTJAMENT", type="integer", example="1"),
     *     @OA\Property(property="DATA_INICIAL", type="string", example="2020-01-01"),
     *     @OA\Property(property="DATA_FINAL", type="string", example="2020-01-01"),
     *     @OA\Property(property="CONFIRMADA", type="boolean", example="1"),
     *     ),
     *     ),
     *     @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *     @OA\Property(property="status", type="string", example="success"),
     *     @OA\Property(property="result", type="object",
     *     @OA\Property(property="FK_ID_USUARI", type="integer", example="1"),
     *     @OA\Property(property="FK_ID_ALLOTJAMENT", type="integer", example="1"),
     *     @OA\Property(property="DATA_INICIAL", type="string", example="2020-01-01"),
     *     @OA\Property(property="DATA_FINAL", type="string", example="2020-01-01"),
     *     @OA\Property(property="CONFIRMADA", type="boolean", example="true"),
     *     ),
     *     ),
     *     ),
     *     @OA\Response(
     *     response=404,
     *     description="Not found",
     *     @OA\JsonContent(
     *     @OA\Property(property="status", type="string", example="error"),
     *     @OA\Property(property="result", type="string", example="No existeix aquesta reserva"),
     *     ),
     *     ),
     *     )
     */
    public function updateReserva(Request $request, $id)
    {
        $reglesvalidacio = [
            'FK_ID_USUARI' => 'required',
            'FK_ID_ALLOTJAMENT' => 'required',
            'DATA_INICIAL' => 'required|date_format:Y-m-d',
            'DATA_FINAL' => 'required|date_format:Y-m-d',
            'CONFIRMADA' => 'required|boolean'
        ];
        $missatges = [
            'FK_ID_USUARI.required' => 'El camp FK_ID_USUARI és obligatori',
            'FK_ID_ALLOTJAMENT.required' => 'El camp FK_ID_ALLOTJAMENT és obligatori',
            'DATA_INICIAL.required' => 'El camp DATA_INICIAL és obligatori',
            'DATA_INICIAL.date_format' => 'El camp DATA_INICIAL ha de tenir el format Y-m-d',
            'DATA_FINAL.required' => 'El camp DATA_FINAL és obligatori',
            'DATA_FINAL.date_format' => 'El camp DATA_FINAL ha de tenir el format Y-m-d',
            'CONFIRMADA.required' => 'El camp CONFIRMADA és obligatori',
            'CONFIRMADA.boolean' => 'El camp CONFIRMADA ha de ser un booleà'
        ];
        $validator = Validator::make($request->all(), $reglesvalidacio, $missatges);
        if ($validator->fails()) {
            return response()->json(['status'=>'error','result'=>$validator->errors()], 400);
        }else {
            $reserves= Reserva::findOrFail($id);
            $reserves->ID_RESERVA=$request->input('ID_RESERVA');
            $reserves->FK_ID_USUARI=$request->input('FK_ID_USUARI');
            $reserves->FK_ID_ALLOTJAMENT=$request->input('FK_ID_ALLOTJAMENT');
            $reserves->DATA_INICIAL=$request->input('DATA_INICIAL');
            $reserves->DATA_FINAL=$request->input('DATA_FINAL');
            $reserves->CONFIRMADA=$request->input('CONFIRMADA');
            $reserves->save();
            return response()->json(['status'=>'success','result'=>$reserves], 200);
        }
    }

    /**
     * @OA\Delete(
     *    path="/reserves/destroy/{id}",
     *     tags={"Reserves"},
     *     security={{"bearerAuth":{}}},
     *     summary="Elimina una reserva",
     *     description="Elimina una reserva",
     *     operationId="destroy",
     *     @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="ID de la reserva",
     *     required=true,
     *     @OA\Schema(
     *     type="integer"
     *    ),
     *     ),
     *     @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *     @OA\Property(property="status", type="string", example="success"),
     *     @OA\Property(property="result", type="string", example="Reserva eliminada correctament"),
     *     ),
     *     ),
     *     @OA\Response(
     *     response=404,
     *     description="Not found",
     *     @OA\JsonContent(
     *     @OA\Property(property="status", type="string", example="error"),
     *     @OA\Property(property="result", type="string", example="No existeix aquesta reserva"),
     *     )
     *    )
     * )
     */
    public function deleteReserva($id)
    {
        try {
            $tuples=Reserva::findOrFail($id);
            $tuples->delete();
            return response()->json(['status'=>'success', 'result' => 'Reserva eliminada correctament'],200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status'=>'error', 'result' => 'No existeix aquesta reserva'],404);
        }
    }
}
