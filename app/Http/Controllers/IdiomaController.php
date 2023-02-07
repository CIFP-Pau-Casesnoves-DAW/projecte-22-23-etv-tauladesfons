<?php

namespace App\Http\Controllers;

use App\Models\Idioma;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;

/** @OA\Tag(name="Idiomes")*/
class IdiomaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/idiomes",
     *     summary="Llista de idiomes",
     *     tags={"Idiomes"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *     response=200,
     *     description="Llista de idiomes",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Idiomes")
     *    )
     *  )
     * )
     * @OA\Schema(
     *     schema="Idiomes",
     *     type="object",
     *     @OA\Property(property="ID_IDIOMA", type="integer"),
     *     @OA\Property(property="NOM_IDIOMA", type="string")
     * )
     */
    public function index()
    {
        $tuples = Idioma::all();

        // Return the list of languages to the client
        return response()->json([
            'status' => 'success',
            'data' => $tuples
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @OA\Post(
     *     path="/idiomes",
     *     summary="Crea un idioma",
     *     tags={"Idiomes"},
     *     @OA\RequestBody(
     *     description="Dades del nou idioma",
     *     required=true,
     *     @OA\JsonContent(ref="#/components/schemas/Idiomes")
     * ),
     *     @OA\Response(
     *     response=200,
     *     description="Idioma creat",
     *     @OA\JsonContent(ref="#/components/schemas/Idiomes")
     * ),
     *     @OA\Response(
     *     response=400,
     *     description="Error de validació",
     *     @OA\JsonContent(ref="#/components/schemas/Error")
     * )
     * )
     * @OA\Schema(
     *     schema="Error",
     *     type="object",
     *     @OA\Property(property="message", type="string"),
     *     @OA\Property(property="errors", type="object")
     * )
     */
    public function store(Request $request)
    {
       $reglesvalidacio=[
           'ID_IDIOMA' => 'required|integer',
              'NOM_IDIOMA' => 'required|string|max:50',
        ];
        $missatges=[
            'ID_IDIOMA.required' => 'El camp ID_IDIOMA és obligatori',
            'ID_IDIOMA.integer' => 'El camp ID_IDIOMA ha de ser un número enter',
            'NOM_IDIOMA.required' => 'El camp NOM_IDIOMA és obligatori',
            'NOM_IDIOMA.string' => 'El camp NOM_IDIOMA ha de ser una cadena de caràcters',
            'NOM_IDIOMA.max' => 'El camp NOM_IDIOMA no pot tenir més de 50 caràcters.'
        ];
        $validador = Validator::make($request->all(), $reglesvalidacio, $missatges);
        if ($validador->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validador->errors()->all()
            ], 400);
        }
        $tuple = new Idioma;
        $tuple->ID_IDIOMA = $request->input('ID_IDIOMA');
        $tuple->NOM_IDIOMA = strtoupper($request->input('NOM_IDIOMA'));
        $tuple->save();
        return response()->json([
            'status' => 'success',
            'data' => $tuple
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/idiomes/{id}",
     *     summary="Mostra un idioma",
     *     tags={"Idiomes"},
     *     @OA\Parameter(
     *     description="ID del idioma",
     *     in="path",
     *     name="id",
     *     required=true,
     *     @OA\Schema(
     *     type="integer"
     *   )
     * ),
     *     @OA\Response(
     *     response=200,
     *     description="Idioma",
     *     @OA\JsonContent(ref="#/components/schemas/Idiomes")
     * ),
     *     @OA\Response(
     *     response=404,
     *     description="No s'ha trobat cap idioma amb aquest ID",
     *     @OA\JsonContent(ref="#/components/schemas/Error")
     * )
     * )
     */
    public function show($id)
    {
        try {
            $tuples=Idioma::findOrFail($id);
            return response()->json(['status'=>'success', 'result' => $tuples],200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status'=>'error', 'result' => 'No s\'ha trobat cap idioma amb aquest ID'],404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Put(
     *     path="/idiomes/put/{id}",
     *     summary="Actualitza un idioma",
     *     tags={"Idiomes"},
     *     @OA\Parameter(
     *     description="ID del idioma",
     *     in="path",
     *     name="id",
     *     required=true,
     *     @OA\Schema(
     *     type="integer"
     *  )
     * ),
     *     @OA\RequestBody(
     *     description="Dades de l'idioma",
     *     required=true,
     *     @OA\JsonContent(ref="#/components/schemas/Idiomes")
     * ),
     *     @OA\Response(
     *     response=200,
     *     description="Idioma actualitzat",
     *     @OA\JsonContent(ref="#/components/schemas/Idiomes")
     * ),
     *     @OA\Response(
     *     response=400,
     *     description="Error de validació",
     *     @OA\JsonContent(ref="#/components/schemas/Error")
     * ),
     *     @OA\Response(
     *     response=404,
     *     description="No s'ha trobat cap idioma amb aquest ID",
     *     @OA\JsonContent(ref="#/components/schemas/Error")
     * )
     * )
     *
     */
    public function update(Request $request, $id)
    {
        try {
            $tuples = Idioma::findOrFail($id);
            $reglesValidacio = [
                'ID_IDIOMA' => 'required|integer',
                'NOM_IDIOMA' => 'required|string|max:50',
            ];
            $missatges = [
                'ID_IDIOMA.required' => 'El camp ID_IDIOMA és obligatori',
                'ID_IDIOMA.integer' => 'El camp ID_IDIOMA ha de ser un número enter',
                'NOM_IDIOMA.required' => 'El camp NOM_IDIOMA és obligatori',
                'NOM_IDIOMA.string' => 'El camp NOM_IDIOMA ha de ser una cadena de caràcters',
                'NOM_IDIOMA.max' => 'El camp NOM_IDIOMA no pot tenir més de 50 caràcters.'
            ];
            $validador = Validator::make($request->all(), $reglesValidacio, $missatges);
            if ($validador->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validador->errors()->all()
                ], 400);
            } else {
                $tuples->ID_IDIOMA = $request->input('ID_IDIOMA');
                $tuples->NOM_IDIOMA = strtoupper($request->input('NOM_IDIOMA'));
                $tuples->save();
                return response()->json([
                    'status' => 'success',
                    'data' => $tuples
                ], 200);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['status'=>'error', 'result' => 'No s\'ha trobat cap idioma amb aquest ID'],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Delete(
     *     path="/idiomes/destroy/{id}",
     *     summary="Elimina un idioma",
     *     tags={"Idiomes"},
     *     @OA\Parameter(
     *     description="ID del idioma",
     *     in="path",
     *     name="id",
     *     required=true,
     *     @OA\Schema(
     *     type="integer"
     * )
     * ),
     *     @OA\Response(
     *     response=200,
     *     description="Idioma eliminat",
     *     @OA\JsonContent(ref="#/components/schemas/Idiomes")
     * ),
     *     @OA\Response(
     *     response=404,
     *     description="No s'ha trobat cap idioma amb aquest ID",
     *     @OA\JsonContent(ref="#/components/schemas/Error")
     * )
     * )
     *
     */
    public function destroy($id)
    {
        try {
            $tuples=Idioma::findOrFail($id);
            $tuples->delete();
            return response()->json(['status'=>'success', 'result' => 'S\'ha eliminat l\'idioma correctament'],200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status'=>'error', 'result' => 'No s\'ha trobat cap idioma amb aquest ID'],404);
        }
    }
}
