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
    // ! GET DE TOTS
    public function getAllCategories()
    {
        $tuples = Categoria::all();
        return response()->json([
            'status' => 'success',
            'data' => $tuples
        ], 200);
    }

    public function insertCategoria(Request $request)
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
    public function getCategoria($id)
    {
        try {
            $categories = Categoria::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'data' => $categories
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(
                [
                'status' => 'error',
                'message' => 'La categoria amb id ' . $id . ' no existeix'
            ], 404);
        }
    }

    public function updateCategoria(Request $request, $id)
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

    public function deleteCategoria(int $id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->delete();
        return response()->json(['status' => 'Categoria eliminada correctament'], 200);
    }
}
