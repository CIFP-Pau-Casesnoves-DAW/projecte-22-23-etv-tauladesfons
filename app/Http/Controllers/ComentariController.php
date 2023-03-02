<?php

namespace App\Http\Controllers;

use App\Models\Comentari;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag( name="Comentaris")
 */
class ComentariController extends Controller
{
    /**
     * @OA\Get(
     *     path="/comentaris",
     *     tags={"Comentaris"},
     *     summary="Mostra tots els comentaris",
     *     description="Retorna tots els comentaris",
     *     operationId="index",
     *     @OA\Response(
     *     response=200,
     *     description="Retorna tots els comentaris",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Comentari")
     *    )
     *   ),
     *     @OA\Response(
     *     response=401,
     *     description="No autoritzat",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Comentari")
     *   )
     * )
     * )
     *  @OA\Schema(
     *     schema="Comentari",
     *     type="object",
     *     @OA\Property(property="ID_COMENTARI", type="integer"),
     *     @OA\Property(property="DESCRIPCIO", type="string"),
     *     @OA\Property(property="HORA", type="time"),
     *     @OA\Property(property="DATA", type="date"),
     *     @OA\Property(property="FK_ID_USUARI", type="integer"),
     *     @OA\Property(property="FK_ID_ALLOTJAMENT", type="integer")
     * )
     *
     * )
     */
    public function index()
    {
        $tuples = Comentari::all();
        return response()->json([
            'status' => 'success',
            'data' => $tuples
        ], 200);
    }

