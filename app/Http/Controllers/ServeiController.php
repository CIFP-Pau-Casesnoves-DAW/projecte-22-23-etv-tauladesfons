<?php

namespace App\Http\Controllers;

use App\Models\Servei;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;

/** @OA\Tag(
 *     name="Serveis"
 *
 * )
 */
class ServeiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/serveis",
     *     summary="Mostra tots els serveis",
     *     tags={"Serveis"},
     *     @OA\Response(
     *     response=200,
     *     description="Retorna tots els serveis",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Servei")
     *    )
     *  )
     * )
     * @OA\Schema(
     *     schema="Servei",
     *     type="object",
     *     @OA\Property(property="ID_SERVEI", type="integer"),
     *     @OA\Property(property="NOM_SERVEI", type="string")
     * )
     */
    public function index()
    {
        $tuples=Servei::all();
        return response()->json(['status'=>'success', 'result' => $tuples],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @OA\Post(
     *     path="/serveis",
     *     summary="Crea un nou servei",
     *     tags={"Serveis"},
     *     @OA\RequestBody(
     *     required=true,
     *     description="Dades del servei",
     *     @OA\JsonContent(
     *     required={"ID_SERVEI","NOM_SERVEI"},
     *     @OA\Property(property="ID_SERVEI", type="integer"),
     *     @OA\Property(property="NOM_SERVEI", type="string")
     *   )
     * ),
     *     @OA\Response(
     *     response=200,
     *     description="Servei creat",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Servei")
     *   )
     * ),
     *      @OA\Response(
     *     response=400,
     *     description="Error de creació",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Error")
     *  )
     * )
     * )
     */
    public function store(Request $request)
    {
        $reglesvalidacio = [
            'ID_SERVEI' => 'required|integer',
            'NOM_SERVEI' => 'required|string|max:50'
        ];
        $missatges = [
            'ID_SERVEI.required' => 'El camp ID_SERVEI és obligatori.',
            'ID_SERVEI.integer' => 'El camp ID_SERVEI ha de ser un número enter.',
            'NOM_SERVEI.required' => 'El camp NOM_SERVEI és obligatori.',
            'NOM_SERVEI.string' => 'El camp NOM_SERVEI ha de ser una cadena de caràcters.',
            'NOM_SERVEI.max' => 'El camp NOM_SERVEI no pot tenir més de 50 caràcters.'
        ];
        $validacio = Validator::make($request->all(), $reglesvalidacio, $missatges);
        if ($validacio->fails()) {
            return response()->json($validacio->errors(), 400);
        } else {
        $serveis= new Servei;
        $serveis->ID_SERVEI=$request->input('ID_SERVEI');
        $serveis->NOM_SERVEI=$request->input('NOM_SERVEI');
        $serveis->save();
        return response()->json(['status'=>'success','result'=>$serveis], 200);
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
     *     path="/serveis/{id}",
     *     summary="Mostra un servei",
     *     tags={"Serveis"},
     *     @OA\Parameter(
     *     description="ID del servei",
     *     in="path",
     *     name="id",
     *     required=true,
     *     @OA\Schema(
     *     type="integer"
     *   )
     * ),
     *     @OA\Response(
     *     response=200,
     *     description="Retorna el servei",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Servei")
     *   )
     * ),
     *      @OA\Response(
     *     response=404,
     *     description="Servei no trobat",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Error")
     *  )
     * )
     * )
     */
    public function show($id)
    {
        try {
            $serveis=Servei::findOrFail($id);
            return response()->json(['status'=>'success', 'result' => $serveis],200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status'=>'error', 'result' => 'No s\'ha trobat aquest servei'],404);
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
     *     path="/serveis/put/{id}",
     *     summary="Actualitza un servei",
     *     tags={"Serveis"},
     *     @OA\Parameter(
     *     description="ID del servei",
     *     in="path",
     *     name="id",
     *     required=true,
     *     @OA\Schema(
     *     type="integer"
     *   )
     * ),
     *     @OA\RequestBody(
     *     required=true,
     *     description="Dades del servei",
     *     @OA\JsonContent(
     *     required={"ID_SERVEI","NOM_SERVEI"},
     *     @OA\Property(property="ID_SERVEI", type="integer"),
     *     @OA\Property(property="NOM_SERVEI", type="string")
     *   )
     * ),
     *     @OA\Response(
     *     response=200,
     *     description="Servei actualitzat",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Servei")
     *   )
     * ),
     *      @OA\Response(
     *     response=400,
     *     description="Error d'actualització",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Error")
     *  )
     * )
     * )
     */
    public function update(Request $request, $id)
    {
        $reglesvalidacio = [
            'ID_SERVEI' => 'required|integer',
            'NOM_SERVEI' => 'required|string|max:50'
        ];
        $missatges = [
            'ID_SERVEI.required' => 'El camp ID_SERVEI és obligatori.',
            'ID_SERVEI.integer' => 'El camp ID_SERVEI ha de ser un número enter.',
            'NOM_SERVEI.required' => 'El camp NOM_SERVEI és obligatori.',
            'NOM_SERVEI.string' => 'El camp NOM_SERVEI ha de ser una cadena de caràcters.',
            'NOM_SERVEI.max' => 'El camp NOM_SERVEI no pot tenir més de 50 caràcters.'
        ];
        $validacio = Validator::make($request->all(), $reglesvalidacio, $missatges);
        $tuples=Servei::where('ID_SERVEI', $id)->update($request->except(['_token']));
        if ($validacio->fails()) {
            return response()->json([
                'error' => $validacio->errors()->all()
            ]);
         } else {
            return response()->json([
                'success' => 'Servei modificat correctament.'
            ]);
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Delete(
     *     path="/serveis/destroy/{id}",
     *     summary="Elimina un servei",
     *     tags={"Serveis"},
     *     @OA\Parameter(
     *     description="ID del servei",
     *     in="path",
     *     name="id",
     *     required=true,
     *     @OA\Schema(
     *     type="integer"
     *   )
     * ),
     *     @OA\Response(
     *     response=200,
     *     description="Servei eliminat correctament",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Servei")
     *   )
     * ),
     *      @OA\Response(
     *     response=400,
     *     description="Error d'eliminació",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Error")
     *  )
     * )
     * )
     */
    public function destroy($id)
    {
        try {
            $tuples = Servei::where('ID_SERVEI', $id)->delete();
            return  response()->json([
                'success' => 'Servei eliminat correctament.'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'No s\'ha pogut eliminar el servei.'
            ]);
             }
    }
}
