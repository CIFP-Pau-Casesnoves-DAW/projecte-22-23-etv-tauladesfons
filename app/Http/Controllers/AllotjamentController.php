<?php

namespace App\Http\Controllers;

use App\Models\Allotjament;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;

/** @OA\Tag (
 *     name="Allotjaments"
 * )
 */

class AllotjamentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @OA\Get (
     *     path="/allotjaments",
     *     summary="Llista d'allotjaments",
     *     tags={"Allotjaments"},
     *     @OA\Response (
     *     response=200,
     *     description="Llista d'allotjaments",
     *     @OA\JsonContent (
     *     type="array",
     *     @OA\Items (ref="#/components/schemas/Allotjament")
     *   )
     * )
     * )
     * @OA\Schema (
     *     schema="Allotjament",
     *     type="object",
     *     @OA\Property (property="ID_ALLOTJAMENT", type="integer"),
     *     @OA\Property (property="NOM_COMERCIAL", type="string"),
     *     @OA\Property (property="NUM_REGISTRE", type="string"),
     *     @OA\Property (property="DESCRIPCIO", type="string"),
     *     @OA\Property (property="LLITS", type="integer"),
     *     @OA\Property (property="PERSONES", type="integer"),
     *     @OA\Property (property="BANYS", type="integer"),
     *     @OA\Property (property="ADREÇA", type="string"),
     *     @OA\Property (property="DESTACAT", type="boolean"),
     *     @OA\Property (property="VALORACIO_GLOBAL", type="number"),
     *     @OA\Property (property="FK_ID_MUNICIPI", type="integer"),
     *      @OA\Property (property="FK_ID_TIPUS", type="integer"),
     *     @OA\Property (property="FK_ID_VACANCES", type="integer"),
     *     @OA\Property (property="FK_ID_CATEGORIA", type="integer"),
     *     @OA\Property (property="FK_ID_USUARI", type="integer")
     * )
     *
     *
     *
     */
    public function index()
    {
        $tuples = Allotjament::all();
        return response()->json($tuples);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Post (
     *     path="/allotjaments",
     *     summary="Crea un allotjament",
     *     tags={"Allotjaments"},
     *     @OA\RequestBody (
     *     required=true,
     *     description="Dades de l'allotjament",
     *     @OA\JsonContent (
     *     ref="#/components/schemas/Allotjament"
     *   )
     * ),
     *     @OA\Response (
     *     response=200,
     *     description="Allotjament creat",
     *     @OA\JsonContent (
     *     ref="#/components/schemas/Allotjament"
     *   )
     * ),
     *     @OA\Response (
     *     response=400,
     *     description="Error de validació",
     *     @OA\JsonContent (
     *     ref="#/components/schemas/Error"
     *  )
     * )
     * )
     */
    public function store(Request $request)
    {

        $reglesvalidacio = [
            'ID_ALLOTJAMENT' => 'required|integer',
            'NOM_COMERCIAL' => 'required|string|max:50',
            'NUM_REGISTRE' => 'required|string|max:50',
            'DESCRIPCIO' => 'required|string|max:500',
            'LLITS' => 'required|integer',
            'PERSONES' => 'required|integer',
            'BANYS' => 'required|integer',
            'ADREÇA' => 'required|string|max:50',
            'DESTACAT' => 'required|boolean',
            'VALORACIO_GLOBAL' => 'required|integer',
            'FK_ID_MUNICIPI' => 'required|integer',
            'FK_ID_TIPUS' => 'required|integer',
            'FK_ID_VACANCES' => 'required|integer',
            'FK_ID_CATEGORIA' => 'required|integer',
            'FK_ID_USUARI' => 'required|integer',
        ];
        $missatges = [
            'ID_ALLOTJAMENT.required' => 'El camp ID_ALLOTJAMENT és obligatori.',
            'ID_ALLOTJAMENT.integer' => 'El camp ID_ALLOTJAMENT ha de ser un número enter.',
            'NOM_COMERCIAL.required' => 'El camp NOM_COMERCIAL és obligatori.',
            'NOM_COMERCIAL.string' => 'El camp NOM_COMERCIAL ha de ser una cadena de caràcters.',
            'NOM_COMERCIAL.max' => 'El camp NOM_COMERCIAL no pot tenir més de 50 caràcters.',
            'NUM_REGISTRE.required' => 'El camp NUM_REGISTRE és obligatori.',
            'NUM_REGISTRE.string' => 'El camp NUM_REGISTRE ha de ser una cadena de caràcters.',
            'NUM_REGISTRE.max' => 'El camp NUM_REGISTRE no pot tenir més de 50 caràcters.',
            'DESCRIPCIO.required' => 'El camp DESCRIPCIO és obligatori.',
            'DESCRIPCIO.string' => 'El camp DESCRIPCIO ha de ser una cadena de caràcters.',
            'DESCRIPCIO.max' => 'El camp DESCRIPCIO no pot tenir més de 500 caràcters.',
            'LLITS.required' => 'El camp LLITS és obligatori.',
            'LLITS.integer' => 'El camp LLITS ha de ser un número enter.',
            'PERSONES.required' => 'El camp PERSONES és obligatori.',
            'PERSONES.integer' => 'El camp PERSONES ha de ser un número enter.',
            'BANYS.required' => 'El camp BANYS és obligatori.',
            'BANYS.integer' => 'El camp BANYS ha de ser un número enter.',
            'ADREÇA.required' => 'El camp ADRECA és obligatori.',
            'ADREÇA.string' => 'El camp ADRECA ha de ser una cadena de caràcters.',
            'ADREÇA.max' => ' El camp ADRECA no pot tenir més de 50 caràcters.',
            'DESTACAT.required' => 'El camp DESTACAT és obligatori.',
            'DESTACAT.boolean' => 'El camp DESTACAT ha de ser un booleà.',
            'VALORACIO_GLOBAL.required' => 'El camp VALORACIO_GLOBAL és obligatori.',
            'VALORACIO_GLOBAL.integer' => 'El camp VALORACIO_GLOBAL ha de ser un número enter.',
            'FK_ID_MUNICIPI.required' => 'El camp FK_ID_MUNICIPI és obligatori.',
            'FK_ID_MUNICIPI.integer' => 'El camp FK_ID_MUNICIPI ha de ser un número enter.',
            'FK_ID_TIPUS.required' => 'El camp FK_ID_TIPUS és obligatori.',
            'FK_ID_TIPUS.integer' => 'El camp FK_ID_TIPUS ha de ser un número enter.',
            'FK_ID_VACANCES.required' => 'El camp FK_ID_VACANCES és obligatori.',
            'FK_ID_VACANCES.integer' => 'El camp FK_ID_VACANCES ha de ser un número enter.',
            'FK_ID_CATEGORIA.required' => 'El camp FK_ID_CATEGORIA és obligatori.',
            'FK_ID_CATEGORIA.integer' => 'El camp FK_ID_CATEGORIA ha de ser un número enter.',
            'FK_ID_USUARI.required' => 'El camp FK_ID_USUARI és obligatori.',
            'FK_ID_USUARI.integer' => 'El camp FK_ID_USUARI ha de ser un número enter.',
        ];
        $validacio = Validator::make($request->all(), $reglesvalidacio, $missatges);
        if ($validacio->fails()) {
            return response()->json($validacio->errors(), 400);
        } else {
            $allotjament = new Allotjament();
            $allotjament->ID_ALLOTJAMENT = $request->input('ID_ALLOTJAMENT');
            $allotjament->NOM_COMERCIAL = $request->input('NOM_COMERCIAL');
            $allotjament->NUM_REGISTRE = $request->input('NUM_REGISTRE');
            $allotjament->DESCRIPCIO = $request->input('DESCRIPCIO');
            $allotjament->LLITS = $request->input('LLITS');
            $allotjament->PERSONES = $request->input('PERSONES');
            $allotjament->BANYS = $request->input('BANYS');
            $allotjament->ADREÇA = $request->input('ADREÇA');
            $allotjament->DESTACAT = $request->input('DESTACAT');
            $allotjament->VALORACIO_GLOBAL = $request->input('VALORACIO_GLOBAL');
            $allotjament->FK_ID_MUNICIPI = $request->input('FK_ID_MUNICIPI');
            $allotjament->FK_ID_TIPUS = $request->input('FK_ID_TIPUS');
            $allotjament->FK_ID_VACANCES = $request->input('FK_ID_VACANCES');
            $allotjament->FK_ID_CATEGORIA = $request->input('FK_ID_CATEGORIA');
            $allotjament->FK_ID_USUARI = $request->input('FK_ID_USUARI');
            $allotjament->save();
            return response()->json($allotjament, 200);
        }

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/allotjaments/{id}",
     *     summary="Mostra un allotjament",
     *     description="Mostra un allotjament",
     *     tags={"Allotjaments"},
     *     @OA\Parameter(
     *     description="ID de l'allotjament",
     *     in="path",
     *     name="id",
     *     required=true,
     *     @OA\Schema(
     *         type="integer",
     *         format="int64"
     *     )
     * ),
     * @OA\Response(
     *     response=200,
     *     description="Mostra l'allotjament",
     *     @OA\JsonContent(
     *         @OA\Property(
     *             property="ID_ALLOTJAMENT",
     *             type="integer",
     *             example="1"
     *         ),
     *         @OA\Property(
     *             property="NOM_COMERCIAL",
     *             type="string",
     *             example="Hotel"
     *         ),
     *         @OA\Property(
     *             property="NUM_REGISTRE",
     *             type="string",
     *             example="123456789"
     *         ),
     *         @OA\Property(
     *             property="DESCRIPCIO",
     *             type="string",
     *             example="Hotel de 5 estrelles"
     *         ),
     *         @OA\Property(
     *             property="LLITS",
     *             type="integer",
     *             example="5"
     *         ),
     *         @OA\Property(
     *             property="PERSONES",
     *             type="integer",
     *             example="5"
     *         ),
     *         @OA\Property(
     *             property="BANYS",
     *             type="integer",
     *             example="5"
     *         ),
     *         @OA\Property(
     *             property="ADREÇA",
     *             type="string",
     *             example="Carrer de l'hotel, 1"
     *         ),
     *         @OA\Property(
     *             property="DESTACAT",
     *        type="integer",
     *        example="1"
     *        ),
     *     @OA\Property(
     *        property="VALORACIO_GLOBAL",
     *     type="integer",
     *     example="5"
     *    ),
     *     @OA\Property(
     *     property="FK_ID_MUNICIPI",
     *     type="integer",
     *     example="1"
     *   ),
     *     @OA\Property(
     *     property="FK_ID_TIPUS",
     *     type="integer",
     *     example="1"
     *  ),
     *     @OA\Property(
     *     property="FK_ID_VACANCES",
     *     type="integer",
     *     example="1"
     * ),
     *     @OA\Property(
     *     property="FK_ID_CATEGORIA",
     *     type="integer",
     *     example="1"
     * ),
     *     @OA\Property(
     *     property="FK_ID_USUARI",
     *     type="integer",
     *     example="1"
     * )
     * )
     *    )
     * )
     * )
    */
    public function show($id)
    {
        try {
            $allotjaments = Allotjament::findOrFail($id);
            return response()->json($allotjaments);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'No s\'ha trobat l\'allotjament'], 404);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    /**
     * @OA\Put(
     *     path="/allotjaments/put/{id}",
     *     summary="Actualitza un allotjament",
     *     description="Actualitza un allotjament",
     *     tags={"Allotjaments"},
     *     @OA\Parameter(
     *     description="ID de l'allotjament",
     *     in="path",
     *     name="id",
     *     required=true,
     *     @OA\Schema(
     *         type="integer",
     *         format="int64"
     *     )
     * ),
     * @OA\RequestBody(
     *    required=true,
     *    description="Dades allotjament",
     *    @OA\JsonContent(
     *       required={"ID_ALLOTJAMENT","NOM_COMERCIAL","NUM_REGISTRE","DESCRIPCIO","LLITS","PERSONES","BANYS","ADREÇA","DESTACAT","VALORACIO_GLOBAL","FK_ID_MUNICIPI","FK_ID_TIPUS","FK_ID_VACANCES","FK_ID_CATEGORIA","FK_ID_USUARI"},
     *       @OA\Property(
     *        property="ID_ALLOTJAMENT",
     *        type="integer",
     *        example="1"
     *       ),
     *       @OA\Property(
     *        property="NOM_COMERCIAL",
     *        type="string",
     *        example="Hotel"
     *       ),
     *       @OA\Property(
     *        property="NUM_REGISTRE",
     *        type="string",
     *        example="123456789"
     *       ),
     *       @OA\Property(
     *        property="DESCRIPCIO",
     *        type="string",
     *        example="Hotel de 5 estrelles"
     *       ),
     *       @OA\Property(
     *        property="LLITS",
     *        type="integer",
     *        example="5"
     *       ),
     *       @OA\Property(
     *        property="PERSONES",
     *        type="integer",
     *        example="5"
     *       ),
     *       @OA\Property(
     *        property="BANYS",
     *        type="integer",
     *        example="5"
     *       ),
     *       @OA\Property(
     *        property="ADREÇA",
     *        type="string",
     *        example="Carrer de l'hotel, 1"
     *       ),
     *       @OA\Property(
     *        property="DESTACAT",
     *        type="integer",
     *        example="1"
     *       ),
     *       @OA\Property(
     *        property="VALORACIO_GLOBAL",
     *        type="integer",
     *        example="5"
     *       ),
     *       @OA\Property(
     *        property="FK_ID_MUNICIPI",
     *        type="integer",
     *        example="1"
     *       ),
     *       @OA\Property(
     *        property="FK_ID_TIPUS",
     *        type="integer",
     *        example="1"
     *       ),
     *       @OA\Property(
     *        property="FK_ID_VACANCES",
     *        type="integer",
     *        example="1"
     *       ),
     *       @OA\Property(
     *        property="FK_ID_CATEGORIA",
     *        type="integer",
     *        example="1"
     *       ),
     *       @OA\Property(
     *        property="FK_ID_USUARI",
     *        type="integer",
     *        example="1"
     *       ),
     *    )
     * ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No s'ha trobat l'allotjament"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $regles = [
            'ID_ALLOTJAMENT' => 'required|integer',
            'NOM_COMERCIAL' => 'required|string|max:50',
            'NUM_REGISTRE' => 'required|string|max:50',
            'DESCRIPCIO' => 'required|string|max:500',
            'LLITS' => 'required|integer',
            'PERSONES' => 'required|integer',
            'BANYS' => 'required|integer',
            'ADREÇA' => 'required|string|max:50',
            'DESTACAT' => 'required|boolean',
            'VALORACIO_GLOBAL' => 'required|integer',
            'FK_ID_MUNICIPI' => 'required|integer',
            'FK_ID_TIPUS' => 'required|integer',
            'FK_ID_VACANCES' => 'required|integer',
            'FK_ID_CATEGORIA' => 'required|integer',
            'FK_ID_USUARI' => 'required|integer'
        ];
        $missatges = [
            'ID_ALLOTJAMENT.required' => 'El camp ID_ALLOTJAMENT és obligatori.',
            'ID_ALLOTJAMENT.integer' => 'El camp ID_ALLOTJAMENT ha de ser un número enter.',
            'NOM_COMERCIAL.required' => 'El camp NOM_COMERCIAL és obligatori.',
            'NOM_COMERCIAL.string' => 'El camp NOM_COMERCIAL ha de ser una cadena de text.',
            'NOM_COMERCIAL.max' => 'El camp NOM_COMERCIAL no pot tenir més de 50 caràcters.',
            'NUM_REGISTRE.required' => 'El camp NUM_REGISTRE és obligatori.',
            'NUM_REGISTRE.string' => 'El camp NUM_REGISTRE ha de ser una cadena de text.',
            'NUM_REGISTRE.max' => 'El camp NUM_REGISTRE no pot tenir més de 50 caràcters.',
            'DESCRIPCIO.required' => 'El camp DESCRIPCIO és obligatori.',
            'DESCRIPCIO.string' => 'El camp DESCRIPCIO ha de ser una cadena de text.',
            'DESCRIPCIO.max' => 'El camp DESCRIPCIO no pot tenir més de 500 caràcters.',
            'LLITS.required' => 'El camp LLITS és obligatori.',
            'LLITS.integer' => 'El camp LLITS ha de ser un número enter.',
            'PERSONES.required' => 'El camp PERSONES és obligatori.',
            'PERSONES.integer' => 'El camp PERSONES ha de ser un número enter.',
            'BANYS.required' => 'El camp BANYS és obligatori.',
            'BANYS.integer' => 'El camp BANYS ha de ser un número enter.',
            'ADREÇA.required' => 'El camp ADREÇA és obligatori.',
            'ADREÇA.string' => 'El camp ADREÇA ha de ser una cadena de text.',
            'ADREÇA.max' => 'El camp ADREÇA no pot tenir més de 50 caràcters.',
            'DESTACAT.required' => 'El camp DESTACAT és obligatori.',
            'DESTACAT.boolean' => 'El camp DESTACAT ha de ser un booleà.',
            'VALORACIO_GLOBAL.required' => 'El camp VALORACIO_GLOBAL és obligatori.',
            'VALORACIO_GLOBAL.integer' => 'El camp VALORACIO_GLOBAL ha de ser un número enter.',
            'FK_ID_MUNICIPI.required' => 'El camp FK_ID_MUNICIPI és obligatori.',
            'FK_ID_MUNICIPI.integer' => 'El camp FK_ID_MUNICIPI ha de ser un número enter.',
            'FK_ID_TIPUS.required' => 'El camp FK_ID_TIPUS és obligatori.',
            'FK_ID_TIPUS.integer' => 'El camp FK_ID_TIPUS ha de ser un número enter.',
            'FK_ID_VACANCES.required' => 'El camp FK_ID_VACANCES és obligatori.',
            'FK_ID_VACANCES.integer' => 'El camp FK_ID_VACANCES ha de ser un número enter.',
            'FK_ID_CATEGORIA.required' => 'El camp FK_ID_CATEGORIA és obligatori.',
            'FK_ID_CATEGORIA.integer' => 'El camp FK_ID_CATEGORIA ha de ser un número enter.',
            'FK_ID_USUARI.required' => 'El camp FK_ID_USUARI és obligatori.',
            'FK_ID_USUARI.integer' => 'El camp FK_ID_USUARI ha de ser un número enter.',
        ];
       $validacio = Validator::make($request->all(), $regles, $missatges);
        if ($validacio->fails()) {
            return response()->json($validacio->errors(), 400);
        }
        $allotjament = Allotjament::find($id);
        if ($allotjament == null) {
            return response()->json(['error' => 'No s\'ha trobat l\'allotjament'], 404);
        }
        $allotjament->update($request->all());
        return response()->json($allotjament, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
        */
    /**
     * @OA\Delete(
     *   path="/allotjaments/destroy/{id}",
     *   summary="Elimina un allotjament",
     *   tags={"Allotjaments"},
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Id de l'allotjament",
     *     required=true,
     *     @OA\Schema(
     *       type="integer",
     *       format="int64"
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Allotjament eliminat correctament",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="success",
     *         type="string",
     *         example="Allotjament eliminat correctament"
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=404,
     *     description="No s'ha trobat l'allotjament",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="error",
     *         type="string",
     *         example="No s'ha trobat l'allotjament"
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=500,
     *     description="No s'ha pogut eliminar l'allotjament",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="error",
     *         type="string",
     *         example="No s'ha pogut eliminar l'allotjament"
     *       ),
     *     ),
     *   ),
     * )
     */
    public function destroy($id)
    {
        try {
            $tuples = Allotjament::FindOrFail($id);
            $tuples->delete();
            return response()->json([
                'success' => 'Allotjament eliminat correctament'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'No s\'ha pogut eliminar l\'allotjament'
            ]);
             }
    }
}