    /**
     * @OA\Post(
     *    path="/comentaris",
     *     tags={"Comentaris"},
     *     security={{"bearerAuth":{}}},
     *     summary="Afegeix un comentari",
     *     description="Afegeix un comentari",
     *     @OA\RequestBody(
     *     required=true,
     *     description="Dades del comentari",
     *     @OA\JsonContent(
     *     required={"ID_COMENTARI","DESCRIPCIO","HORA","DATA","FK_ID_USUARI","FK_ID_ALLOTJAMENT"},
     *     @OA\Property(property="ID_COMENTARI", type="integer", format="int64", example=1),
     *     @OA\Property(property="DESCRIPCIO", type="string", format="string", example="Bon allotjament"),
     *     @OA\Property(property="HORA", type="string", format="string", example="12:00:00"),
     *     @OA\Property(property="DATA", type="string", format="string", example="2020-12-12"),
     *     @OA\Property(property="FK_ID_USUARI", type="integer", format="int64", example=1),
     *     @OA\Property(property="FK_ID_ALLOTJAMENT", type="integer", format="int64", example=1)
     *  )
     * ),
     *     @OA\Response(
     *     response=200,
     *     description="Retorna el comentari que s'ha afegit",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Comentari")
     *   )
     * ),
     *     @OA\Response(
     *     response=401,
     *     description="No autoritzat",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Comentari")
     *  )
     * )
     * )
     */
    public function store(Request $request)
    {
        $reglesvalidacio = [
            'ID_COMENTARI' => 'required',
            'DESCRIPCIO' => 'required|max:255',
            'HORA' => 'required|date_format:H:i:s',
            'DATA' => 'required|date_format:Y-m-d',
            'FK_ID_USUARI' => 'required',
            'FK_ID_ALLOTJAMENT' => 'required'

        ];
        $missatges = [
            'ID_COMENTARI.required' => 'El camp ID_COMENTARI és obligatori',
            'DESCRIPCIO.required' => 'El camp DESCRIPCIO és obligatori',
            'DESCRIPCIO.max' => 'El camp DESCRIPCIO no pot tenir més de 255 caràcters',
            'HORA.required' => 'El camp HORA és obligatori',
            'HORA.date_format' => 'El camp HORA no té el format correcte',
            'DATA.required' => 'El camp DATA és obligatori',
            'DATA.date_format' => 'El camp DATA no té el format correcte',
            'FK_ID_USUARI.required' => 'El camp FK_ID_USUARI és obligatori',
            'FK_ID_ALLOTJAMENT.required' => 'El camp FK_ID_ALLOTJAMENT és obligatori'
        ];
        $validator = Validator::make($request->all(), $reglesvalidacio, $missatges);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        } else {
            $comentaris = new Comentari();
            $comentaris->ID_COMENTARI = $request->input('ID_COMENTARI');
            $comentaris->DESCRIPCIO = $request->input('DESCRIPCIO');
            $comentaris->HORA = $request->input('HORA');
            $comentaris->DATA = $request->input('DATA');
            $comentaris->FK_ID_USUARI = $request->input('FK_ID_USUARI');
            $comentaris->FK_ID_ALLOTJAMENT = $request->input('FK_ID_ALLOTJAMENT');
            $comentaris->save();
            return response()->json(['status' => 'Comentari creat correctament'], 201);
        }
    }

    /**
     * @OA\Get(
     *      path="/comentaris/{id}",
     *     operationId="getComentariById",
     *     tags={"Comentaris"},
     *     summary="Mostra un comentari",
     *     description="Retorna un comentari",
     *     @OA\Parameter(
     *     name="id",
     *     description="Comentari id",
     *     required=true,
     *     in="path",
     *     @OA\Schema(
     *     type="integer"
     *  )
     * ),
     *     @OA\Response(
     *     response=200,
     *      description="Retorna el comentari",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Comentari")
     *  )
     * ),
     *     @OA\Response(
     *     response=404,
     *     description="Comentari no trobat",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Comentari")
     * )
     * )
     *     )
     *
     * )
     */
    public function show($id)
    {
        try {
            $comentaris = Comentari::findOrFail($id);
            return response()->json($comentaris);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Comentari no trobat'], 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/comentaris/put/{id}",
     *     operationId="updateComentari",
     *     tags={"Comentaris"},
     *     security={{"bearerAuth":{}}},
     *     summary="Actualitza un comentari",
     *     description="Actualitza un comentari",
     *     @OA\Parameter(
     *     name="id",
     *     description="Comentari id",
     *     required=true,
     *     in="path",
     *     @OA\Schema(
     *     type="integer"
        *  )
     * ),
     *     @OA\RequestBody(
     *     required=true,
     *     description="Dades del comentari",
     *     @OA\JsonContent(
     *     required={"ID_COMENTARI","DESCRIPCIO","HORA","DATA","FK_ID_USUARI","FK_ID_ALLOTJAMENT"},
     *     @OA\Property(property="ID_COMENTARI", type="integer", format="int64", example=1),
     *     @OA\Property(property="DESCRIPCIO", type="string", format="string", example="Bon allotjament"),
     *     @OA\Property(property="HORA", type="string", format="string", example="12:00:00"),
     *     @OA\Property(property="DATA", type="string", format="string", example="2020-12-12"),
     *     @OA\Property(property="FK_ID_USUARI", type="integer", format="int64", example=1),
     *     @OA\Property(property="FK_ID_ALLOTJAMENT", type="integer", format="int64", example=1)
        *  )
     * ),
     *     @OA\Response(
     *     response=200,
     *     description="Retorna el comentari actualitzat",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Comentari")
        *  )
     * ),
     *     @OA\Response(
     *     response=404,
     *     description="Comentari no trobat",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Comentari")
     * )
     * )
     * )
     */
    public function update(Request $request, $id)
    {
        $reglesvalidacio = [
            'ID_COMENTARI' => 'required',
            'DESCRIPCIO' => 'required|max:255',
            'HORA' => 'required|date_format:H:i:s',
            'DATA' => 'required|date_format:Y-m-d',
            'FK_ID_USUARI' => 'required',
            'FK_ID_ALLOTJAMENT' => 'required'

        ];
        $missatges = [
            'ID_COMENTARI.required' => 'El camp ID_COMENTARI és obligatori',
            'DESCRIPCIO.required' => 'El camp DESCRIPCIO és obligatori',
            'DESCRIPCIO.max' => 'El camp DESCRIPCIO no pot tenir més de 255 caràcters',
            'HORA.required' => 'El camp HORA és obligatori',
            'HORA.date_format' => 'El camp HORA no té el format correcte',
            'DATA.required' => 'El camp DATA és obligatori',
            'DATA.date_format' => 'El camp DATA no té el format correcte',
            'FK_ID_USUARI.required' => 'El camp FK_ID_USUARI és obligatori',
            'FK_ID_ALLOTJAMENT.required' => 'El camp FK_ID_ALLOTJAMENT és obligatori'
        ];
        $validator = Validator::make($request->all(), $reglesvalidacio, $missatges);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        } else {
            try {
                $comentaris = Comentari::findOrFail($id);
                $comentaris->ID_COMENTARI = $request->input('ID_COMENTARI');
                $comentaris->DESCRIPCIO = $request->input('DESCRIPCIO');
                $comentaris->HORA = $request->input('HORA');
                $comentaris->DATA = $request->input('DATA');
                $comentaris->FK_ID_USUARI = $request->input('FK_ID_USUARI');
                $comentaris->FK_ID_ALLOTJAMENT = $request->input('FK_ID_ALLOTJAMENT');
                $comentaris->save();
                return response()->json(['status' => 'Comentari actualitzat correctament'], 200);
            } catch (ModelNotFoundException $e) {
                return response()->json(['error' => 'Comentari no trobat'], 404);
            }
        }
    }

    /**
     * @OA\Delete(
     *     path="/comentaris/destroy/{id}",
     *     operationId="deleteComentari",
     *     tags={"Comentaris"},
     *     security={{"bearerAuth":{}}},
     *     summary="Elimina un comentari",
     *     description="Elimina un comentari",
     *     @OA\Parameter(
     *     name="id",
     *     description="Comentari id",
     *     required=true,
     *     in="path",
     *     @OA\Schema(
     *     type="integer"
        *  )
     * ),
     *     @OA\Response(
     *     response=200,
     *     description="Comentari eliminat correctament",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Comentari")
        *  )
     * ),
     *     @OA\Response(
     *     response=404,
     *     description="Comentari no trobat",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Comentari")
     * )
     * )
     *     )
     */
    public function destroy($id)
    {
        try {
            $comentaris = Comentari::findOrFail($id);
            $comentaris->delete();
            return response()->json(['status' => 'Comentari eliminat correctament'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Comentari no trobat'], 404);
        }
    }
}
