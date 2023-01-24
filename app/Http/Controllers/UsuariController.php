<?php

namespace App\Http\Controllers;

use App\Models\Usuari;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(name="Usuaris")
 */
class UsuariController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *     path="/usuaris",
     *     summary="Llista tots els usuaris",
     *     tags={"Usuaris"},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="result", type="array",@OA\Items(
     *                 @OA\Property(property="ID_USUARI", type="integer", example=1),
     *                 @OA\Property(property="DNI", type="string", example="12345678Z"),
     *                 @OA\Property(property="NOM_COMPLET", type="string", example="Pere Pujol"),
     *                 @OA\Property(property="CORREU_ELECTRONIC", type="string", example=" patata@gmail.com")
     *            ))
     *        )
     *    ),
     *     @OA\Response(
     *     response=401,
     *     description="Unauthorized",
     *     @OA\JsonContent(
     *     @OA\Property(property="status", type="string", example="Unauthorized")
     *    )
     * )
     * )
     */
    public function index()
    {
        $tuples=Usuari::all();
         return response()->json(['status'=>'success', 'result' => $tuples],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Post(
     *     path="/usuaris",
     *     summary="Crear un usuari",
     *     tags={"Usuaris"},
     *     @OA\RequestBody(
     *         description="Usuari a crear",
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="DNI", type="string", example="12345678Z"),
     *             @OA\Property(property="NOM_COMPLET", type="string", example="Pere Pujol"),
     *             @OA\Property(property="CORREU_ELECTRONIC", type="string", example="patata@gmail.com"),
     *        @OA\Property(property="CONTRASENYA", type="string", example="patata"),
     *     @OA\Property(property="TELEFON", type="string", example="123456789"),
     *     @OA\Property(property="ADMINISTRADOR", type="boolean", example="false")
     *        )
     *    ),
     *     @OA\Response(
     *     response=201,
     *     description="Creat correctament",
     *     @OA\JsonContent(
     *     @OA\Property(property="status", type="string", example="success"),
     *     @OA\Property(property="result", type="array",@OA\Items(
     *     @OA\Property(property="ID_USUARI", type="integer", example=1),
     *     @OA\Property(property="DNI", type="string", example="12345678Z"),
     *     @OA\Property(property="NOM_COMPLET", type="string", example="Pere Pujol"),
     *     @OA\Property(property="CORREU_ELECTRONIC", type="string", example="patata@gmail.com"),
     *     @OA\Property(property="CONTRASENYA", type="string", example="patata"),
     *     @OA\Property(property="TELEFON", type="string", example="123456789"),
     *     @OA\Property(property="ADMINISTRADOR", type="boolean", example="false")
     *   ))
     * )
     * ),
     *     @OA\Response(
     *     response=401,
     *     description="No autoritzat",
     *     @OA\JsonContent(
     *     @OA\Property(property="status", type="string", example="Unauthorized")
     *   )
     * )
     * )
     */
    public function store(Request $request)
    {
        $reglesvalidacio = [
            'ID_USUARI' => 'required|integer',
            'DNI' => 'required|string|max:9',
            'NOM_COMPLET' => 'required|string|max:50',
            'CORREU_ELECTRONIC' => 'required|string|max:50',
            'CONTRASENYA' => 'required|string|max:50',
            'TELEFON' => 'required|string|max:9',
            'ADMINISTRADOR' => 'required|boolean'
        ];
        $missatges = [
            'ID_USUARI.required' => 'El camp ID_USUARI és obligatori.',
            'ID_USUARI.integer' => 'El camp ID_USUARI ha de ser un número enter.',
            'DNI.required' => 'El camp DNI és obligatori.',
            'DNI.string' => 'El camp DNI ha de ser una cadena de caràcters.',
            'DNI.max' => 'El camp DNI no pot tenir més de 9 caràcters.',
            'NOM_COMPLET.required' => 'El camp NOM_COMPLET és obligatori.',
            'NOM_COMPLET.string' => 'El camp NOM_COMPLET ha de ser una cadena de caràcters.',
            'NOM_COMPLET.max' => 'El camp DNI no pot tenir més de 50 caràcters.',
            'CORREU_ELECTRONIC.required' => 'El camp CORREU_ELECTRONIC és obligatori.',
            'CORREU_ELECTRONIC.string' => 'El camp CORREU_ELECTRONICA ha de ser una cadena de caràcters.',
            'CORREU_ELECTRONIC.max' => 'El camp DNI no pot tenir més de 50 caràcters.',
            'TELEFON.required' => 'El camp TELEFON és obligatori.',
            'TELEFON.string' => 'El camp TELEFON ha de ser una cadena de caràcters.',
            'TELEFON.max' => 'El camp DNI no pot tenir més de 9 caràcters.',
            'ADMINISTRADOR.required' => 'El camp ADMINISTRADOR és obligatori.',
            'ADMINISTRADOR.boolean' => 'El camp ADMINISTRADOR ha de ser un booleà.'
        ];
        $validacio = Validator::make($request->all(), $reglesvalidacio, $missatges);
        if ($validacio->fails()) {
            return response()->json($validacio->errors(), 400);
        } else {
        $usuaris= new Usuari;
        $usuaris->ID_USUARI=$request->input('ID_USUARI');
        $usuaris->DNI=$request->input('DNI');
        $usuaris->NOM_COMPLET=$request->input('NOM_COMPLET');
        $usuaris->CORREU_ELECTRONIC=$request->input('CORREU_ELECTRONIC');
        $usuaris->CONTRASENYA=$request->input('CONTRASENYA');
        $usuaris->TELEFON=$request->input('TELEFON');
        $usuaris->ADMINISTRADOR=$request->input('ADMINISTRADOR');
        $usuaris->save();
        return response()->json(['status'=>'success','result'=>$usuaris], 201);
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
     *     path="/usuaris/{id}",
     *     summary="Mostra un usuari",
     *     tags={"Usuaris"},
     *     description="Mostra un usuari",
     *     @OA\Parameter(
     *     description="ID del usuari",
     *     in="path",
     *     name="id",
     *     required=true,
     *     @OA\Schema(
     *     type="integer"
     *       )
     *        )
     * @OA\Response(
     *     response=200,
     *     description="Mostra un usuari",
     *     @OA\JsonContent(
     *     @OA\Property(property="status", type="string", example="success"),
     *     @OA\Property(property="result", type="object", ref="#/components/schemas/Usuari")
     *  )
     * ), @OA\Response(
     *     response=404,
     *     description="No s'ha trobat l'usuari",
     *     @OA\JsonContent(
     *     @OA\Property(property="status", type="string", example="error"),
     *     @OA\Property(property="result", type="string", example="No s'ha trobat l'usuari")
     * )
     * )
     *
     *
     *     )
     *
     */
    public function show($id)
    {
        try {
            $usuaris=Usuari::findOrFail($id);
            return response()->json(['status'=>'success', 'result' => $usuaris],200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status'=>'error', 'result' => 'No s\'ha trobat l\'usuari'],404);
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
    public function update(Request $request, $id)
    {
        $reglesvalidacio = [
            'ID_USUARI' => 'required|integer',
            'DNI' => 'required|string|max:9',
            'NOM_COMPLET' => 'required|string|max:50',
            'CORREU_ELECTRONIC' => 'required|string|max:50',
            'CONTRASENYA' => 'required|string|max:50',
            'TELEFON' => 'required|string|max:9',
            'ADMINISTRADOR' => 'required|boolean'
        ];
        $missatges = [
            'ID_USUARI.required' => 'El camp ID_USUARI és obligatori.',
            'ID_USUARI.integer' => 'El camp ID_USUARI ha de ser un número enter.',
            'DNI.required' => 'El camp DNI és obligatori.',
            'DNI.string' => 'El camp DNI ha de ser una cadena de caràcters.',
            'DNI.max' => 'El camp DNI no pot tenir més de 9 caràcters.',
            'NOM_COMPLET.required' => 'El camp NOM_COMPLET és obligatori.',
            'NOM_COMPLET.string' => 'El camp NOM_COMPLET ha de ser una cadena de caràcters.',
            'NOM_COMPLET.max' => 'El camp DNI no pot tenir més de 50 caràcters.',
            'CORREU_ELECTRONIC.required' => 'El camp CORREU_ELECTRONIC és obligatori.',
            'CORREU_ELECTRONIC.string' => 'El camp CORREU_ELECTRONICA ha de ser una cadena de caràcters.',
            'CORREU_ELECTRONIC.max' => 'El camp DNI no pot tenir més de 50 caràcters.',
            'TELEFON.required' => 'El camp TELEFON és obligatori.',
            'TELEFON.string' => 'El camp TELEFON ha de ser una cadena de caràcters.',
            'TELEFON.max' => 'El camp DNI no pot tenir més de 9 caràcters.',
            'ADMINISTRADOR.required' => 'El camp ADMINISTRADOR és obligatori.',
            'ADMINISTRADOR.boolean' => 'El camp ADMINISTRADOR ha de ser un booleà.'
        ];
        $validacio = Validator::make($request->all(), $reglesvalidacio, $missatges);
        $tuples=Uusari::where('ID_USUARI', $id)->update($request->except(['_token']));
        if ($validacio->fails()) {
            return response()->json([
                'error' => $validacio->errors()->all()
            ]);
         } else {
            return response()->json([
                'success' => 'Usuari modificat correctament'
            ]);
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $tuples =Usuari::where('ID_USUARI', $id)->delete();
            return  response()->json([
                'success' => 'Usuari eliminat correctament.'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'No s\'ha pogut eliminar l\'usuari.'
            ]);
             }
    }
}
