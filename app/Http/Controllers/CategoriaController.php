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

    // ! POST D'UN CATEGORIA
/**
     * @OA\Post(
     *     path="/categories",
     *     summary="Crea una categoria",
     *     tags={"Categories"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *     required=true,
     *     description="Dades de la categoria",
     *     @OA\JsonContent(
     *     required={"NOM_CATEGORIA","TARIFA"},
     *     @OA\Property(property="NOM_CATEGORIA", type="string"),
     *     @OA\Property(property="TARIFA", type="number")
     *  )
     * ),
     *     @OA\Response(
     *     response=200,
     *     description="Categoria creada",
     *     @OA\JsonContent(
     *     type="object",
     *     @OA\Property(property="status", type="string"),
     *     @OA\Property(property="data", ref="#/components/schemas/Categoria")
     * )
     * )
     * )
     */

    public function insertCategoria(Request $request)
    {
        $reglesvalidacio = [
            'NOM_CATEGORIA' => 'required|max:50',
            'TARIFA' => 'required|numeric'
        ];
        $missatges = [
            'NOM_CATEGORIA.required' => 'El camp NOM_CATEGORIA és obligatori',
            'NOM_CATEGORIA.string' => 'El camp NOM_CATEGORIA és obligatori',
            'NOM_CATEGORIA.max' => 'El camp NOM_CATEGORIA no pot tenir més de 50 caràcters',
            'TARIFA.required' => 'El camp TARIFA és obligatori',
            'TARIFA.numeric' => 'El camp TARIFA ha de ser numèric'
        ];
        $validator = Validator::make($request->all(), $reglesvalidacio, $missatges);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 400);
        } else {
            $categoria = Categoria::firstOrCreate(['NOM_CATEGORIA' => $request->NOM_CATEGORIA,
                                                    'TARIFA' => $request->TARIFA]);
            if ($categoria->wasRecentlyCreated) {
                return response()->json([
                    'status' => 'success',
                    'data' => $categoria
                ], 201);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'La categoria ja existeix'
                ], 409);
            }
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

    /**
     *  @OA\Put(
     *     path="/categories/put/{id}",
     *     summary="Actualitza una categoria",
     *     tags={"Categories"},
     *     security={{"bearerAuth":{}}},
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
     *     required=true,
     *     @OA\JsonContent(
     *     required={"NOM_CATEGORIA","TARIFA"},
     *     @OA\Property(property="NOM_CATEGORIA", type="string"),
     *     @OA\Property(property="TARIFA", type="number")
     * )
     * ),
     *     @OA\Response(
     *     response=200,
     *     description="Categoria actualitzada",
     *     @OA\JsonContent(
     *     type="object",
     *     @OA\Property(property="status", type="string"),
     *     @OA\Property(property="data", ref="#/components/schemas/Categoria")
     * )
     * ),
     *     @OA\Response(
     *     response=400,
     *     description="Error de validació",
     *     @OA\JsonContent(
     *     type="object",
     *     @OA\Property(property="status", type="string"),
     *     @OA\Property(property="errors", ref="#/components/schemas/Categoria")
     * )
     * ),
     *     @OA\Response(
     *     response=404,
     *     description="Categoria no trobada",
     *     @OA\JsonContent(
     *     type="object",
     *     @OA\Property(property="status", type="string"),
     *     @OA\Property(property="data", type="string")
     * )
     * )
     * )
     *
     */

    public function updateCategoria(Request $request, $id)
    {
        $reglesvalidacio = [
            'NOM_CATEGORIA' => 'required|max:50',
            'TARIFA' => 'required|numeric'
        ];
        $missatges = [
            'NOM_CATEGORIA.required' => 'El camp NOM_CATEGORIA és obligatori',
            'NOM_CATEGORIA.max' => 'El camp NOM_CATEGORIA no pot tenir més de 50 caràcters',
            'TARIFA.required' => 'El camp TARIFA és obligatori',
            'TARIFA.numeric' => 'El camp TARIFA ha de ser numèric'
        ];
        $validator = Validator::make($request->all(), $reglesvalidacio, $missatges);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'error' => $validator->errors()
            ], 400);
        } else {
            try {
                $categoria = Categoria::findOrFail($id);
                $nouNomCategoria = $request->NOM_CATEGORIA;
                $novaTarifa = $request->TARIFA;
                if ($categoria->NOM_CATEGORIA !== $nouNomCategoria) {
                    $categoriaExist = Categoria::where('NOM_CATEGORIA', $nouNomCategoria)->first();
                    if ($categoriaExist !== null) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'El nom de la categoria ja existeix'
                        ], 409);
                    }
                    $categoria->NOM_CATEGORIA = $nouNomCategoria;
                    $categoria->TARIFA = $novaTarifa;
                }
                $categoria->save();
                return response()->json([
                    'status' => 'success',
                    'data' => $categoria
                ], 200);
            } catch (ModelNotFoundException $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No s\'ha trobat cap categoria amb la ID proporcionada',
                ], 404);
            }
        }
    }

    /**
     * @OA\Delete(
     *     path="/categories/destroy/{id}",
     *     summary="Elimina una categoria",
     *     tags={"Categories"},
     *     security={{"bearerAuth":{}}},
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
     *     description="Categoria eliminada",
     *     @OA\JsonContent(
     *     type="object",
     *     @OA\Property(property="status", type="string"),
     *     @OA\Property(property="message", type="string")
     * )
     * ),
     *     @OA\Response(
     *     response=404,
     *     description="Categoria no trobada",
     *     @OA\JsonContent(
     *     type="object",
     *     @OA\Property(property="status", type="string"),
     *     @OA\Property(property="message", type="string")
     * )
     * )
     * )
     */

    public function deleteCategoria(int $id)
    {
        try {
            $tuples = Categoria::findOrFail($id);
            $tuples->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Categoria eliminada correctament'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'No s\'ha trobat cap categoria amb la ID proporcionada',
            ], 404);
        }
    }
}
