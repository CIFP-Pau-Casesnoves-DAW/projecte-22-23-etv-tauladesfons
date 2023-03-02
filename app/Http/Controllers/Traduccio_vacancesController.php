<?php

namespace App\Http\Controllers;
use App\Models\Traduccio_vacances;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;

/**
 *@OA\Tag(name="Traduccions")
 */

class Traduccio_vacancesController extends Controller
{
    /**
     * @OA\Get(
     *     path="/traduccio_vacances",
     *     tags={"Traduccions"},
     *     summary="Obtenir totes les traduccions de vacances",
     *     description="Obtenir totes les traduccions de vacances",
     *     operationId="getTraduccionsVacances",
     *     @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Traduccio_vacances")
     *    )
     *  )
     * )
     * @OA\Schema(
     *     schema="Traduccio_vacances",
     *     type="object",
     *     @OA\Property(property="FK_ID_VACANCES", type="integer"),
     *     @OA\Property(property="FK_ID_IDIOMA", type="integer"),
     *     @OA\Property(property="TRADUCCIO_VAC", type="string")
     * )
     */
    // ! GET all
    public function getAllTraduccionsVacances()
    {
        $tuples = Traduccio_vacances::all();
        return response()->json([
            'status' => 'success',
            'result' => $tuples
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/traduccio_vacances/{id_vacances}/{id_idioma}",
     *     tags={"Traduccions"},
     *     summary="Obtenir una traduccio de vacances",
     *     description="Obtenir una traduccio de vacances",
     *     operationId="getTraduccioVacances",
     *     @OA\Parameter(
     *         name="id_vacances",
     *         in="path",
     *         description="ID de les vacances",
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
     *     @OA\Items(ref="#/components/schemas/Traduccio_vacances")
     *    )
     *  ), @OA\Response(
     *     response=404,
     *     description="Traduccio_vacances no trobat",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Traduccio_vacances")
     *   )
     * )
     * )
     */

    // ! GET d'una en específic
    public function getTraduccioVacances($id_vacances, $id_idioma)
    {
        try {
            $traduccio_vacances = Traduccio_vacances::where('FK_ID_VACANCES', $id_vacances)->where('FK_ID_IDIOMA', $id_idioma)->first();
            return response()->json(['status' => 'success', 'result' => $traduccio_vacances], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'result' => 'No existeix aquesta traduccio_vacances'], 404);
        }
    }

    /**
     * @OA\Post(
     *     path="/traduccio_vacances",
     *     tags={"Traduccions"},
     *     security={{"bearerAuth":{}}},
     *     summary="Crear una traduccio de vacances",
     *     description="Crear una traduccio de vacances",
     *     operationId="insertTraduccioVacances",
     *     @OA\RequestBody(
     *         description="Traduccio_vacances a crear",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Traduccio_vacances")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Traduccio_vacances")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validacio",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Traduccio_vacances")
     *         )
     *     )
     * )
     */
    // ! INSERT
    public function insertTraduccioVacances(Request $request)
    {
        $validacio = Validator::make($request->all(), [
            'FK_ID_VACANCES' => 'exists:vacances,id_vacances',
            'FK_ID_IDIOMA' => 'exists:idiomes,ID_IDIOMA'
        ]);
        if (!$validacio->fails()) {
            $traduccio_vacances = new Traduccio_vacances();
            $traduccio_vacances->FK_ID_VACANCES = $request->FK_ID_VACANCES;
            $traduccio_vacances->FK_ID_IDIOMA = $request->FK_ID_IDIOMA;
            $traduccio_vacances->TRADUCCIO_VAC = $request->TRADUCCIO_VAC;
            if ($traduccio_vacances->save()) {
                return response()->json(['status' => 'Creat', 'result' => $traduccio_vacances], 200);
            } else {
                return response()->json(['status' => 'Error creant']);
            }
        } else {
            return response()->json(['status' => 'Error:vacances o idioma inexistents']);

        }
    }
    /**
     * @OA\Put(
     *     path="/traduccio_vacances/put/{id_vacances}/{id_idioma}",
     *     tags={"Traduccions"},
     *     security={{"bearerAuth":{}}},
     *     summary="Actualitzar una traduccio de vacances",
     *     description="Actualitzar una traduccio de vacances",
     *     operationId="updateTraduccioVacances",
     *     @OA\Parameter(
     *         name="id_vacances",
     *         in="path",
     *         description="ID de les vacances",
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
     *         description="Traduccio_vacances a actualitzar",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Traduccio_vacances")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Traduccio_vacances")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validacio",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Traduccio_vacances")
     *         )
     *     )
     * )
     */

    // ! UPDATE
    public function updateTraduccioVacances(Request $request, $id_vacances, $id_idioma)
    {
        $reglesValidacio = [
            'FK_ID_VACANCES' => 'required|integer',
            'FK_ID_IDIOMA' => 'required|integer',
            'TRADUCCIO_VAC' => 'required|string|max:50'
        ];
        $missatges = [
            'FK_ID_VACANCES.required' => 'El camp de FK_ID_VACANCES és obligatori',
            'FK_ID_VACANCES.integer' => 'El camp de FK_ID_VACANCES ha de ser un enter',
            'FK_ID_IDIOMA.required' => 'El camp de FK_ID_IDIOMA és obligatori',
            'FK_ID_IDIOMA.integer' => 'El camp de FK_ID_IDIOMA ha de ser un enter',
            'TRADUCCIO_VAC.required' => 'El camp de TRADUCCIO_VAC és obligatori',
            'TRADUCCIO_VAC.max' => 'El camp TRADUCCIO_VAC no pot tenir més de 50 caràcters'
        ];
        $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);
        if ($validacio->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validacio->errors()
            ], 400);
        } else {
            try {
                $traduccio_vacances = Traduccio_vacances::where('FK_ID_VACANCES', $id_vacances)->where('FK_ID_IDIOMA', $id_idioma);
                $traduccio_vacances->update($request->all());
                return response()->json([
                    'status' => 'success',
                    'data' => $traduccio_vacances
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'La traduccio de vacances amb la id ' . $id_vacances . 'amb idioma' . $id_idioma . 'no existeix'
                ], 404);
            }
        }
    }
    
    /**
     * @OA\Delete(
     *     path="/traduccio_vacances/destroy/{id_vacances}/{id_idioma}",
     *     tags={"Traduccions"},
     *     security={{"bearerAuth":{}}},
     *     summary="Esborrar una traduccio de vacances",
     *     description="Esborrar una traduccio de vacances",
     *     operationId="deleteTraduccioVacances",
     *     @OA\Parameter(
     *         name="id_vacances",
     *         in="path",
     *         description="ID de les vacances",
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
     *         @OA\JsonContent(ref="#/components/schemas/Traduccio_vacances")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found",
     *         @OA\JsonContent(ref="#/components/schemas/Traduccio_vacances")
     *     )
     * )
     */
        // ! DELETE
        public function deleteTraduccioVacances($id_vacances, $id_idioma)
        {
            $traduccio_vacances = Traduccio_VACANCES::where('FK_ID_VACANCES', $id_vacances)->where('FK_ID_IDIOMA', $id_idioma)->delete();
    
            if ($traduccio_vacances) {
                return response()->json(['status' => ' Esborrat correctament'], 200);
            } else {
                return response()->json(['status' => 'No trobat'], 404);
            }
        }

}
