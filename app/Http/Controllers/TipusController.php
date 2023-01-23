<?php

namespace App\Http\Controllers;

use App\Models\Tipus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;

/** @OA\Tag(name="Tipus") */
class TipusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
    public function index()
    {
        $tuples = Tipus::all();
        return response()->json([
            'status' => 'success',
            'data' => $tuples
        ], 200);
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
     * @OA\Post(
     *     path="/tipus",
     *     summary="Crea un nou tipus",
     *     tags={"Tipus"},
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
    public function store(Request $request)
    {
        $reglesvalidacio = [
            'ID_TIPUS' => 'required|integer',
            'NOM_TIPUS' => 'required|string|max:255',
        ];
        $missatge= [
            'ID_TIPUS.required' => 'El camp ID_TIPUS és obligatori',
            'ID_TIPUS.integer' => 'El camp ID_TIPUS ha de ser un enter',
            'NOM_TIPUS.required' => 'El camp NOM_TIPUS és obligatori',
            'NOM_TIPUS.string' => 'El camp NOM_TIPUS ha de ser una cadena de caràcters',
            'NOM_TIPUS.max' => 'El camp NOM_TIPUS no pot tenir més de 255 caràcters',
        ];
        $validacio= Validator::make($request->all(), $reglesvalidacio, $missatge);
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
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
    public function show($id)
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
                'message' => 'Tipus not found'
            ], 404);
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
     * @OA\Put(
     *     path="/tipus/put/{id}",
     *     summary="Actualitza un tipus",
     *     tags={"Tipus"},
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
     *     @OA\JsonContent(ref="#/components/schemas/Tipus")
     * ),
     *     @OA\Response(
     *     response=200,
     *     description="Tipus actualitzat",
     *     @OA\JsonContent(
     *     type="object",
     *     @OA\Property(property="status", type="string"),
     *     @OA\Property(property="data", ref="#/components/schemas/Tipus")
     * )
     * ),
     *     @OA\Response(
     *     response=400,
     *     description="Error de validació",
     *     @OA\JsonContent(
     *     type="object",
     *     @OA\Property(property="status", type="string"),
     *     @OA\Property(property="errors", type="object")
     * )
     * )
     * )
     */
    public function update(Request $request, $id)
    {
        $reglesvalidacio = [
            'ID_TIPUS' => 'required|integer',
            'NOM_TIPUS' => 'required|string|max:255',
        ];
        $missatge= [
            'ID_TIPUS.required' => 'El camp ID_TIPUS és obligatori',
            'ID_TIPUS.integer' => 'El camp ID_TIPUS ha de ser un enter',
            'NOM_TIPUS.required' => 'El camp NOM_TIPUS és obligatori',
            'NOM_TIPUS.string' => 'El camp NOM_TIPUS ha de ser una cadena de caràcters',
            'NOM_TIPUS.max' => 'El camp NOM_TIPUS no pot tenir més de 255 caràcters',
        ];
        $validacio= Validator::make($request->all(), $reglesvalidacio, $missatge);
        if ($validacio->fails()) {
            $tuples=Tipus::findOrFail($id);
            $tuples->update($request->all());
            return response()->json([
                'status' => 'success',
                'data' => $tuples
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'data' => $validacio->errors()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Delete(
     *     path="/tipus/destroy/{id}",
     *     summary="Elimina un tipus",
     *     tags={"Tipus"},
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
    public function destroy($id)
    {
        $tuples=Tipus::findOrFail($id);
        $tuples->delete();
        return response()->json([
            'status' => 'deleted',
            'data' => $tuples
        ], 200);
    }
}
