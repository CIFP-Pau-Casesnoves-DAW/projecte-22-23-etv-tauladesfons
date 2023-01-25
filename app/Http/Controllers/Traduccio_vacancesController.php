<?php

namespace App\Http\Controllers;

use App\Models\Traduccio_vacances;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 *@OA\Tag(name="Traduccio_vacances")
 */

class Traduccio_vacancesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *     path="/traduccio_vacances",
     *     tags={"Traduccio_vacances"},
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
    public function index()
    {
        $tuple = Traduccio_vacances::all();
        return response()->json([
            'status' => 'success',
            'data' => $tuple
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Post(
     *     path="/traduccio_vacances",
     *     tags={"Traduccio_vacances"},
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
    public function store(Request $request)
    {
        $traduccio_vacances = new Traduccio_vacances();
$traduccio_vacances->FK_ID_VACANCES = $request->FK_ID_VACANCES;
$traduccio_vacances->FK_ID_IDIOMA = $request->FK_ID_IDIOMA;
$traduccio_vacances->TRADUCCCIO_VAC= $request->TRADUCCCIO_VAC;
$traduccio_vacances->save();
        return response()->json(['status' => 'success', 'result' => $traduccio_vacances], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *     path="/traduccio_serveis/{id_vcances}/{id_idioma}",
     *     tags={"Traduccio_vacances"},
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
    // ! GET de una en especific

    public function show($id)
    {
        try {
            $traduccio_vacances = Traduccio_vacances::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'data' => $traduccio_vacances
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'No s\'ha trobat la traduccio_vacances amb id ' . $id
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
     */
    /**
     * @OA\Put(
     *     path="/traduccio_serveis/put/{id_vacances}/{id_idioma}",
     *     tags={"Traduccio_vacances"},
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
    /**
     * @OA\Delete(
     *     path="/traduccio_vacances/destroy/{id_vacances}/{id_idioma}",
     *     tags={"Traduccio_vacances"},
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
    public function destroy($id)
    {
        //
    }
}
