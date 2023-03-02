<?php

namespace App\Http\Controllers;

use App\Models\Valoracio;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;

/** @OA\Tag(name="Valoracions") */
class ValoracioController extends Controller
{
    /** @OA\Get(
     *     path="/valoracions",
     *     tags={"Valoracions"},
     *     summary="Obtenir totes les valoracions",
     *     description="Retorna totes les valoracions",
     *     operationId="indexValoracions",
     *     @OA\Response(
     *         response=200,
     *         description="Valoracions response",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Valoracio")
     *         ),
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="unexpected error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="An error occurred")
     *         )
     *     )
     * )
     * @OA\Schema(
     *     schema="Valoracio",
     *     type="object",
     *     title="Valoracio model",
     *     @OA\Property(property="ID_VALORACIO", type="integer", format="int64", description="ID de la valoracio"),
     *     @OA\Property(property="PUNTUACIO", type="integer", format="int64", description="Puntuacio de la valoracio"),
     *     @OA\Property(property="FK_ID_USUARI", type="integer", format="int64", description="ID de l'usuari que ha valorat"),
     *     @OA\Property(property="FK_ID_ALLOTJAMENT", type="integer", format="int64", description="ID de l'allotjament que ha estat valorat")
     * )
     */
    public function index()
    {
        $tuples = Valoracio::all();
        return response()->json([
            'status' => 'success',
            'result' => $tuples
        ], 200);
    }
    /**
     * @OA\Post(
     *     path="/valoracions",
     *     tags={"Valoracions"},
     *     security={{"bearerAuth":{}}},
     *     summary="Inserir una nova valoracio",
     *     description="Inserir una nova valoracio",
     *     operationId="storeValoracio",
     *     @OA\RequestBody(
     *         description="Objecte valoracio",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Valoracio"),
     *             @OA\Schema(ref="#/components/schemas/Valoracio")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Valoracio response",
     *         @OA\JsonContent(ref="#/components/schemas/Valoracio"),
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="unexpected error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="An error occurred")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $reglesvalidacio  = [
            'ID_VALORACIO' => 'required|integer',
            'PUNTUACIO' => 'required|integer',
            'FK_ID_USUARI' => 'required|integer',
            'FK_ID_ALLOTJAMENT' => 'required|integer'
        ];
        $missatges = [
            'ID_VALORACIO.required' => 'El camp ID_VALORACIO és obligatori.',
            'ID_VALORACIO.integer' => 'El camp ID_VALORACIO ha de ser un número enter.',
            'PUNTUACIO.required' => 'El camp PUNTUACIO és obligatori.',
            'PUNTUACIO. integer' => 'El camp PUNTUACIO ha de ser un número enter.',
            'FK_ID_USUARI.required' => 'El camp FK_ID_USUARI és obligatori.',
            'FK_ID_USUARI.integer' => 'El camp FK_ID_USUARI ha de ser un número enter.',
            'FK_ID_ALLOTJAMENT.required' => 'El camp FK_ID_ALLOTJAMENT és obligatori.',
            'FK_ID_ALLOTJAMENT.integer' => 'El camp FK_ID_ALLOTJAMENT ha de ser un número enter.'
        ];
        $validacio = Validator::make($request->all(), $reglesvalidacio, $missatges);
        if ($validacio->fails()) {
            return response()->json($validacio->errors(), 400);
        } else {
            $valoracions = new Valoracio();
            $valoracions->ID_VALORACIO = $request->input('ID_VALORACIO');
            $valoracions->PUNTUACIO = $request->input('PUNTUACIO');
            $valoracions->FK_ID_USUARI = $request->input('FK_ID_USUARI');
            $valoracions->FK_ID_ALLOTJAMENT = $request->input('FK_ID_ALLOTJAMENT');
            $valoracions->save();
            return response()->json(['status' => 'success', 'result' => $valoracions], 200);
        }
    }

    /**
     * @OA\Get(
     *     path="/valoracions/{id}",
     *     tags={"Valoracions"},
     *     summary="Mostrar una valoracio",
     *     description="Mostrar una valoracio",
     *     operationId="showValoracio",
     *     @OA\Parameter(
     *         description="ID de la valoracio",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Valoracio obtinguda",
     *         @OA\JsonContent(ref="#/components/schemas/Valoracio"),
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="unexpected error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="An error occurred")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        try {
            $valoracions = Valoracio::findOrFail($id);
            return response()->json(['status' => 'success', 'result' => $valoracions], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'result' => 'No s\'ha trobat la valoració.'], 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/valoracions/put/{id}",
     *     tags={"Valoracions"},
     *     security={{"bearerAuth":{}}},
     *     summary="Actualitzar una valoracio",
     *     description="Actualitzar una valoracio",
     *     operationId="updateValoracio",
     *     @OA\Parameter(
     *         description="ID de la valoracio",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Valoracio"),
     *             @OA\Schema(ref="#/components/schemas/Valoracio")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Valoracio actualitzada",
     *         @OA\JsonContent(ref="#/components/schemas/Valoracio"),
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="unexpected error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="An error occurred")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $reglesvalidacio  = [
            'ID_VALORACIO' => 'required|integer',
            'PUNTUACIO' => 'required|integer',
            'FK_ID_USUARI' => 'required|integer',
            'FK_ID_ALLOTJAMENT' => 'required|integer'
        ];
        $missatges = [
            'ID_VALORACIO.required' => 'El camp ID_VALORACIO és obligatori.',
            'ID_VALORACIO.integer' => 'El camp ID_VALORACIO ha de ser un número enter.',
            'PUNTUACIO.required' => 'El camp PUNTUACIO és obligatori.',
            'PUNTUACIO. integer' => 'El camp PUNTUACIO ha de ser un número enter.',
            'FK_ID_USUARI.required' => 'El camp FK_ID_USUARI és obligatori.',
            'FK_ID_USUARI.integer' => 'El camp FK_ID_USUARI ha de ser un número enter.',
            'FK_ID_ALLOTJAMENT.required' => 'El camp FK_ID_ALLOTJAMENT és obligatori.',
            'FK_ID_ALLOTJAMENT.integer' => 'El camp FK_ID_ALLOTJAMENT ha de ser un número enter.'
        ];
        $validacio = Validator::make($request->all(), $reglesvalidacio, $missatges);
        $tuples = Valoracio::where('ID_VALORACIO', $id)->update($request->except(['_token']));
        if ($validacio->fails()) {
            return response()->json([
                'error' => $validacio->errors()->all()
            ]);
        } else {
            return response()->json([
                'success' => 'Valoració modificada correctament.'
            ]);
        }
    }

    /**
     * @OA\Delete(
     *     path="/valoracions/destroy/{id}",
     *     tags={"Valoracions"},
     *     security={{"bearerAuth":{}}},
     *     summary="Eliminar una valoracio",
     *     description="Eliminar una valoracio",
     *     operationId="deleteValoracio",
     *     @OA\Parameter(
     *         description="ID de la valoracio",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Valoracio eliminada",
     *         @OA\JsonContent(ref="#/components/schemas/Valoracio"),
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="unexpected error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="An error occurred")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $tuples = Valoracio::where('ID_VALORACIO', $id)->delete();
            return  response()->json([
                'success' => 'Valoració eliminada correctament.'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'No s\'ha pogut eliminar la valoració.'
            ]);
        }
    }
}
