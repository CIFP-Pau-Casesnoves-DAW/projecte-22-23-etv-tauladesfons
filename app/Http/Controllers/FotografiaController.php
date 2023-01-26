<?php

namespace App\Http\Controllers;

use App\Models\Fotografia;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(name="Fotografies")
 */
class FotografiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *     path="/fotografies",
     *     summary="Mostra les fotografies",
     *     tags={"Fotografies"},
     *     @OA\Response(
     *         response=200,
     *         description="Retorna totes les fotografies"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No hi ha fotografies"
     *     )
     * )
     * @OA\Schema(
     *     schema="Fotografia",
     *     @OA\Property(
     *     property="ID_FOTO",
     *     type="integer",
     *     description="ID de la fotografia",
     *     example="1"
     *    ),
     *     @OA\Property(
     *     property="FOTO",
     *     type="string",
     *     description="URL de la fotografia",
     *     example="https://www.google.com"
     *   ),
     *     @OA\Property(
     *     property="FK_ID_ALLOTJAMENT",
     *     type="integer",
     *     description="ID de l'allotjament",
     *     example="1"
     *   )
     * )
     */
    public function getFotografies()
    {
        $foto = Fotografia::all();
        return response()->json($foto);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Post(
     *     path="/fotografies",
     *     tags={"Fotografies"},
     *     summary="Crea una fotografia",
     *     operationId="Crea una fotografia",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Fotografia")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Fotografia creada"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error de validació"
     *     )
     * )
     */
    public function insertFotografia(Request $request)
    {
        $validacio = Validator::make($request->all(), [
            'ID_FOTO' => 'required|integer',
            'FOTO' => 'required|string',
            'FK_ID_ALLOTJAMENT' => 'required|integer'
        ]);

        if ($validacio->fails()) {
            return response()->json(['error' => $validacio->errors()->first()], 400);
        }else{
            $foto = new Fotografia();
            $foto->ID_FOTO = $request->ID_FOTO;
            $foto->FOTO = $request->FOTO;
            $foto->FK_ID_ALLOTJAMENT = $request->FK_ID_ALLOTJAMENT;
            $foto->save();
            return response()->json(['success' => 'Fotografia creada correctament',
                'result' => $foto], 201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *     path="/fotografies/{id}",
     *     summary="Mostra una fotografia",
     *     tags={"Fotografies"},
     *     @OA\Parameter(
     *         description="ID de la fotografia",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Fotografia trobada"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No s'ha trobat la fotografia"
     *     )
     * )
     */
    public function getFotografia($id)
    {
        try {
            $foto = Fotografia::findOrFail($id);
            return response()->json(['success' => 'Fotografia trobada correctament',
                'result' => $foto], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'No s\'ha trobat la fotografia'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Put(
     *     path="/fotografies/put/{id}",
     *     summary="Actualitza una fotografia",
     *     tags={"Fotografies"},
     *     operationId="Actualitza una fotografia",
     *     @OA\Parameter(
     *         description="ID de la fotografia",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Fotografia")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Fotografia actualitzada"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error de validació"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No s'ha trobat la fotografia"
     *     )
     * )
     */
    public function updateFotografia(Request $request, $id)
    {
        $validacio = Validator::make($request->all(), [
            'ID_FOTO' => 'required|integer',
            'FOTO' => 'required|string',
            'FK_ID_ALLOTJAMENT' => 'required|integer'
        ]);

        if ($validacio->fails()) {
            return response()->json(['error' => $validacio->errors()->first()], 400);
        } else {
            try {
                $foto = Fotografia::findOrFail($id);
                $foto->ID_FOTO = $request->ID_FOTO;
                $foto->FOTO = $request->FOTO;
                $foto->FK_ID_ALLOTJAMENT = $request->FK_ID_ALLOTJAMENT;
                $foto->save();
                return response()->json(['success' => 'Fotografia modificada correctament',
                    'result' => $foto], 200);
            } catch (ModelNotFoundException $e) {
                return response()->json(['error' => 'No s\'ha trobat la fotografia'], 404);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Delete(
     *     path="/fotografies/destroy/{id}",
     *     summary="Elimina una fotografia",
     *     tags={"Fotografies"},
     *     operationId="Elimina una fotografia",
     *     @OA\Parameter(
     *         description="ID de la fotografia",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Fotografia eliminada"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No s'ha trobat la fotografia"
     *     )
     * )
     */
    public function deleteFotografia($id)
    {
        try {
            $foto = Fotografia::findOrFail($id);
            $foto->delete();
            return response()->json(['success' => 'Fotografia eliminada correctament'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'No s\'ha trobat la fotografia'], 404);
        }
    }
}
