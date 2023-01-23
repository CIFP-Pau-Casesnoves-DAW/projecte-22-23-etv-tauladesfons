<?php

namespace App\Http\Controllers;

use App\Models\Allotjament;
use Exception;
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
     *     @OA\Property (property="NUM_REGISTRE", type="integer"),
     *     @OA\Property (property="DESCRIPCIO", type="string"),
     *     @OA\Property (property="LLITS", type="integer"),
     *     @OA\Property (property="PERSONES", type="integer"),
     *     @OA\Property (property="BANYS", type="integer"),
     *     @OA\Property (property="FOTOGRAFIES", type="string"),
     *     @OA\Property (property="ADRECA", type="string"),
     *     @OA\Property (property="DESTACAT", type="boolean"),
     *     @OA\Property (property="VALORACIO_GLOBAL", type="number"),
     *     @OA\Property (property="FK_ID_MUNICIPI", type="integer"),
     *      @OA\Property (property="FK_ID_TIPUS", type="integer"),
     *     @OA\Property (property="FK_ID_SERVEI", type="integer"),
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
            'NOM_COMERCIAL' => 'required|string|max:255',
            'NUM_REGISTRE' => 'required|integer',
            'DESCRIPCIO' => 'required|string|max:255',
            'LLITS' => 'required|integer',
            'PERSONES' => 'required|integer',
            'BANYS' => 'required|integer',
            'FOTOGRAFIES' => 'required|string|max:255',
            'ADRECA' => 'required|string|max:255',
            'DESTACAT' => 'required|boolean',
            'VALORACIO_GLOBAL' => 'required|integer',
            'FK_ID_MUNICIPI' => 'required|integer',
            'FK_ID_TIPUS' => 'required|integer',
            'FK_ID_SERVEI' => 'required|integer',
            'FK_ID_VACANCES' => 'required|integer',
            'FK_ID_CATEGORIA' => 'required|integer',
            'FK_ID_USUARI' => 'required|integer',
        ];
        $missatges = [
            'ID_ALLOTJAMENT.required' => 'El camp ID_ALLOTJAMENT és obligatori.',
            'ID_ALLOTJAMENT.integer' => 'El camp ID_ALLOTJAMENT ha de ser un número enter.',
            'NOM_COMERCIAL.required' => 'El camp NOM_COMERCIAL és obligatori.',
            'NOM_COMERCIAL.string' => 'El camp NOM_COMERCIAL ha de ser una cadena de caràcters.',
            'NOM_COMERCIAL.max' => 'El camp NOM_COMERCIAL no pot tenir més de 255 caràcters.',
            'NUM_REGISTRE.required' => 'El camp NUM_REGISTRE és obligatori.',
            'NUM_REGISTRE.integer' => 'El camp NUM_REGISTRE ha de ser un número enter.',
            'DESCRIPCIO.required' => 'El camp DESCRIPCIO és obligatori.',
            'DESCRIPCIO.string' => 'El camp DESCRIPCIO ha de ser una cadena de caràcters.',
            'DESCRIPCIO.max' => 'El camp DESCRIPCIO no pot tenir més de 255 caràcters.',
            'LLITS.required' => 'El camp LLITS és obligatori.',
            'LLITS.integer' => 'El camp LLITS ha de ser un número enter.',
            'PERSONES.required' => 'El camp PERSONES és obligatori.',
            'PERSONES.integer' => 'El camp PERSONES ha de ser un número enter.',
            'BANYS.required' => 'El camp BANYS és obligatori.',
            'BANYS.integer' => 'El camp BANYS ha de ser un número enter.',
            'FOTOGRAFIES.required' => 'El camp FOTOGRAFIES és obligatori.',
            'FOTOGRAFIES.string' => 'El camp FOTOGRAFIES ha de ser una cadena de caràcters.',
            'FOTOGRAFIES.max' => 'El camp FOTOGRAFIES no pot tenir més de 255 caràcters.',
            'ADRECA.required' => 'El camp ADRECA és obligatori.',
            'ADRECA.string' => 'El camp ADRECA ha de ser una cadena de caràcters.',
            'ADRECA.max' => ' El camp ADRECA no pot tenir més de 255 caràcters.',
            'DESTACAT.required' => 'El camp DESTACAT és obligatori.',
            'DESTACAT.boolean' => 'El camp DESTACAT ha de ser un booleà.',
            'VALORACIO_GLOBAL.required' => 'El camp VALORACIO_GLOBAL és obligatori.',
            'VALORACIO_GLOBAL.integer' => 'El camp VALORACIO_GLOBAL ha de ser un número enter.',
            'FK_ID_MUNICIPI.required' => 'El camp FK_ID_MUNICIPI és obligatori.',
            'FK_ID_MUNICIPI.integer' => 'El camp FK_ID_MUNICIPI ha de ser un número enter.',
            'FK_ID_TIPUS.required' => 'El camp FK_ID_TIPUS és obligatori.',
            'FK_ID_TIPUS.integer' => 'El camp FK_ID_TIPUS ha de ser un número enter.',
            'FK_ID_SERVEI.required' => 'El camp FK_ID_SERVEI és obligatori.',
            'FK_ID_SERVEI.integer' => 'El camp FK_ID_SERVEI ha de ser un número enter.',
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
            $allotjament->FOTOGRAFIES = $request->input('FOTOGRAFIES');
            $allotjament->ADRECA = $request->input('ADRECA');
            $allotjament->DESTACAT = $request->input('DESTACAT');
            $allotjament->VALORACIO_GLOBAL = $request->input('VALORACIO_GLOBAL');
            $allotjament->FK_ID_MUNICIPI = $request->input('FK_ID_MUNICIPI');
            $allotjament->FK_ID_TIPUS = $request->input('FK_ID_TIPUS');
            $allotjament->FK_ID_SERVEI = $request->input('FK_ID_SERVEI');
            $allotjament->FK_ID_VACANCES = $request->input('FK_ID_VACANCES');
            $allotjament->FK_ID_CATEGORIA = $request->input('FK_ID_CATEGORIA');
            $allotjament->FK_ID_USUARI = $request->input('FK_ID_USUARI');
            $allotjament->save();
            return response()->json($allotjament, 201);
        }

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     * @OA\Get(
     *      path="/allotjaments/{id}",
     *     summary="Mostra un allotjament",
     *     description="Mostra un allotjament",
     *     tags={"Allotjaments"},
     *     @OA\Parameter(
     *     description="ID de l'allotjament",
     *     in="path",
     *     name="id",
     *     required=true
     *   ),
     *     @OA\Response(
     *     response=200,
     *     description="Mostra un allotjament",
     *     @OA\JsonContent(
     *     @OA\Property(property="ID_ALLOTJAMENT", type="integer"),
     *     @OA\Property(property="NOM_COMERCIAL", type="string"),
     *     @OA\Property(property="NUM_REGISTRE", type="string"),
     *     @OA\Property(property="DESCRIPCIO", type="string"),
     *     @OA\Property(property="LLITS", type="integer"),
     *     @OA\Property(property="PERSONES", type="integer"),
     *     @OA\Property(property="BANYS", type="integer"),
     *     @OA\Property(property="FOTOGRAFIES", type="string"),
     *     @OA\Property(property="ADRECA", type="string"),
     *     @OA\Property(property="DESTACAT", type="integer"),
     *     @OA\Property(property="VALORACIO_GLOBAL", type="integer"),
     *     @OA\Property(property="FK_ID_MUNICIPI", type="integer"),
     *     @OA\Property(property="FK_ID_TIPUS", type="integer"),
     *     @OA\Property(property="FK_ID_SERVEI", type="integer"),
     *     @OA\Property(property="FK_ID_VACANCES", type="integer"),
     *     @OA\Property(property="FK_ID_CATEGORIA", type="integer"),
     *     @OA\Property(property="FK_ID_USUARI", type="integer"),
     *     ),
     *     )
     *
     *
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Put(
     *     path="/allotjaments/put/{id}",
     *     summary="Actualitza un allotjament",
     *     description="Actualitza un allotjament",
     *     tags={"Allotjaments"},
     *     @OA\Parameter(
     *     description="ID de l'allotjament",
     *     in="path",
     *     name="id",
     *     required=true
     *     ),
     *     @OA\RequestBody(
     *     description="Dades de l'allotjament",
     *     required=true,
     *     @OA\JsonContent(
     *     @OA\Property(property="ID_ALLOTJAMENT", type="integer"),
     *     @OA\Property(property="NOM_COMERCIAL", type="string"),
     *     @OA\Property(property="NUM_REGISTRE", type="integer"),
     *     @OA\Property(property="DESCRIPCIO", type="string"),
     *     @OA\Property(property="LLITS", type="integer"),
     *     @OA\Property(property="PERSONES", type="integer"),
     *     @OA\Property(property="BANYS", type="integer"),
     *     @OA\Property(property="FOTOGRAFIES", type="string"),
     *     @OA\Property(property="ADRECA", type="string"),
     *     @OA\Property(property="DESTACAT", type="boolean"),
     *     @OA\Property(property="VALORACIO_GLOBAL", type="integer"),
     *     @OA\Property(property="FK_ID_MUNICIPI", type="integer"),
     *     @OA\Property(property="FK_ID_TIPUS", type="integer"),
     *     @OA\Property(property="FK_ID_SERVEI", type="integer"),
     *     @OA\Property(property="FK_ID_VACANCES", type="integer"),
     *     @OA\Property(property="FK_ID_CATEGORIA", type="integer"),
     *     @OA\Property(property="FK_ID_USUARI", type="integer"),
     *     ),
     *     ),
     *     @OA\Response(
     *     response=200,
     *     description="Actualitza un allotjament",
     *     @OA\JsonContent(
     *     @OA\Property(property="ID_ALLOTJAMENT", type="integer"),
     *     @OA\Property(property="NOM_COMERCIAL", type="string"),
     *     @OA\Property(property="NUM_REGISTRE", type="integer"),
     *     @OA\Property(property="DESCRIPCIO", type="string"),
     *     @OA\Property(property="LLITS", type="integer"),
     *     @OA\Property(property="PERSONES", type="integer"),
     *     @OA\Property(property="BANYS", type="integer"),
     *     @OA\Property(property="FOTOGRAFIES", type="string"),
     *     @OA\Property(property="ADRECA", type="string"),
     *     @OA\Property(property="DESTACAT", type="integer"),
     *     @OA\Property(property="VALORACIO_GLOBAL", type="number"),
     *     @OA\Property(property="FK_ID_MUNICIPI", type="integer"),
     *     @OA\Property(property="FK_ID_TIPUS", type="integer"),
     *     @OA\Property(property="FK_ID_SERVEI", type="integer"),
     *     @OA\Property(property="FK_ID_VACANCES", type="integer"),
     *     @OA\Property(property="FK_ID_CATEGORIA", type="integer"),
     *     @OA\Property(property="FK_ID_USUARI", type="integer"),
     *     ),
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $reglesvalidacio = [
            'ID_ALLOTJAMENT' => 'required|integer',
            'NOM_COMERCIAL' => 'required|string|max:255',
            'NUM_REGISTRE' => 'required|string|max:255',
            'DESCRIPCIO' => 'required|string|max:255',
            'LLITS' => 'required|integer',
            'PERSONES' => 'required|integer',
            'BANYS' => 'required|integer',
            'FOTOGRAFIES' => 'required|string|max:255',
            'ADRECA' => 'required|string|max:255',
            'DESTACAT' => 'required|integer',
            'VALORACIO_GLOBAL' => 'required|integer',
            'FK_ID_MUNICIPI' => 'required|integer',
            'FK_ID_TIPUS' => 'required|integer',
            'FK_ID_SERVEI' => 'required|integer',
            'FK_ID_VACANCES' => 'required|integer',
            'FK_ID_CATEGORIA' => 'required|integer',
            'FK_ID_USUARI' => 'required|integer',
        ];
        $missatges = [
            'ID_ALLOTJAMENT.required' => 'El camp ID_ALLOTJAMENT és obligatori.',
            'ID_ALLOTJAMENT.integer' => 'El camp ID_ALLOTJAMENT ha de ser un número enter.',
            'NOM_COMERCIAL.required' => 'El camp NOM_COMERCIAL és obligatori.',
            'NOM_COMERCIAL.string' => 'El camp NOM_COMERCIAL ha de ser una cadena de text.',
            'NOM_COMERCIAL.max' => 'El camp NOM_COMERCIAL no pot tenir més de 255 caràcters.',
            'NUM_REGISTRE.required' => 'El camp NUM_REGISTRE és obligatori.',
            'NUM_REGISTRE.string' => 'El camp NUM_REGISTRE ha de ser una cadena de text.',
            'NUM_REGISTRE.max' => 'El camp NUM_REGISTRE no pot tenir més de 255 caràcters.',
            'DESCRIPCIO.required' => 'El camp DESCRIPCIO és obligatori.',
            'DESCRIPCIO.string' => 'El camp DESCRIPCIO ha de ser una cadena de text.',
            'DESCRIPCIO.max' => 'El camp DESCRIPCIO no pot tenir més de 255 caràcters.',
            'LLITS.required' => 'El camp LLITS és obligatori.',
            'LLITS.integer' => 'El camp LLITS ha de ser un número enter.',
            'PERSONES.required' => 'El camp PERSONES és obligatori.',
            'PERSONES.integer' => 'El camp PERSONES ha de ser un número enter.',
            'BANYS.required' => 'El camp BANYS és obligatori.',
            'BANYS.integer' => 'El camp BANYS ha de ser un número enter.',
            'FOTOGRAFIES.required' => 'El camp FOTOGRAFIES és obligatori.',
            'FOTOGRAFIES.string' => 'El camp FOTOGRAFIES ha de ser una cadena de text.',
            'FOTOGRAFIES.max' => 'El camp FOTOGRAFIES no pot tenir més de 255 caràcters.',
            'ADRECA.required' => 'El camp ADRECA és obligatori.',
            'ADRECA.string' => 'El camp ADRECA ha de ser una cadena de text.',
            'ADRECA.max' => 'El camp ADRECA no pot tenir més de 255 caràcters.',
            'DESTACAT.required' => 'El camp DESTACAT és obligatori.',
            'DESTACAT.boolean' => 'El camp DESTACAT ha de ser un booleà.',
            'VALORACIO_GLOBAL.required' => 'El camp VALORACIO_GLOBAL és obligatori.',
            'VALORACIO_GLOBAL.integer' => 'El camp VALORACIO_GLOBAL ha de ser un número enter.',
            'FK_ID_MUNICIPI.required' => 'El camp FK_ID_MUNICIPI és obligatori.',
            'FK_ID_MUNICIPI.integer' => 'El camp FK_ID_MUNICIPI ha de ser un número enter.',
            'FK_ID_TIPUS.required' => 'El camp FK_ID_TIPUS és obligatori.',
            'FK_ID_TIPUS.integer' => 'El camp FK_ID_TIPUS ha de ser un número enter.',
            'FK_ID_SERVEI.required' => 'El camp FK_ID_SERVEI és obligatori.',
            'FK_ID_SERVEI.integer' => 'El camp FK_ID_SERVEI ha de ser un número enter.',
            'FK_ID_VACANCES.required' => 'El camp FK_ID_VACANCES és obligatori.',
            'FK_ID_VACANCES.integer' => 'El camp FK_ID_VACANCES ha de ser un número enter.',
            'FK_ID_CATEGORIA.required' => 'El camp FK_ID_CATEGORIA és obligatori.',
            'FK_ID_CATEGORIA.integer' => 'El camp FK_ID_CATEGORIA ha de ser un número enter.',
            'FK_ID_USUARI.required' => 'El camp FK_ID_USUARI és obligatori.',
            'FK_ID_USUARI.integer' => 'El camp FK_ID_USUARI ha de ser un número enter.',
        ];
       $validacio = Validator::make($request->all(), $reglesvalidacio, $missatges);
        $tuples=Allotjament::where('ID_ALLOTJAMENT', $id)->update($request->except(['_token']));
        if ($validacio->fails()) {
            return response()->json([
                'error' => $validacio->errors()->all()
            ]);
         } else {
            return response()->json([
                'success' => 'Allotjament modificat correctament'
            ]);
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Delete(
     *     path="/allojaments/destroy/{id}",
     *     tags={"Allotjaments"},
     *     summary="Elimina un allotjament",
     *     description="Elimina un allotjament",
     *     @OA\Response(
     *     response=200,
     *     description="Allotjament eliminat correctament"
     * ),
     *     @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="ID de l'allotjament",
     *     required=true,
     *     @OA\Schema(
     *     type="integer"
     * )
     * ),
     *     @OA\Response(
     *     response=404,
     *     description="No s'ha pogut eliminar l'allotjament"
     * )
     * )
     *
     *
     *
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
