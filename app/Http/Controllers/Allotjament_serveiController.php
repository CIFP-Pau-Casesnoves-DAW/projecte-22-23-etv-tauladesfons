<?php

namespace App\Http\Controllers;

use App\Models\Allotjament_servei;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use \Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use OpenApi\Annotations as OA;

/**
 *@OA\Tag(name="Allotjament_serveis")
 */
class Allotjament_serveiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *     path="/allotjaments_serveis",
     *     summary="Mostra els allotjament_serveis",
     *     tags={"Allotjament_serveis"},
     *     @OA\Response(
     *         response=200,
     *         description="Retorna tots els allotjament_serveis"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No hi ha allotjament_serveis"
     *     )
     * )
     * @OA\Schema(
     *     schema="Allotjament_servei",
     *     @OA\Property(
     *     property="FK_ID_ALLOT",
     *     type="integer",
     *     description="ID de l'allotjament",
     *     example="1"
     *    ),
     *     @OA\Property(
     *     property="FK_ID_SERVEI",
     *     type="integer",
     *     description="ID del servei",
     *     example="1"
     *   )
     * )
     */

    // ! GET de tots
    public function index()
    {
        $tuples = Allotjament_servei::all();
        return response()->json($tuples);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Post(
     *     path="/allotjaments_serveis",
     *     summary="Crea un allotjament_servei",
     *     tags={"Allotjament_serveis"},
     *     @OA\RequestBody(
     *         description="Allotjament_servei a crear",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Allotjament_servei"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Allotjament_servei creat"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error creant allotjament_servei"
     *     )
     * )
     */

    // ! INSERT
    public function store(Request $request)
    {
        $reglesvalidacio = Validator::make($request->all(), [
            'FK_ID_ALLOT' => 'exists:ALLOTJAMENTS,ID_ALLOTJAMENT',
            'FK_ID_SERVEI' => 'exists:SERVEIS,ID_SERVEI'
        ]);
        if (!$reglesvalidacio->fails()) {
            $tuple = new Allotjament_servei();
            $tuple->FK_ID_ALLOT = $request->FK_ID_ALLOT;
            $tuple->FK_ID_SERVEI = $request->FK_ID_SERVEI;
            $tuple->save();
            return response()->json($tuple);
        } else {
            return response()->json(['error' => 'Error creant allotjament_servei'], 400);
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
     *     path="/allotjaments_serveis/{id_allot}/{id_servei}",
     *     summary="Mostra un allotjament_servei",
     *     tags={"Allotjament_serveis"},
     *     @OA\Parameter(
     *         description="ID allotjament",
     *         in="path",
     *         name="id_allot",
     *         required=true,
     *         @OA\Schema(
     *           type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="ID servei",
     *         in="path",
     *         name="id_servei",
     *         required=false,
     *         @OA\Schema(
     *           type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Retorna un allotjament_servei"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No existeix allotjament_servei"
     *     )
     * )
     */

    //! GET de un en concret
    public function show($id_allot, $id_servei)
    {
        try {
            $allotjament_servei = Allotjament_servei::where('FK_ID_ALLOT', $id_allot)->where('FK_ID_SERVEI', $id_servei)->firstOrFail();
            return response()->json("Allotjament_servei: " . $allotjament_servei . " amb ID allotjament: " . $id_allot . " i ID servei: " . $id_servei);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'No existeix allotjament_servei amb aquest ID allotjament: ' . $id_allot . ' i ID servei: ' . $id_servei], 404);
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
     *     path="/allotjaments_serveis/put/{id_allot}/{id_servei}",
     *     summary="Actualitza un allotjament_servei",
     *     tags={"Allotjament_serveis"},
     *     @OA\Parameter(
     *         description="ID allotjament",
     *         in="path",
     *         name="id_allot",
     *         required=true,
     *         @OA\Schema(
     *           type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="ID servei",
     *         in="path",
     *         name="id_servei",
     *         required=false,
     *         @OA\Schema(
     *           type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Allotjament_servei a actualitzar",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Allotjament_servei"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Allotjament_servei actualitzat"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error actualitzant allotjament_servei"
     *     )
     * )
     */
    // ! UPDATE
    public function updateAllotjamentServei(Request $request, $id_allot, $id_servei)
    {
        $reglesValidacio = [
            'FK_ID_ALLOT' => 'required|integer',
            'FK_ID_SERVEI' => 'required|integer'
        ];
        $missatges = [
            'FK_ID_ALLOT.required' => 'El camp de FK_ID_ALLOT és obligatori',
            'FK_ID_ALLOT.integer' => 'El camp de FK_ID_ALLOT ha de ser un enter',
            'FK_ID_SERVEI.required' => 'El camp de FK_ID_SERVEI és obligatori',
            'FK_ID_SERVEI.integer' => 'El camp de FK_ID_SERVEI ha de ser un enter'
        ];
        $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);
        if ($validacio->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validacio->errors()
            ], 400);
        } else {
            try {
                $allotjament_servei = Allotjament_servei::where('FK_ID_ALLOT', $id_allot)->where('FK_ID_SERVEI', $id_servei);
                $allotjament_servei->update($request->all());
                return response()->json([
                    'status' => 'success',
                    'data' => $allotjament_servei
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'L\'allotjament amb la id ' . $id_allot . 'amb servei' . $id_servei . 'no existeix'
                ], 404);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $FK_ID_ALLOT
     * @param $FK_ID_SERVEI
     * @return Response
     */
    /**
     * @OA\Delete(
     *     path="/allotjaments_serveis/destroy/{id_allot}/{id_servei}",
     *     summary="Elimina un allotjament_servei",
     *     tags={"Allotjament_serveis"},
     *     @OA\Parameter(
     *         description="ID allotjament",
     *         in="path",
     *         name="id_allot",
     *         required=true,
     *         @OA\Schema(
     *           type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="ID servei",
     *         in="path",
     *         name="id_servei",
     *         required=false,
     *         @OA\Schema(
     *           type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Allotjament_servei eliminat"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Error eliminant allotjament_servei"
     *     )
     * )
     */
    public function destroy($FK_ID_ALLOT, $FK_ID_SERVEI)
    {
        $tuple = Allotjament_servei::where('FK_ID_ALLOT', $FK_ID_ALLOT)->where('FK_ID_SERVEI', $FK_ID_SERVEI)->delete();
        if ($tuple) {
            return response()->json(['success' => 'Allotjament_servei eliminat'], 200);
        } else {
            return response()->json(['error' => 'Allotjament_servei no eliminat'], 404);
        }
    }
}
