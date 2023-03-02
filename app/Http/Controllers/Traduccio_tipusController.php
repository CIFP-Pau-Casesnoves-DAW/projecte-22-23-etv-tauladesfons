<?php

namespace App\Http\Controllers;

use App\Models\Traduccio_tipus;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;

/**
 *@OA\Tag(name="Traduccions")
 */
class Traduccio_tipusController extends Controller
{
    /**
     * @OA\Get(
     *     path="/traduccio_tipus",
     *     summary="Llista de traduccions de tipus",
     *     description="Retorna totes les traduccions de tipus",
     *     tags={"Traduccions"},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Traducció_tipus")
     *   )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     * @OA\Schema(
     *     schema="Traducció_tipus",
     *     @OA\Property(
     *     property="FK_ID_TIPUS",
     *     type="integer",
     *     description="Identificador del tipus",
     *     example=1
     *     ),
     *     @OA\Property(
     *     property="FK_ID_IDIOMA",
     *     type="integer",
     *     description="Identificador de l'idioma",
     *     example=1
     *     ),
     *     @OA\Property(
     *     property="TRADUCCIO_TIPUS",
     *     type="string",
     *     description="Traducció del tipus",
     *     example="Tipus"
     *    )
     * )
     */
    // ! GET all
    public function getTraduccionsTipus()
    {
        $tuples = Traduccio_tipus::all();
        return response()->json([
            'status' => 'success',
            'result' => $tuples
        ], 200);
    }
    /**
     * @OA\Get(
     *     path="/traduccio_tipus/{id_tipus}/{id_idioma}",
     *     summary="Mostra una traducció de tipus",
     *     description="Mostra una traducció de tipus",
     *     tags={"Traduccions"},
     *     @OA\Parameter(
     *         name="id_tipus",
     *         in="path",
     *         description="Identificador del tipus",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="id_idioma",
     *         in="path",
     *         description="Identificador de l'idioma",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *     @OA\JsonContent(ref="#/components/schemas/Traducció_tipus"),
     *
     * @OA\Property(
     *     property="FK_ID_TIPUS",
     *     type="integer",
     *     description="Identificador del tipus",
     *     example=1
     *     ),
     *     @OA\Property(
     *     property="FK_ID_IDIOMA",
     *     type="integer",
     *     description="Identificador de l'idioma",
     *     example=1
     *     ),
     *     @OA\Property(
     *     property="TRADUCCIO_TIPUS",
     *     type="string",
     *     description="Traducció del tipus",
     *     example="Spa"
     *     )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     )
     * )
     */
    public function getTraduccioTipus($id_tipus, $id_idioma)
    {
        try {
            $traduccio_tipus = Traduccio_tipus::where('FK_ID_TIPUS', $id_tipus)->where('FK_ID_IDIOMA', $id_idioma)->first();
            return response()->json([
                'status' => 'success', 
                'data' => $traduccio_tipus
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'No existeix traduccio_servei amb ID tipus: ' . $id_tipus . ' i ID idioma: ' . $id_idioma
            ], 404);
        }
    }

