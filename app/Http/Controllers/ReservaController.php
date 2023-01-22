<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;
/**
 * @OA\Info(title="API Reserva", version="0.1")
 * @OA\Server(url="http://localhost:8000/api")
 * @OA\Tag(name="Reserva")
 *
 */
class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     * @OA\Get(
     *     path="/reserves",
     *     tags={"Reserva"},
     *     summary="Get all reserves",
     *     description="Returns all reserves",
     *     operationId="index",
     * @OA\Response(
     *     response=200,
     *     description="Successful operation",
     *    )
     * )
     */
    public function index()
    {
        $tuples=Reserva::all();
        return response()->json(['status'=>'success', 'result' => $tuples],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     *
     * @OA\Post(
     *     path="/reserves",
     *     tags={"Reserva"},
     *     summary="Add a new reserva",
     *     description="Adds a new reserva",
     *     operationId="store",
     *     @OA\RequestBody(
     *     required=true,
     *     description="Pass reserva data",
     *     @OA\JsonContent(
     *     required={"ID_RESERVA","FK_ID_CLIENT","FK_ID_ALLOTJAMENT","DATA_INICIAL","DATA_FINAL","CONFIRMADA"},
     *     @OA\Property(property="ID_RESERVA", type="integer", format="int64", example=1),
     *     @OA\Property(property="FK_ID_CLIENT", type="integer", format="int64", example=1),
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
     *     @OA\Property(property="ID_RESERVA", type="integer", format="int64", example=1),
     *     @OA\Property(property="FK_ID_CLIENT", type="integer", format="int64", example=1),
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
     *     @OA\Property(property="ID_RESERVA", type="string", example="El camp ID_RESERVA és obligatori"),
     *     @OA\Property(property="FK_ID_CLIENT", type="string", example="El camp FK_ID_CLIENT és obligatori"),
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
    public function store(Request $request)
    {
        $reglesvalidacio = [
            'ID_RESERVA' => 'required',
            'FK_ID_CLIENT' => 'required',
            'FK_ID_ALLOTJAMENT' => 'required',
            'DATA_INICIAL' => 'required|date_format:Y-m-d',
            'DATA_FINAL' => 'required|date_format:Y-m-d',
            'CONFIRMADA' => 'required|boolean'
        ];
        $missatges = [
            'ID_RESERVA.required' => 'El camp ID_RESERVA és obligatori',
            'FK_ID_CLIENT.required' => 'El camp FK_ID_CLIENT és obligatori',
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
            $reserves= new Reserva;
            $reserves->ID_RESERVA=$request->ID_RESERVA;
            $reserves->FK_ID_CLIENT=$request->FK_ID_CLIENT;
            $reserves->FK_ID_ALLOTJAMENT=$request->FK_ID_ALLOTJAMENT;
            $reserves->DATA_INICIAL=$request->DATA_INICIAL;
            $reserves->DATA_FINAL=$request->DATA_FINAL;
            $reserves->CONFIRMADA=$request->CONFIRMADA;
            $reserves->save();
            return response()->json(['status'=>'success','result'=>$reserves], 200);
        }

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $tuples=Reserva::findOrFail($id);
            return response()->json(['status'=>'success', 'result' => $tuples],200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status'=>'error', 'result' => 'No existeix aquesta reserva'],404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
