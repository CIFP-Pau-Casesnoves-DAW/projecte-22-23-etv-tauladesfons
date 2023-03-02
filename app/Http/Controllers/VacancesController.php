<?php

namespace App\Http\Controllers;

use App\Models\Vacances;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;

/**
 *@OA\Tag(name="Vacances")
 */
class VacancesController extends Controller
{
    /**
     * @OA\Get(
     *     path="/vacances",
     *     tags={"Vacances"},
     *     summary="Llista de vacances",
     *     description="Retorna una llista de vacances",
     *     operationId="indexes",
     *     @OA\Response(
     *         response=200,
     *         description="Llista de vacances",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Vacances")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *     ),
     * )
     * @OA\Schema(
     *     schema="Vacances",
     *     type="object",
     *     @OA\Property(property="ID_VACANCES", type="integer"),
     *     @OA\Property(property="NOM_VACANCES", type="string")
     *
     * )
     */
    // ! GET DE TOTS
    public function getAllVacances()
    {
        $tuple = Vacances::all();
        return response()->json([
            'status' => 'success',
            'result' => $tuple
        ], 200);
    }
    /**
     * @OA\Post(
     *     path="/vacances",
     *     tags={"Vacances"},
     *     security={{"bearerAuth":{}}},
     *     summary="Afegeix una vacances",
     *     description="Afegeix una vacances a la base de dades",
     *     operationId="afegirVacances",
     *     @OA\Response(
     *         response=201,
     *         description="Vacances afegida",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Vacances no afegida",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *     ),
     *     @OA\RequestBody(
     *         description="Vacances a afegir",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Vacances"),
     *     ),
     * )
     */
    public function insertVacances(Request $request)
    {
        $reglesvalidacio = [
            'ID_VACANCES' => 'required|integer',
            'NOM_VACANCES' => 'required|string|max:50'
        ];
        $missatges = [
            'ID_VACANCES.required' => 'El camp ID_VACANCES és obligatori.',
            'ID_VACANCES.integer' => 'El camp ID_VACANCES ha de ser un número enter.',
            'NOM_VACANCES.required' => 'El camp NOM_VACANCES és obligatori.',
            'NOM_VACANCES.string' => 'El camp NOM_VACANCES ha de ser una cadena de caràcters.',
            'NOM_VACANCES.max' => 'El camp NOM_VACANCES no pot tenir més de 50 caràcters.'
        ];
        $validacio = Validator::make($request->all(), $reglesvalidacio, $missatges);
        if ($validacio->fails()) {
            return response()->json($validacio->errors(), 400);
        } else {
            $vacances = new Vacances;
            $vacances->ID_VACANCES = $request->input('ID_VACANCES');
            $vacances->NOM_VACANCES = $request->input('NOM_VACANCES');
            $vacances->save();
            return response()->json($vacances, 201);
        }
    }

    /**
     * @OA\Get(
     *     path="/vacances/{id}",
     *     tags={"Vacances"},
     *     summary="Mostra una vacances",
     *     description="Retorna una vacances",
     *     operationId="mostraVacances",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la vacances",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Vacances",
     *         @OA\JsonContent(ref="#/components/schemas/Vacances"),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Vacances no trobada",
     *     ),
     * )
     */
    public function getVacances($id)
    {
        try {
            $vacances = Vacances::findOrFail($id);
            return response()->json(['status' => 'success', 'result' => $vacances], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'result' => 'No s\'han trobat les vacances.'], 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/vacances/put/{id}",
     *     tags={"Vacances"},
     *     security={{"bearerAuth":{}}},
     *     summary="Modifica una vacances",
     *     description="Modifica una vacances",
     *     operationId="modificarVacances",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la vacances",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Vacances modificada",
     *         @OA\JsonContent(ref="#/components/schemas/Vacances"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Vacances no modificada",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Vacances no trobada",
     *     ),
     *     @OA\RequestBody(
     *         description="Vacances a modificar",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Vacances"),
     *     ),
     * )
     */
    public function updateVacances(Request $request, $id)
    {
        $reglesvalidacio = [
            'ID_VACANCES' => 'required|integer',
            'NOM_VACANCES' => 'required|string|max:50'
        ];
        $missatges = [
            'ID_VACANCES.required' => 'El camp ID_VACANCES és obligatori.',
            'ID_VACANCES.integer' => 'El camp ID_VACANCES ha de ser un número enter.',
            'NOM_VACANCES.required' => 'El camp NOM_VACANCES és obligatori.',
            'NOM_VACANCES.string' => 'El camp NOM_VACANCES ha de ser una cadena de caràcters.',
            'NOM_VACANCES.max' => 'El camp NOM_VACANCES no pot tenir més de 50 caràcters.'
        ];
        $validacio = Validator::make($request->all(), $reglesvalidacio, $missatges);
        $tuples = Vacances::where('ID_VACANCES', $id)->update($request->except(['_token']));
        if ($validacio->fails()) {
            return response()->json([
                'error' => $validacio->errors()->all()
            ]);
        } else {
            return response()->json([
                'success' => 'Vacances modificades correctament.'
            ]);
        }
    }

    /**
     * @OA\Delete(
     *     path="/vacances/destroy/{id}",
     *     tags={"Vacances"},
     *     security={{"bearerAuth":{}}},
     *     summary="Elimina una vacances",
     *     description="Elimina una vacances",
     *     operationId="eliminarVacances",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la vacances",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Vacances eliminada",
     *         @OA\JsonContent(ref="#/components/schemas/Vacances"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Vacances no eliminada",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Vacances no trobada",
     *     ),
     * )
     */
    public function deleteVacances($id)
    {
        try {
            $tuples = Vacances::where('ID_VACANCES', $id)->delete();
            return  response()->json([
                'success' => 'Vacances eliminades correctament.'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'No s\'han pogut eliminar les vacances.'
            ]);
        }
    }
}