    /**
     * @OA\Post(
     *     path="/traduccio_tipus",
     *     summary="Crear traducció tipus",
     *     description="Crear traducció tipus",
     *     tags={"Traduccions"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Traducció_tipus")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="Creat"
     *             ),
     *             @OA\Property(
     *                 property="result",
     *                 ref="#/components/schemas/Traducció_tipus"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error: tipus o idioma inexistent",
     *     @OA\JsonContent(
     *     type="object",
     *     @OA\Property(
     *     property="status",
     *     type="string",
     *     example="Error: tipus o idioma inexistent"
     *     )
     *   )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function insertTraduccioTipus(Request $request)
    {
        $validacio = Validator::make($request->all(), [
            'FK_ID_TIPUS' => 'exists:TIPUS,ID_TIPUS',
            'FK_ID_IDIOMA' => 'exists:IDIOMES,ID_IDIOMA'
        ]);
        if (!$validacio->fails()) {
            $traduccio_tipus = new Traduccio_tipus();
            $traduccio_tipus->FK_ID_TIPUS = $request->FK_ID_TIPUS;
            $traduccio_tipus->FK_ID_IDIOMA = $request->FK_ID_IDIOMA;
            $traduccio_tipus->TRADUCCIO_TIPUS = $request->TRADUCCIO_TIPUS;
            if ($traduccio_tipus->save()) {
                return response()->json(['status' => 'Creat', 'result' => $traduccio_tipus], 200);
            } else {
                return response()->json(['status' => 'Error creant']);
            }
        } else {
            return response()->json(['status' => 'Error:tipus o idioma inexistents']);
        }
    }
    /**
     * @OA\Put(
     *     path="/traduccio_tipus/put/{id_tipus}/{id_idioma}",
     *     summary="Actualitza una traducció de tipus",
     *     description="Actualitza una traducció de tipus",
     *     tags={"Traduccions"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id_tipus",
     *         in="path",
     *         description="Identificador del tipus",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="id_idioma",
     *         in="path",
     *         description="Identificador de l'idioma",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dades de la traducció de tipus",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="FK_ID_TIPUS",
     *                 type="integer",
     *                 description="Identificador del tipus",
     *                 example=1
     *             ),
     *             @OA\Property(
     *                 property="FK_ID_IDIOMA",
     *                 type="integer",
     *                 description="Identificador de l'idioma",
     *                 example=1
     *             ),
     *             @OA\Property(
     *                 property="TRADUCCIO_TIPUS",
     *                 type="string",
     *                 description="Traducció del tipus",
     *                 example="Spa"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *     @OA\JsonContent(
     *     type="object",
     *     @OA\Property(
     *     property="status",
     *     type="string",
     *     example="Actualitzat"
     *     ),
     *     @OA\Property(
     *     property="result",
     *     type="object",
     *     ref="#/components/schemas/Traducció_tipus"
     *    )
     *    )
     *    ),
     *     @OA\Response(
     *     response=404,
     *     description="Not found"
     *    )
     * )
     *
     */
    public function updateTraduccioTipus(Request $request, $id_tipus, $id_idioma)
    {
        $reglesValidacio = [
            'FK_ID_TIPUS' => 'required|integer',
            'FK_ID_IDIOMA' => 'required|integer',
            'TRADUCCIO_TIPUS' => 'required|string|max:50'
        ];
        $missatges = [
            'FK_ID_TIPUS.required' => 'El camp de FK_ID_TIPUS és obligatori',
            'FK_ID_TIPUS.integer' => 'El camp de FK_ID_TIPUS ha de ser un enter',
            'FK_ID_IDIOMA.required' => 'El camp de FK_ID_IDIOMA és obligatori',
            'FK_ID_IDIOMA.integer' => 'El camp de FK_ID_IDIOMA ha de ser un enter',
            'TRADUCCIO_TIPUS.required' => 'El camp de TRADUCCIO_TIPUS és obligatori',
            'TRADUCCIO_TIPUS.max' => 'El camp TRADUCCIO_TIPUS no pot tenir més de 50 caràcters'
        ];
        $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);
        if ($validacio->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validacio->errors()
            ], 400);
        } else {
            try {
                $traduccio_tipus = Traduccio_tipus::where('FK_ID_TIPUS', $id_tipus)->where('FK_ID_IDIOMA', $id_idioma)->firstOrFail();
                $traduccio_tipus->update($request->all());
                return response()->json([
                    'status' => 'success',
                    'data' => $traduccio_tipus
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'La traduccio del servei amb la id ' . $id_tipus . 'amb idioma' . $id_idioma . 'no existeix'
                ], 404);
            }
        }
    }
    /**
     * @OA\Delete(
     *     path="/traduccio_tipus/destroy/{id_tipus}/{id_idioma}",
     *     summary="Esborra una traducció de tipus",
     *     description="Esborra una traducció de tipus",
     *     tags={"Traduccions"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id_tipus",
     *         in="path",
     *         description="Identificador del tipus",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="id_idioma",
     *         in="path",
     *         description="Identificador de l'idioma",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Esborrat correctament"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     )
     * )
     */
    public function deleteTraduccioTipus($id_tipus, $id_idioma)
    {
        $traduccio_tipus = Traduccio_tipus::where('FK_ID_TIPUS', $id_tipus)->where('FK_ID_IDIOMA', $id_idioma)->delete();

        if ($traduccio_tipus) {
            return response()->json(['status' => ' Esborrat correctament'], 200);
        } else {
            return response()->json(['status' => 'No trobat'], 404);
        }
    }
}
