<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use OpenApi\Annotations as OA;

/**
 *
 *
 * @OA\Tag(name="Categories")
 *
 *
 */
class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     * @OA\Get(
     *     path="/categories",
     *     summary="Llista de categories",
     *     tags={"Categories"},
     *     @OA\Response(
     *     response=200,
     *     description="Llista de categories",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Categoria")
     *    )
     *  )
     * )
     * @OA\Schema(
     *     schema="Categoria",
     *     type="object",
     *     @OA\Property(property="ID_CATEGORIA", type="integer"),
     *     @OA\Property(property="NOM_CATEGORIA", type="string"),
     *     @OA\Property(property="TARIFA", type="number")
     * )
     *
     */
    public function index()
    {
        $tuples = Categoria::all();
        return response()->json($tuples);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Response
     * @throws ValidationException
     * @OA\Post(
     *     path="/categories",
     *     summary="Crea una categoria",
     *     tags={"Categories"},
     *     @OA\RequestBody(
     *     description="Dades de la categoria",
     *     required=true,
     *     @OA\JsonContent(ref="#/components/schemas/Categoria")
     * ),
     *     @OA\Response(
     *     response=200,
     *     description="Categoria creada",
     *     @OA\JsonContent(ref="#/components/schemas/Categoria")
     * )
     * )
     *
     */
    public function store(Request $request)
    {
        $reglesvalidacio = [
            'ID_CATEGORIA' => 'required',
            'NOM_CATEGORIA' => 'required|max:50',
            'TARIFA' => 'required|numeric'
        ];
        $missatges = [
            'ID_CATEGORIA.required' => 'El camp ID_CATEGORIA és obligatori',
            'NOM_CATEGORIA.required' => 'El camp NOM_CATEGORIA és obligatori',
            'NOM_CATEGORIA.max' => 'El camp NOM_CATEGORIA no pot tenir més de 50 caràcters',
            'TARIFA.required' => 'El camp TARIFA és obligatori',
            'TARIFA.numeric' => 'El camp TARIFA ha de ser numèric'
        ];
        $validator = Validator::make($request->all(), $reglesvalidacio, $missatges);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        } else {
            $categoria = new Categoria();
            $categoria->ID_CATEGORIA = $request->input('ID_CATEGORIA');
            $categoria->NOM_CATEGORIA = $request->input('NOM_CATEGORIA');
            $categoria->TARIFA = $request->input('TARIFA');
            $categoria->save();
            return response()->json(['status' => 'Categoria creada correctament'], 201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     * @OA\Get(
     *     path="/categories/{id}",
     *     summary="Mostra una categoria",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *     description="ID de la categoria",
     *     in="path",
     *     name="id",
     *     required=true,
     *     @OA\Schema(
     *     type="integer"
     * )
     * ),
     *     @OA\Response(
     *     response=200,
     *     description="Categoria",
     *     @OA\JsonContent(ref="#/components/schemas/Categoria")
     * ),
     *     @OA\Response(
     *     response=404,
     *     description="Categoria no trobada"
     * )
     * )
     */
    public function show($id)
    {
        try {
            $categories = Categoria::findOrFail($id);
            return response()->json($categories);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Categoria not found'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
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
     * @return Response
     *
     * @OA\Put(
     *     path="/categories/put/{id}",
     *     summary="Actualitza una categoria",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *     description="ID de la categoria",
     *     in="path",
     *     name="id",
     *     required=true,
     *     @OA\Schema(
     *     type="integer"
     * )
     * ),
     *     @OA\RequestBody(
     *     description="Dades de la categoria",
     *     required=true,
     *     @OA\JsonContent(ref="#/components/schemas/Categoria")
     * ),
     *     @OA\Response(
     *     response=200,
     *     description="Categoria actualitzada",
     *     @OA\JsonContent(ref="#/components/schemas/Categoria")
     * ),
     *     @OA\Response(
     *     response=404,
     *     description="Categoria no trobada"
     * )
     * )
     */
    public function update(Request $request, $id)
    {
        $reglesvalidacio = [
            'ID_CATEGORIA' => 'required',
            'NOM_CATEGORIA' => 'required|max:50',
            'TARIFA' => 'required|numeric'
        ];
        $missatges = [
            'ID_CATEGORIA.required' => 'El camp ID_CATEGORIA és obligatori',
            'NOM_CATEGORIA.required' => 'El camp NOM_CATEGORIA és obligatori',
            'NOM_CATEGORIA.max' => 'El camp NOM_CATEGORIA no pot tenir més de 50 caràcters',
            'TARIFA.required' => 'El camp TARIFA és obligatori',
            'TARIFA.numeric' => 'El camp TARIFA ha de ser numèric'
        ];
        $validator = Validator::make($request->all(), $reglesvalidacio);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        } else {
            $categoria = Categoria::findOrFail($id);
            $categoria->ID_CATEGORIA = $request->input('ID_CATEGORIA');
            $categoria->NOM_CATEGORIA = $request->input('NOM_CATEGORIA');
            $categoria->TARIFA = $request->input('TARIFA');
            $categoria->save();
            return response()->json(['status' => 'Categoria actualitzada correctament'], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @OA\Delete(
     *     path="/categories/destroy/{id}",
     *    summary="Elimina una categoria",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *     description="ID de la categoria",
     *     in="path",
     *     name="id",
     *     required=true,
     *     @OA\Schema(
     *     type="integer"
     * )
     * ),
     *     @OA\Response(
     *     response=200,
     *     description="Categoria eliminada"
     * ),
     *     @OA\Response(
     *     response=404,
     *     description="Categoria no trobada"
     * )
     * )
     */
    public function destroy(int $id)
    {
       $categoria = Categoria::findOrFail($id);
         $categoria->delete();
            return response()->json(['status' => 'Categoria eliminada correctament'], 200);
    }
}
