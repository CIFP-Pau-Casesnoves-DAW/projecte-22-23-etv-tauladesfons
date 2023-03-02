<?php

namespace App\Http\Controllers;

use App\Models\Traduccio_servei;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;

/**
 *@OA\Tag(name="Traduccions")
 */

class Traduccio_serveiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/traduccio_serveis",
     *     tags={"Traduccions"},
     *     summary="Obtenir totes les traduccions de serveis",
     *     description="Obtenir totes les traduccions de serveis",
     *     operationId="getTraduccionsServei",
     *     @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Traduccio_servei")
     *    )
     *  )
     * )
     * @OA\Schema(
     *     schema="Traduccio_servei",
     *     type="object",
     *     @OA\Property(property="FK_ID_SERVEI", type="integer"),
     *     @OA\Property(property="FK_ID_IDIOMA", type="integer"),
     *     @OA\Property(property="TRADUCCIO_SERVEI", type="string")
     * )
     */
    // ! GET DE TOTS
    public function getAllTraduccionsServeis()
    {
        $tuples = Traduccio_servei::all();
        return response()->json([
            'status' => 'success',
            'result' => $tuples
        ], 200);
    }
    /**
     * @OA\Get(
     *     path="/traduccio_serveis/{id_servei}/{id_idioma}",
     *     tags={"Traduccions"},
     *     summary="Obtenir una traduccio de servei",
     *     description="Obtenir una traduccio de servei",
     *     operationId="getTraduccioServei",
     *     @OA\Parameter(
     *         name="id_servei",
     *         in="path",
     *         description="ID del servei",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="id_idioma",
     *         in="path",
     *         description="ID de l'idioma",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Traduccio_servei")
     *    )
     *  ), @OA\Response(
     *     response=404,
     *     description="Traduccio_servei no trobat",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Traduccio_servei")
     *   )
     * )
     * )
     */
    // ! GET de una en especific
    public function getTraduccioServei($id_servei, $id_idioma)
    {
        try {
            $traduccio_servei = Traduccio_servei::where('FK_ID_SERVEI', $id_servei)->where('FK_ID_IDIOMA', $id_idioma)->first();
            return response()->json(['status' => 'success', 'result' => $traduccio_servei], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'result' => 'No existeix aquesta traduccio_servei'], 404);
        }
    }

    /**
     * @OA\Post(
     *     path="/traduccio_serveis",
     *     tags={"Traduccions"},
     *     security={{"bearerAuth":{}}},
     *     summary="Crear una traduccio de servei",
     *     description="Crear una traduccio de servei",
     *     operationId="insertTraduccioServei",
     *     @OA\RequestBody(
     *         description="Traduccio_servei a crear",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Traduccio_servei")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Traduccio_servei")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validacio",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Traduccio_servei")
     *         )
     *     )
     * )
     */
    // ! INSERT
    public function insertTraduccioServei(Request $request){
        $validacio=Validator::make($request->all(),[
            'FK_ID_SERVEI' => 'exists:SERVEIS,ID_SERVEI',
            'FK_ID_IDIOMA' => 'exists:IDIOMES,ID_IDIOMA'
        ]);
        if (!$validacio->fails()) {
            $traduccio_servei = new Traduccio_servei();
            $traduccio_servei->FK_ID_SERVEI = $request->FK_ID_SERVEI;
            $traduccio_servei->FK_ID_IDIOMA = $request->FK_ID_IDIOMA;
            $traduccio_servei->TRADUCCIO_SERVEI = $request->TRADUCCIO_SERVEI;
            $traduccio_servei->save();
            return response()->json(['status' => 'success', 'result' => $traduccio_servei], 200);
        }
    }

    /**
     * @OA\Put(
     *     path="/traduccio_serveis/put/{id_servei}/{id_idioma}",
     *     tags={"Traduccions"},
     *     security={{"bearerAuth":{}}},
     *     summary="Actualitzar una traduccio de servei",
     *     description="Actualitzar una traduccio de servei",
     *     operationId="updateTraduccioServei",
     *     @OA\Parameter(
     *         name="id_servei",
     *         in="path",
     *         description="ID del servei",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="id_idioma",
     *         in="path",
     *         description="ID de l'idioma",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Traduccio_servei a actualitzar",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Traduccio_servei")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Traduccio_servei")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validacio",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Traduccio_servei")
     *         )
     *     )
     * )
     */
     // ! UPDATE
    public function updateTraduccioServei(Request $request, $id_servei,$id_idioma){
        $reglesValidacio = [
            'FK_ID_SERVEI' => 'required|integer',
            'FK_ID_IDIOMA' => 'required|integer',
            'TRADUCCIO_SERVEI' => 'required|string|max:50'
        ];
        $missatges = [
            'FK_ID_SERVEI.required' => 'El camp de FK_ID_SERVEI és obligatori',
            'FK_ID_SERVEI.integer' => 'El camp de FK_ID_SERVEI ha de ser un enter',
            'FK_ID_IDIOMA.required' => 'El camp de FK_ID_IDIOMA és obligatori',
            'FK_ID_IDIOMA.integer' => 'El camp de FK_ID_IDIOMA ha de ser un enter',
            'TRADUCCIO_SERVEI.required' => 'El camp de TRADUCCIO_SERVEI és obligatori',
            'TRADUCCIO_SERVEI.max' => 'El camp TRADUCCIO_SERVEI no pot tenir més de 50 caràcters'
        ];
        $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);
        if ($validacio -> fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validacio->errors()
            ],400);
        } else {
            try {
                $traduccio_servei = Traduccio_servei::where('FK_ID_SERVEI', $id_servei)->where('FK_ID_IDIOMA', $id_idioma);
                $traduccio_servei->update($request->all());
                return response()->json([
                    'status' => 'success',
                    'data' => $traduccio_servei
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'La traduccio del servei amb la id ' . $id_servei . 'amb idioma' . $id_idioma . 'no existeix'
                ], 404);
            }
        }
    }
    /**
     * @OA\Delete(
     *     path="/traduccio_serveis/destroy/{id_servei}/{id_idioma}",
     *     tags={"Traduccions"},
     *     security={{"bearerAuth":{}}},
     *     summary="Esborrar una traduccio de servei",
     *     description="Esborrar una traduccio de servei",
     *     operationId="deleteTraduccioServei",
     *     @OA\Parameter(
     *         name="id_servei",
     *         in="path",
     *         description="ID del servei",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="id_idioma",
     *         in="path",
     *         description="ID de l'idioma",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Traduccio_servei")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found",
     *         @OA\JsonContent(ref="#/components/schemas/Traduccio_servei")
     *     )
     * )
     */

    // ! DELETE
    public function deleteTraduccioServei($id_servei, $id_idioma)
    {
        $traduccio_servei = Traduccio_servei::where('FK_ID_SERVEI', $id_servei)->where('FK_ID_IDIOMA', $id_idioma)->delete();

        if ($traduccio_servei) {
            return response()->json(['status' => ' Esborrat correctament'], 200);
        } else {
            return response()->json(['status' => 'No trobat'], 404);
        }
    }
}
